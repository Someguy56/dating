<?php
session_start();

//TUrn on error reporting
ini_set('display_errors', true);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//define a default route
$f3->route('GET /', function () {
    //echo '<h1>Hello World!</h1>';
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /personal-info', function () {
    //echo '<h1>Hello World!</h1>';
    $view = new Template();
    echo $view->render('views/per-info.html');
});

//Run fat-free
$f3->run();
?>