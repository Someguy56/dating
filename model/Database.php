<?php

$user = $_SERVER['USER'];
require "/home/$user/config-student.php";

/**
 * SQL STATEMENTS
 *
 * CREATE TABLE member (
    member_id MEDIUMINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    age TINYINT NOT NULL,
    gender VARCHAR(10),
    phone VARCHAR(12) NOT NULL,
    email VARCHAR(255) NOT NULL,
    state VARCHAR(2),
    seeking VARCHAR(12),
    bio VARCHAR(2500),
    premium BOOLEAN NOT NULL,
    image VARCHAR(300)
    );
 * CREATE TABLE interest (
    interest_id MEDIUMINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    interest VARCHAR(50) NOT NULL,
    type VARCHAR(20) NOT NULL
    );
 *CREATE TABLE member_interest (
    member_id MEDIUMINT,
    interest_id MEDIUMINT,
    FOREIGN KEY(member_id) REFERENCES member(member_id),
    FOREIGN KEY(interest_id) REFERENCES interest(interest_id)
);
 */

/**
 * Class Database For connecting to the database
 * @author Max Lee
 * @copyright 5/23/2019
 */
class Database
{
    private $_dbh;

    /**
     * Database constructor.
     * @return void
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Establishes a connection to the database for later use
     * @return void;
     */
    function connect()
    {
        try {
            //Instantiate a db project
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected!!!";
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    /**
     * Inserts a member of the dating site into the database.
     * @return void;
     */
    function insertMember()
    {
        global $f3;
        $member = $f3->get('member');

        $sql = "INSERT INTO member(fname, lname, age, gender, phone, email, state, seeking, bio, premium) 
        VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':fname', $member->getFname(), PDO::PARAM_STR);
        $statement->bindParam(':lname', $member->getLname(), PDO::PARAM_STR);
        $statement->bindParam(':age', $member->getAge(), PDO::PARAM_STR);
        $statement->bindParam(':gender', $member->getGender(), PDO::PARAM_STR);
        $statement->bindParam(':phone', $member->getPhone(), PDO::PARAM_STR);
        $statement->bindParam(':email', $member->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':state', $member->getState(), PDO::PARAM_STR);
        $statement->bindParam(':seeking', $member->getSeeking(), PDO::PARAM_STR);
        $statement->bindParam(':bio', $member->getBio(), PDO::PARAM_STR);

        if($member instanceof PremiumMember)
        {
            $statement->bindParam(':premium', true, PDO::PARAM_INT);
        }
        else
        {
            $statement->bindParam(':premium', false, PDO::PARAM_INT);
        }

        $statement->execute();

        if($member instanceof PremiumMember)
        {
            $lastMemberID = $this->_dbh->lastInsertId();
            foreach ($member->getOutDoorInterests() as $interest)
            {
                $this->insertInterest($interest, $lastMemberID);
            }
            foreach ($member->getInDoorInterests() as $interest)
            {
                $this->insertInterest($interest, $lastMemberID);
            }
        }
    }

    /**
     * A private method to insert an interest into the connection table member-interest
     * @param String $interest The interest being looked for in the interest table
     * @param int $lastMemberID ID of the last inserted member
     * @return void
     */
    private function insertInterest($interest, $lastMemberID)
    {
        $sqlInterests = "INSERT INTO member_interest(member_id, interest_id) 
                VALUES (:member_id, :interest_id)";
        $statementInterest = $this->_dbh->prepare($sqlInterests);
        $statementInterest->bindParam(':member_id', $lastMemberID, PDO::PARAM_INT);

        $sqlIntID = "SELECT interest_id FROM interest WHERE interest = :interest";
        $statementIntID = $this->_dbh->prepare($sqlIntID);
        $statementIntID->bindParam(':interest', $interest, PDO::PARAM_STR);
        $statementIntID->execute();
        $intID = $statementIntID->fetch(PDO::FETCH_NUM);

        $statementInterest->bindParam(':interest_id', $intID, PDO::PARAM_INT);
        $statementInterest->execute();
    }

    /**
     * Gets all current members
     * @return array mixed An assoc array to hold all the info on the members
     */
    function getMembers()
    {
        $sql = "SELECT * FROM member";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    /**
     * Gets 1 member's info
     * @param String $member_id id of the member
     * @return array mixed an array of the specific members info
     */
    function getMember($member_id)
    {
        $sql = "SELECT * FROM member WHERE member_id = :member_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    /**
     * Gets the interests of the member
     * @param String $member_id The id of the member
     * @return array mixed Gets the interests of the member
     */
    function getInterests($member_id)
    {
        $sql = "SELECT interest.interest FROM member_interest INNER JOIN interest ON 
        member_interest.interest_id=interest.interest_id WHERE member_interest.member_id = :member_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}