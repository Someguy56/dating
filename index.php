<?php
session_start();

/*
    Author: Max Lee
    Version: 2.0
    Date: 4/19/19

    Index page used for routing the other pages and store session data.
 */

//TUrn on error reporting
ini_set('display_errors', true);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');
require_once ('model/validation.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Make arrays of interests to validate against
$f3->set("indoorInterests", ['tv', 'puzzles', 'movies', 'reading', 'cooking', 'playing cards', 'board games', 'video games']);
$f3->set("outdoorInterests", ['hiking', 'walking', 'biking', 'climbing', 'swimming', 'collecting']);

//define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /personal-info', function ($f3)
{
    if(!empty($_POST)) {
        //Get data from form
        $first = $_POST['first'];
        $last = $_POST['last'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        //Add data to hive
        $f3->set('first', $first);
        $f3->set('last', $last);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);
        //If data is valid
        if (validateFirstForm()) {
            //Write data to Session
            $_SESSION['first'] = $first;
            $_SESSION['last'] = $last;
            $_SESSION['age'] = $age;
            $_SESSION['phone'] = $phone;

            if (empty($gender)) {
                $_SESSION['gender'] = "No gender selected";
            }
            else {
                $_SESSION['gender'] = $gender;
            }
            //Redirect to Summary
            $f3->reroute('/profile');
        }
    }

    $view = new Template();
    echo $view->render('views/per-info.html');
});

$f3->route('GET|POST /profile', function ()
{


    $view = new Template();
    echo $view->render('views/profile.html');
});

$f3->route('GET|POST /interests', function () {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['bio'] = $_POST['bio'];
    $_SESSION['seeking'] = $_POST['seeking'];

    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET|POST /summary', function () {
    $_SESSION['indoor'] = $_POST['indoor'];
    $_SESSION['outdoor'] = $_POST['outdoor'];

    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run fat-free
$f3->run();
?>