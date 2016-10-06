<?php

// подключаем файлы ядра

require_once dirname(__FILE__) . '/../config/db.php';
require_once 'core/view.php';
require_once 'core/controller.php';


require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
