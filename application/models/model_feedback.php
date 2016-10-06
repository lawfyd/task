<?php

class ModelFeedback {

    /**
     * @param bool $id
     * @return array
     */
    public static function getAllInspectedFeedback($id = false) {

        $db = Db::getConnection();
        
        $result = $db->query('SELECT * FROM feedback WHERE inspection = 1 ORDER BY created_at DESC ');

        $feedbackList = ModelFeedback::getArrayFeedback($result);

        return $feedbackList;

    }

    /**
     * сортировка отзывов
     * @param bool $id
     * @return array
     */
    public static function getSortedFeedback($id = false) {


        $db = Db::getConnection();
        $str_request = 'SELECT * FROM feedback WHERE inspection = 1';

        if($id) {
            if($id == 'name_a') {
                $str_request .= ' ORDER BY name ASC';
            }
            else if ($id == 'name_d') {
                $str_request .= ' ORDER BY name DESC';
            }
            else if($id == 'email_a') {
                $str_request .= ' ORDER BY email ASC';
            }
            else if($id == 'email_d') {
                $str_request .= ' ORDER BY email DESC';
            }
            else if($id == 'date_a') {
                $str_request .= ' ORDER BY created_at ASC';

            }
            else if($id == 'date_d') {
                $str_request .= ' ORDER BY created_at DESC';
            }
            $result = $db->query($str_request);

        }

        $feedbackList = ModelFeedback::getArrayFeedback($result);

        return $feedbackList;

    }

    private static function getArrayFeedback($arr) {

        $feedbackList = array();
        $i = 0;
        while($row = $arr->fetch()) {
            $feedbackList[$i]['id'] = $row['id'];
            $feedbackList[$i]['name'] = $row['name'];
            $feedbackList[$i]['text'] = $row['text'];
            $feedbackList[$i]['email'] = $row['email'];
            $feedbackList[$i]['image'] = $row['image'];
            $feedbackList[$i]['inspection'] = $row['inspection'];
            $feedbackList[$i]['created_at'] = $row['created_at'];
            $feedbackList[$i]['change_admin'] = $row['change_admin'];
            $i++;
        }
        return $feedbackList;
    }
    
    public static function getAllUnCheckedFeedback() {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM feedback WHERE inspection <> -1 ORDER BY created_at DESC ');

        $feedbackList = ModelFeedback::getArrayFeedback($result);

        return $feedbackList;
    }

    public static function getOne($id) {

        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM feedback WHERE id = $id LIMIT 1");

        $feedback = ModelFeedback::getArrayFeedback($result);

        return $feedback;

    }

    //check inspection
    public static function action_check_inspection($id, $pdo, $status) {
        $res = intval($status) == 0 ? -1 : 1; // Админ не принял отзыв или принял

        $sql = "UPDATE feedback SET inspection = :inspection
                  WHERE id = $id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':inspection', $res);

        $stmt->execute();
    }
    
    public static function change_admin($id) {
        $pdo = Db::getConnection();
        $sql = "UPDATE feedback SET change_admin = TRUE 
                        WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

   
    
}