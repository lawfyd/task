<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link href="/css/style_edit.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                echo "<li ><a href='/feedback'>Отзывы</a></li>";
                if(!isset($_SESSION['user_id'])) {
                    echo "<li ><a href=\"login\">Вход</a></li>";
                }
                else {
                    echo "<li ><a href=\"logout\">Выход</a></li>";
                }
                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">

    <div id="feedList">

        <?php foreach ($feedbackList as $itemFeedback):?>

            <div class="row">
                <div class="col-lg-8">
                    <form enctype="multipart/form-data" method="post" id="feedback-form" action="edit/?id=<?php echo $itemFeedback['id'] ?>">
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $itemFeedback['created_at']; ?></p>
                        Отзыв:
                        <input type="radio" name="status"
                            <?php if ($itemFeedback['inspection'] == 1) echo "checked";?>
                               value="1">Принять
                        <input type="radio" name="status"
                            <?php if ($itemFeedback['inspection'] == 0) echo "checked";?>
                               value="0">Отклонить
                        <br><br>

                        <label for="nameFF">Имя:</label>
                        <input type="text" name="name" id="nameFF" x-autocompletetype="name" value="<?php echo $itemFeedback['name'] ?>" class="w100 border">
                        <br>

                        <!-- Preview Image -->
                        <img class="pull-right" src="<?php echo $itemFeedback['image']; ?>" <?php if ($itemFeedback['image']) echo 'width="100px" height="100px"'?>alt="">

                        <!-- Show/hide checkbox -->
                        <?php
                            if($itemFeedback['image']) {
                                echo '<input type="checkbox" name="photo_delete" value="true">Удалить фото<br>';
                            }
                        ?>

                        <?php
                        if($itemFeedback['image']) {
                            echo '<label for="fileFF">Заменить файл:</label>';
                        }
                        else {
                            echo '<label for="fileFF">Добавить файл:</label>';
                        }
                        ?>

                        <input type="file" name="image" multiple id="image" class="w100">

                        <!-- Post Content -->
                        <label for="messageFF">Сообщение:</label>
                        <textarea name="text" id="message" class="w100 border" rows="5" cols="1" ><?php echo $itemFeedback['text']; ?></textarea>
                        <br>
                        <input class="btn-success" value="Изменить" type="submit" id="submitFF">
                        </form>
                        <hr>
                </div>
            </div>

        <?php endforeach ?>

    </div>
</div>


</div>
<!-- /.container -->

<!-- jQuery -->
<script src="/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<script src="/js/script.js"></script>

</body>

</html>
