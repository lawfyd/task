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
    

    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/modal_form.css" rel="stylesheet">

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
                    if(!isset($_SESSION['user_id'])) {
                        echo "<li ><a href=\"feedback/login\">Вход</a></li>";
                    }
                    else {
                        echo "<li ><a href=\"feedback/logout\">Выход</a></li>";
                        echo "<li ><a href=\"feedback/edit\">Админ панель</a></li>";
                       
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
    <div class="sort">
        Sort by:<strong>name</strong>(<span id="name_a">From A to Z</span> / <span id="name_d">From Z to A</span>);
        <strong>e-mail</strong> <span id="email_a">(increase </span> / <span id="email_d">decrease)</span>;
        <strong>date</strong><span id="date_a">(increase </span> / <span id="date_d">decrease)</span>
    </div>
    <div id="feedList">
    <?php foreach ($feedbackList as $itemFeedback):?>
        <div class="row">
            <div class="col-lg-8">
                <?php
                    if($itemFeedback['change_admin']) {
                        echo '<p class="glyphicon glyphicon-ok-circle"></p> Change by Admin';
                    }
                    ?>

                <p class="lead">
                    by <?php echo $itemFeedback['name']?>
                </p>

                <!-- Preview Image -->
                <img class="img-responsive" src="<?php echo $itemFeedback['image']; ?>" alt="">

                <!-- Post Content -->
                <p class="text"><?php echo $itemFeedback['text']; ?></p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $itemFeedback['created_at']; ?></p>

                <hr>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<form enctype="multipart/form-data" method="post" id="feedback-form" action="feedback/save">
    <label for="nameFF">Имя:</label>
    <input type="text" name="name" id="nameFF" required placeholder="например, Иван Иванович Иванов" x-autocompletetype="name" class="w100 border">
    <label for="contactFF">Email:</label>
    <input type="email" name="email" id="contactFF" required placeholder="например, ivan@yandex.ru" x-autocompletetype="email" class="w100 border">
    <label for="fileFF">Прикрепить файл:</label>
    <input type="file" name="image" multiple id="image" class="w100">
    <label for="messageFF">Сообщение:</label>
    <textarea name="message" id="message" required rows="5" placeholder="Детали заявки…" class="w100 border"></textarea>
    <br>
    <input value="Отправить" type="submit" id="submitFF">
    <input type="submit" class="mainButton" id="buttonFF" href="#modal" value="Предварительный просмотр">

</form>

<div id="modal_form">
    <span id="modal_close">X</span>
    <div class="container">
        <div id="feedList">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="lead">
                            Author: <span id="name"> <span>
                        </p>

                        <!-- Preview Image -->
                        <img class="img-responsive" src="/images/default.png" alt="">

                        <!-- Post Content -->
                        <p id="text">text</p>
                        <span class="glyphicon glyphicon-time"></span> <span id="date">11</span>

                    </div>
                </div>
        </div>
    </div>

</div>
<div id="overlay"></div><!-- Пoдлoжкa -->
    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Your Website 2014</p>
            </div>
        </div>
        <!-- /.row -->
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<script src="/js/script.js"></script>
<script src="/js/modal_jq_script.js"></script>

</body>

</html>
