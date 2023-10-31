<?php
session_start();
include('includes/db.php');
include('includes/auth.php'); 

class UserDashboard {
    private $conn;
    private $authenticator;  

    public function __construct($db_connection, $userAuthenticator) {
        $this->conn = $db_connection;
        $this->authenticator = $userAuthenticator;
    }

    public function userDashboard() {
        if (!$this->authenticator->isLoggedIn()) {
            header("Location: login.php?error=Unauthorized");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            $this->authenticator->logout();
            header("Location: login.php");
            exit();
        }

        $userID = $this->authenticator->getUserId();
        $query = "SELECT date, computer_count, purpose, status FROM reservations WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $userReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>User Dashboard</title>
            <link rel="stylesheet" type="text/css" href="css/user.css">
            <link rel="icon" href="images/ctu5.png" type="image/x-icon">
        </head>
        <body>
            <h1>User Dashboard</h1>
            <form method="post" action="">
                <button type="submit" name="logout">Logout</button>
                <a href="profile.php"><button class="profile-button" type="button">Profile</button></a>
            </form>
            <h2>Your Reservations</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Computer Count</th>
                    <th>Purpose</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($userReservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['date']) ?></td>
                        <td><?= htmlspecialchars($reservation['computer_count']) ?></td>
                        <td><?= htmlspecialchars($reservation['purpose']) ?></td>
                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <form action="reserve.php">
                <button type="submit">Create Reservation</button>
            </form>
        </body>
        </html>
        <?php
    }
}

$userAuthenticator = new UserAuthenticator($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $userAuthenticator->logout();
}

$userDashboard = new UserDashboard($conn, $userAuthenticator);
$userDashboard->userDashboard();
?>
