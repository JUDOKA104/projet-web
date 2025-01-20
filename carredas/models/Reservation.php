<?php
class Reservation
{
    private $id;
    private $userName;
    private $email;
    private $concertDate;
    private $concertTime;

    public function __construct($userName, $email, $concertDate, $concertTime, $id = null)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->email = $email;
        $this->concertDate = $concertDate;
        $this->concertTime = $concertTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getConcertDate()
    {
        return $this->concertDate;
    }

    public function getConcertTime()
    {
        return $this->concertTime;
    }
}