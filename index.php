<?php

//Require autoload file
require_once('vendor/autoload.php');

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

require_once('model/validation.php');

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

$db = new Database();

$f3->route('GET|POST /personal-info', function ($f3)
{
    if(!empty($_POST)) {
        //Get data from form
        $first = $_POST['first'];
        $last = $_POST['last'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $membership = $_POST['membership'];

        //Add data to hive
        $f3->set('first', $first);
        $f3->set('last', $last);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);
        $f3->set('membership', $membership);

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

            if($membership === "premium")
            {
                $member = new PremiumMember($first, $last, $age, $gender, $phone);
            }
            else
            {
                $member = new Member($first, $last, $age, $gender, $phone);
            }
            $_SESSION['member'] = $member;

            $f3->reroute('/profile');
        }
    }

    $view = new Template();
    echo $view->render('views/per-info.html');
});

$f3->route('GET|POST /profile', function ($f3)
{
    if(!empty($_POST)) {
        //Get data from form
        $email = $_POST['email'];
        $state = $_POST['state'];
        $bio = $_POST['bio'];
        $seeking = $_POST['seeking'];

        //Add data to hive
        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('bio', $bio);
        $f3->set('seeking', $seeking);

        //If data is valid
        if (validateSecondForm()) {
            //Write data to Session
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;

            if (empty($bio)) {
                $_SESSION['bio'] = "No biography";
            }
            else {
                $_SESSION['bio'] = $bio;
            }

            if (empty($seeking)) {
                $_SESSION['seeking'] = "Not seeking any";
            }
            else {
                $_SESSION['seeking'] = $seeking;
            }

            $member = $_SESSION['member'];
            $member->setEmail($email);
            $member->setState($state);
            $member->setBio($bio);
            $member->setSeeking($seeking);
            $_SESSION['member'] = $member;

            if($member instanceof PremiumMember)
            {
                $f3->reroute('/interests');
            }

            $f3->reroute('/summary');
        }
    }

    $view = new Template();
    echo $view->render('views/profile.html');
});

$f3->route('GET|POST /interests', function ($f3)
{
    if(!empty($_POST)) {
        //Get data from form
        $indoor = $_POST['indoor'];
        $outdoor = $_POST['outdoor'];

        //Add data to hive
        $f3->set('indoor', $indoor);
        $f3->set('outdoor', $outdoor);

        //If data is valid
        if (validateInterestsForm()) {
            //Write data to Session
            if (empty($indoor)) {
                $_SESSION['indoor'] = ["no indoor interests"];
            }
            else {
                $_SESSION['indoor'] = $indoor;
            }

            if (empty($outdoor)) {
                $_SESSION['outdoor'] = ["no outdoor interests"];
            }
            else {
                $_SESSION['outdoor'] = $outdoor;
            }

            $_SESSION['member']->setInDoorInterests($indoor);
            $_SESSION['member']->setOutDoorInterests($outdoor);

            $f3->reroute('/summary');
        }
    }

    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET|POST /summary', function ($f3)
{
    $f3->set("member", $_SESSION['member']);
    global $db;
    $db->insertMember();

    $view = new Template();
    echo $view->render('views/summary.html');
});

$f3->route('GET|POST /admin', function($f3)
{
    global $db;
    $f3->set('db', $db);
    $f3->set('members', $db->getMembers());
    $view = new Template();
    echo $view->render('views/admin.html');
});

//Run fat-free
$f3->run();
?>