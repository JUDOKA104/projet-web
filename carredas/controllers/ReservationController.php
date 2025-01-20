<?php
require_once 'config/bdd.php';
require_once 'models/Reservation.php';

class ReservationController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addReservation();
        } else {
            $this->listReservations();
        }
    }

    private function addReservation()
    {
        $userName = $_POST['user_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $concertDate = $_POST['concert_date'] ?? '';
        $concertTime = $_POST['concert_time'] ?? '';

        if ($userName && $email && $concertDate && $concertTime) {
            $stmt = $this->db->prepare("INSERT INTO reservations (user_name, email, concert_date, concert_time) VALUES (?, ?, ?, ?)");
            $stmt->execute([$userName, $email, $concertDate, $concertTime]);
            echo "Reservation added successfully!";
        } else {
            echo "Please provide valid data!";
        }
    }

    private function listReservations()
    {
        $stmt = $this->db->query("SELECT * FROM reservations");
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Reservation List</h1>";
        echo "<ul>";
        foreach ($reservations as $reservation) {
            echo "<li>{$reservation['user_name']} - {$reservation['email']} - {$reservation['concert_date']} {$reservation['concert_time']}</li>";
        }
        echo "</ul>";

        echo "<form method='POST'>
                <input type='text' name='user_name' placeholder='Name'>
                <input type='email' name='email' placeholder='Email'>
                <input type='date' name='concert_date'>
                <input type='time' name='concert_time'>
                <button type='submit'>Add Reservation</button>
              </form>";
    }
}