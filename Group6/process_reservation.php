<?php
session_start();
include('includes/db.php');
include('includes/auth.php');
include('includes/functions.php');

class ReservationHandler {
    private $conn;
    private $userAuthenticator;

    public function __construct($db_connection, $userAuthenticator) {
        $this->conn = $db_connection;
        $this->userAuthenticator = $userAuthenticator;
    }

    public function handleReservation() {
        if (!$this->userAuthenticator->isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
            $computer_count = htmlspecialchars($_POST['computer_count'], ENT_QUOTES, 'UTF-8');
            $purpose = htmlspecialchars($_POST['purpose'], ENT_QUOTES, 'UTF-8');
            $userID = $this->userAuthenticator->getUserId();

            if (!$this->userAuthenticator->isUserAuthorized($userID, 'user')) {
                $_SESSION['reservation_error'] = "You are not authorized to make reservations.";
                header("Location: reserve.php");
                exit();
            }

            if (!$this->validateReservationDate($date) || !$this->isLabAvailable($date, $computer_count)) {
                $_SESSION['reservation_error'] = "Reservation failed. Please check your inputs and try again.";
                header("Location: reserve.php");
                exit();
            }

            try {
                $query = "INSERT INTO reservations (user_id, date, computer_count, purpose, status) VALUES (:userID, :date, :computer_count, :purpose, 'pending')";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':computer_count', $computer_count, PDO::PARAM_INT);
                $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    header("Location: confirmation.php");
                    exit();
                } else {
                    $_SESSION['reservation_error'] = "Reservation failed. Please check your inputs and try again.";
                    header("Location: reservation.php");
                    exit();
                }
            } catch (PDOException $e) {
                $_SESSION['reservation_error'] = "Reservation failed. Please check your inputs and try again.";
                header("Location: reserve.php");
                exit();
            }
        }
    }

    public function validateReservationDate($date) {
        $currentTimestamp = time();
        $reservationTimestamp = strtotime($date);
        return $reservationTimestamp > $currentTimestamp;
    }

    public function isLabAvailable($date, $computerCount) {
        $query = "SELECT SUM(computer_count) AS total_reserved FROM reservations WHERE date = :date";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalReserved = $result['total_reserved'];
        $maxLabCapacity = 40;

        if ($totalReserved === null) {
            $totalReserved = 0;
        }

        return ($totalReserved + $computerCount) <= $maxLabCapacity;
    }
}

$userAuthenticator = new UserAuthenticator($conn);
$reservationHandler = new ReservationHandler($conn, $userAuthenticator);
$reservationHandler->handleReservation();
?>
