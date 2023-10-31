<?php
session_start();
require('includes/db.php');
include('includes/auth.php');

class AdminDashboard {
    private $conn;
    private $userAuthenticator; 
    public function __construct($db_connection, $authenticator) {
        $this->conn = $db_connection;
        $this->userAuthenticator = $authenticator;
    }
    public function isAdminLoggedIn() {
        return isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin';
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            session_destroy();
            header("Location: login.php");
            exit();
        }
    }

    public function getReservations() {
        try {
            $query = "SELECT r.date, u.username as user, r.computer_count, r.purpose, r.status, r.id
                      FROM reservations r
                      INNER JOIN users u ON r.user_id = u.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }
}
$userAuthenticator = new UserAuthenticator($conn);
$adminDashboard = new AdminDashboard($conn, $userAuthenticator); 

if (!$adminDashboard->isAdminLoggedIn()) {
    header("Location: login.php");
    exit();
}

$adminDashboard->logout();
$reservations = $adminDashboard->getReservations();

function admindashboard($reservations) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" type="text/css" href="css/admin.css">
        <link rel="icon" href="images/ctu5.png" type="image/x-icon">
    </head>
    <body>
        <h1>Admin Dashboard</h1>
        <h2>Reservations</h2>
        <form method="post" action="">
            <button type="submit" name="logout">Logout</button>
        </form>
        <table>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Computer Count</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($reservations as $row) { ?>
                <tr>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['user'] ?></td>
                    <td><?= $row['computer_count'] ?></td>
                    <td><?= $row['purpose'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><a href="delete_reservation.php?id=<?= $row['id'] ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </table>
    </body>
    </html>
    <?php
}

admindashboard($reservations);
