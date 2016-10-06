<?php
session_start();
include_once ROOT . "/application/models/model_feedback.php";


class Controller_Feedback extends Controller
{

    public function action_index()
    {
        $feedbackList = ModelFeedback::getAllInspectedFeedback();

        require_once(ROOT . '/application/views/feedback_view.php');
        
        return true;
        //$this->view->generate('feedback_view.php', 'template_view.php');
    }

    public function action_getSort() {
        if (isset($_POST['sort_id'])) {
            
            $id = $_POST['sort_id'];
            $res_sorted = ModelFeedback::getSortedFeedback($id);
            
            //show sorted feedback
            foreach ($res_sorted as $itemFeedback) {
                printf("<p class=\"lead\">by %s </p>
                        <hr>
                        <p><span class=\"glyphicon glyphicon-time\"></span> %s; </p>
                        <hr>
                        <img class=\"img-responsive\" src=\"%s\">
                        <hr>
                        <p class=\"lead\">%s;</p>",
                        $itemFeedback['name'], $itemFeedback['created_at'], $itemFeedback['image'], 
                        $itemFeedback['text']
                );
            }
        }
    }

    public function action_save() {
        $db = Db::getConnection();
        $feed_back = new ModelFeedback();
        if (isset($_POST['name'])) {

            $feed_back->name = $_POST['name'];
            $name = strip_tags($_POST['name']);
            $name = htmlspecialchars($name);
            $feed_back->name = $name;

            $feed_back->text = $_POST['message'];

            $feed_back->email = $_POST['email'];

            $feed_back->inspection = 0;

            if( !empty( $_FILES['image']['name'] ) ) {
                $feed_back->image = Controller_Feedback::upload_img();
            }

            $stmt = $db->prepare("INSERT INTO feedback (name, email, text, image, inspection) 
                                  VALUES (:name, :email, :text, :image, :inspection)");
            $stmt->bindParam(':name', $feed_back->name);
            $stmt->bindParam(':email', $feed_back->email);
            $stmt->bindParam(':text', $feed_back->text);
            $stmt->bindParam(':image', $feed_back->image);
            $stmt->bindParam(':inspection', $feed_back->inspection);

            $stmt->execute();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function action_login() {
        require_once(ROOT . '/application/views/login_view.php');
        return true;
    }

    public function action_logout() {
        session_destroy();

        header('Location: /feedback');
    }

    //admin check
    public function action_check() {

        $db = Db::getConnection();
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $db->query("SELECT id FROM users WHERE username='$username' AND password='$password'");
        $user = $result->fetch();

        if($user) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /feedback');
        }

        else {
            echo 'Wrong password or username';die;
        }
        
    }
    
    public function action_edit() {
        $feedbackList = ModelFeedback::getAllUnCheckedFeedback();

        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            unset($_GET['id']);
            $pdo = Db::getConnection();
            $feedbeck_one = ModelFeedback::getOne($id);

            $name = $feedbeck_one[0]['name'];
            $text = $feedbeck_one[0]['text'];

            //change status
            ModelFeedback::action_check_inspection($id, $pdo, $_POST['status']);

            //delete photo
            if (isset($_POST['photo_delete'])) {
                //delete photo
                $sql = "UPDATE feedback SET image = ''
                        WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                ModelFeedback::change_admin($id);

                $file = ROOT . $feedbeck_one[0]['image'];

                if (!unlink($file))
                {
                    echo ("Error deleting $file");
                } else {
                    header('location:'.$_SERVER['HTTP_REFERER']);
                }
            }

            //change photo
            if(isset($_FILES['image']) && $_FILES['image']['name'] != '') {

                $url_img = Controller_Feedback::upload_img();
                $image = $url_img == '/images/' ? '' : $url_img; // get '' or full url
                $sql = "UPDATE feedback SET image = :image
                        WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);
                $stmt->execute();

                ModelFeedback::change_admin($id);
                //delete photo from server
                $file = ROOT . $feedbeck_one[0]['image'];

                if (!unlink($file))
                {

                    echo ("Error deleting $file");

                } else {
                    //update page
                    //header('location:'.$_SERVER['HTTP_REFERER']);
                }

                //update page
                header('location:'.$_SERVER['HTTP_REFERER']);
            }

            //change by admin name and text
            if($name != $_POST['name'] || $text != $_POST['text']) {
                ModelFeedback::change_admin($id);
            }

        }

        require_once(ROOT . '/application/views/edit_view.php');
    }

    public static function resize($file, $type = 1, $rotate = null, $quality = null) {
        $tmp_path = 'images/';

        // Ограничение по ширине в пикселях
        $max_w = 320;
        $max_h = 240;

        // Качество изображения по умолчанию
        if ($quality == null)
            $quality = 75;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $source = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Поворачиваем изображение
        if ($rotate != null)
            $src = imagerotate($source, $rotate, 0);
        else
            $src = $source;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($src);
        $h_src = imagesy($src);

        // В зависимости от типа (эскиз или большое изображение) устанавливаем ограничение по ширине.
        $w = $max_w;
        $h = $max_h;

        // Если ширина больше заданной
        if ($w_src > $w || $h_src > $h)
        {
            // Вычисление пропорций
            $ratio_w = $w_src/$w;
            $ratio_h = $h_src/$h;
            $w_dest = round($w_src/$ratio_w);
            $h_dest = round($h_src/$ratio_h);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $tmp_path . $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($src);

            return $file['name'];
        }
        else
        {
            // Вывод картинки и очистка памяти
            imagejpeg($src, $tmp_path . $file['name'], $quality);
            imagedestroy($src);

            return $file['name'];
        }
    }

    public static function upload_img() {
        $path = ROOT . '/images';
        //validate image
        $types = array('image/gif', 'image/png', 'image/jpeg', '');
        // Проверяем тип файла
        if (!in_array($_FILES['image']['type'], $types))
            die('Запрещённый тип файла. <a href="/feedback">Попробовать другой файл?</a>');

        $name = Controller_Feedback::resize($_FILES['image']);
        $up_img = '/images' . '/' . $name;
        return $up_img;
    }

    public function action_getModal() {

        if (isset($_POST['name'])) {
            echo 'hello';
        }
    }
}


