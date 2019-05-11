<?php

/**
 * Class PremiumMember represents a premium member of my dating site
 * @author Max Lee
 * @copyright 5/9/19
 */
class PremiumMember extends Member
{
    private $_inDoorInterests, $_outDoorInterests;

    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone);
    }

    /**
     * Gets the indoor interests of the member
     * @return mixed an array of interests
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * Sets the indoor interests of the member
     * @param mixed $inDoorInterests an array of indoor interests
     * @return void
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * Gets the outdoor interests of the member
     * @return mixed an array of outdoor interests
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Sets the outdoor interests for the member
     * @param mixed $outDoorInterests an array of interests
     * @return void
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }
}
?>