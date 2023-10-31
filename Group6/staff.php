<?php
session_start();
include('includes/db.php');
include('includes/auth.php');

class StaffDashboard {
    private $conn;
    private $userAuthenticator;

    public function __construct($db_connection, $userAuthenticator) {
        $this->conn = $db_connection;
        $this->userAuthenticator = $userAuthenticator;
    }

    public function displayDashboard() {
        if (!$this->userAuthenticator->isLoggedIn()) {
            header("Location: login.php?error=Unauthorized");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            $this->userAuthenticator->logout();
            header("Location: login.php");
            exit();
        }

        if ($this->userAuthenticator->getUserRole() !== 'staff') {
            $_SESSION['login_error'] = "Access denied for staff members";
            header("Location: login.php");
            exit();
        }

      
        $userID = $this->userAuthenticator->getUserId();


$query = "SELECT r.date, u.username as user, r.computer_count, r.purpose, r.status, r.id
          FROM reservations r
          INNER JOIN users u ON r.user_id = u.id";
try {
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($reservations) === 0) {
        echo "<p>No reservations found.</p>";
    } else {
        echo "<table>";
        echo "<tr>
                    <th>Date</th>
                    <th>Computer Count</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";
        foreach ($reservations as $reservation) {
            echo "<tr>";
            echo "<td>" . $reservation['date'] . "</td>";
            echo "<td>" . $reservation['computer_count'] . "</td>";
            echo "<td>" . $reservation['purpose'] . "</td>";
            echo "<td>" . $reservation['status'] . "</td>";
            echo "<td>
                <form method='post' action='update_status.php'>
                    <input type='hidden' name='reservation_id' value='" . $reservation['id'] . "'>
                    <select name='new_status'>
                        <option value='pending'>Pending</option>
                        <option value='approved'>Approved</option>
                        <option value='rejected'>Denied</option>
                    </select>
                    <button type='submit'>Change Status</button>
                </form>
            </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<form method='post' action=''>
        <button type='submit' name='logout'>Logout</button>
      </form>";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
    }
    public function updateReservationStatus($reservationId, $newStatus) {
        $updateQuery = "UPDATE reservations SET status = :new_status WHERE id = :reservation_id";
        $stmt = $this->conn->prepare($updateQuery);
        $stmt->bindParam(':new_status', $newStatus, PDO::PARAM_STR);
        $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: staff.php");
            exit();
        } else {
            echo "Status update failed. Please try again.";
        }
    }
}

$userAuthenticator = new UserAuthenticator($conn);
$staffDashboard = new StaffDashboard($conn, $userAuthenticator);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $userAuthenticator->logout();
}

$staffDashboard->displayDashboard();