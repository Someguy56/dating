<?php

/*
 * Used to validate the first form the per-info.html page
 * Checks first and last name, age, and phone number
 */
function validateFirstForm()
{
    global $f3;
    $isValid = true;
    if (!validName($f3->get('first'))) {
        $isValid = false;
        $f3->set("errors['first']", "Please enter a valid first name");
    }
    if (!validName($f3->get('last'))) {
        $isValid = false;
        $f3->set("errors['last']", "Please enter a valid last name");
    }
    if (!validAge($f3->get('age'))) {
        $isValid = false;
        $f3->set("errors['age']", "Please enter an age 18 to 118");
    }
    if (!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a valid phone number");
    }
    return $isValid;
}

/*
 * Validates the second page the profile.html page
 * Checks the email
 */
function validateSecondForm()
{
    global $f3;
    $isValid = true;
    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid email");
    }
    return $isValid;
}

/*
 * Validates the third form the interests.html page
 * Checks indoor and outdoor interests
 */
function validateInterestsForm()
{
    global $f3;
    $isValid = true;
    if (!validOutdoor($f3->get('outdoor'))) {
        $isValid = false;
        $f3->set("errors['outdoor']", "Please enter valid outdoor interests");
    }
    if (!validIndoor($f3->get('indoor'))) {
        $isValid = false;
        $f3->set("errors['indoor']", "Please enter valid indoor interests");
    }
    return $isValid;
}

//Checks the name is a valid string
function validName($name)
{
    return !empty($name) && ctype_alpha($name);
}

//Checks if the age is over 18 and less than 118
function validAge($age)
{
    return !empty($age) && ctype_digit($age) && (int)$age >= 18 && (int)$age <= 118;
}

//Checks if the phone number is numeric and 10 numbers
function validPhone($phone)
{
    return ctype_digit($phone) && strlen($phone) === 10;
}

//validates the email using filter_var
function validEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//checks if the outdoor interests were valid selections or if any were selected at all
function validOutdoor($outdoor)
{
    global $f3;
    if(empty($outdoor))
    {
        return true;
    }

    foreach($outdoor as $interest)
    {
        if(!in_array($interest, $f3->get('outdoorInterests')))
        {
            return false;
        }
    }
    return true;
}

//checks if the indoor interests were valid selections or if any were selected at all
function validIndoor($indoor)
{
    global $f3;
    if(empty($indoor))
    {
        return true;
    }

    foreach($indoor as $interest)
    {
        if(!in_array($interest, $f3->get('indoorInterests')))
        {
            return false;
        }
    }
    return true;
}