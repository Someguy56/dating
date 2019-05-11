<?php

/**
 * Class Member represents a basic level member of my dating website
 * @author Max Lee
 * @copyright 5/9/2019
 */
class Member
{
    private $_fname, $_lname, $_age, $_gender, $_phone, $_email, $_state, $_seeking, $_bio;

    /**
     * Gives the member a first name, last name, age, gender, and phone number
     *
     * Member constructor.
     * @param $fname
     * @param $lname
     * @param $age
     * @param $gender
     * @param $phone
     * @return void
     */
    function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    /**
     * Gets the first name of the member
     * @return String first name
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * Sets the first name of the member
     * @param String $fname name of the member
     * @return void
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * Gets the last name of the member
     * @return String last name
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * Sets the last name of the member
     * @param mixed $lname
     * @return void
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * Gets the age of the member
     * @return mixed The age of the member
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Sets the age of the member
     * @param mixed $age the age of the member
     * @return void
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Gets the gender of the member
     * @return mixed The gender of the member: Male or Female
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Sets the gender of the member
     * @param mixed $gender Gender for the member
     * @return void
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Gets the phone number of the member
     * @return mixed 10 digit phone number
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets the phone number of the member
     * @param mixed $phone 10 digit phone number
     * @return void
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Gets the email of the member
     * @return mixed the email of the member
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the email of the member
     * @param mixed $email email for the member
     * @return void
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Gets the state the member lives in
     * @return mixed The state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets the State for the member
     * @param mixed $state The state the member lives in
     * @return void
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * Gets the gender the member is seeking to data
     * @return mixed gender of seeking
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * Sets the seeking gender for the member
     * @param mixed $seeking gender seeking
     * @return void
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * Gets the biography of the member
     * @return mixed biography for the member
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * Sets the bio for the member
     * @param mixed $bio biography
     * @return void
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }
}
?>