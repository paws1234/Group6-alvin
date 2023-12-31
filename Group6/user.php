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
<html lang="en">

<head>
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="icon" href="images/ctu.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100 font-sans p-6 sm:p-12">
    <h1 class="text-xl sm:text-2xl md:text-4xl lg:text-6xl xl:text-6xl font-bold text-center mb-8 sm:mb-12">User Dashboard</h1>
    <form method="post" action="" class="flex justify-center space-x-4 mb-8 sm:mb-16">
        <button type="submit" name="logout"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 sm:py-6 sm:px-10 rounded">Logout</button>
        <a href="profile.php"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 sm:py-6 sm:px-10 rounded">Profile</a>
    </form>

    <h2 class="text-xl sm:text-2xl md:text-4xl lg:text-6xl xl:text-6xl font-semibold mt-8 sm:mt-12 mb-4 sm:mb-6">Your Reservations</h2>
    <div class="overflow-x-auto mt-6 sm:mt-12">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="min-w-full overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-3 sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/5 border">Date</th>
                            <th class="px-6 py-3 sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/5 border">Computer Count</th>
                            <th class="px-6 py-3 sm:w-2/4 md:w-2/4 lg:w-2/4 xl:w-3/5 border">Purpose</th>
                            <th class="px-6 py-3 sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/5 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userReservations as $reservation): ?>
                            <tr>
                                <td class="px-6 py-3 sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/5 border"><?= htmlspecialchars($reservation['date']) ?></td>
                                <td class="px-6 py-3 sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/5 border"><?= htmlspecialchars($reservation['computer_count']) ?></td>
                                <td class="px-6 py-3 sm:w-2/4 md:w-2/4 lg:w-2/4 xl:w-3/5 border"><?= htmlspecialchars($reservation['purpose']) ?></td>
                                <td class="px-6 py-3 sm:w-1/4 md:w-1/4 lg:w-1/4 xl:w-1/5 border
                                    <?= $reservation['status'] === 'pending' ? 'bg-blue-600': ($reservation['status'] === 'approved' ? 'bg-green-500' : 'bg-red-500') ?>">
                                    <?= htmlspecialchars($reservation['status']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="reserve.php" class="text-center mt-6 sm:mt-12">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 sm:py-6 sm:px-10 rounded">Create Reservation</button>
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

