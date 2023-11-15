<?php
session_start();
include('includes/db.php');
include('includes/auth.php');

$userAuthenticator = new UserAuthenticator($conn);

class UserProfile {
    private $conn;
    private $userAuthenticator;

    public function __construct($db_connection, $authenticator) {
        $this->conn = $db_connection;
        $this->userAuthenticator = $authenticator;
    }

    public function changePassword() {
        if (!$this->userAuthenticator->isLoggedIn()) {
            header("Location: login.php?error=Unauthorized");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $userID = $this->userAuthenticator->getUserId();

            $query = "SELECT password FROM users WHERE id = :userID";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userInfo) {
                echo "User not found or an error occurred.";
            } else {
                if (sodium_crypto_pwhash_str_verify($userInfo['password'], $oldPassword)) {
                    if (strlen($newPassword) < 8) {
                        echo "New password must be at least 8 characters long.";
                    } else {
                        $opsLimit = SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE;
                        $memLimit = SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE;

                        $hashedPassword = sodium_crypto_pwhash_str(
                            $newPassword,
                            $opsLimit,
                            $memLimit
                        );

                        try {
                            $updateQuery = "UPDATE users SET password = :newPassword WHERE id = :userID";
                            $updateStmt = $this->conn->prepare($updateQuery);
                            $updateStmt->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);
                            $updateStmt->bindParam(':userID', $userID, PDO::PARAM_INT);

                            if ($updateStmt->execute()) {
                                echo "Password updated successfully.";
                            } else {
                                echo "Password update failed. Please try again.";
                            }
                        } catch (PDOException $e) {
                            echo "Database Error: " . $e->getMessage();
                        }
                    }
                } else {
                    echo "Old password is incorrect.";
                }
            }
        }
    }

    public function getUserInfo() {
        $userID = $this->userAuthenticator->getUserId();
        $query = "SELECT username FROM users WHERE id = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$userProfile = new UserProfile($conn, $userAuthenticator);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $userProfile->changePassword();
}

$userInfo = $userProfile->getUserInfo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link rel="icon" href="images/ctu.png" type="image/x-icon">
    <title>User Profile</title>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-start">
        <div class="container mx-auto mt-0 p-4 sm:p-8">
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold text-center mt-0 mb-4">User Profile</h1>

            <div class="flex justify-center">
                <div class="bg-white p-4 sm:p-6 md:p-6 lg:p-8 rounded-md shadow-md w-full sm:max-w-md mx-auto">
                    <div class="text-sm sm:text-base font-semibold text-center mb-4">
                       <p>Welcome, <?php echo htmlspecialchars($userInfo['username']); ?>!</p>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold mb-2">Username</h2>
                    <div class="mb-2">
                        <p class="text-gray-700 text-sm sm:text-base"><?php echo htmlspecialchars($userInfo['username']); ?></p>
                    </div>
                    <h2 class="text-base sm:text-lg font-semibold mb-2">Change Password</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-2">
                            <label for="old_password" class="block text-gray-700 mb-1 text-sm sm:text-base">Old Password:</label>
                            <input type="password" id="old_password" name="old_password" required
                                class="border border-gray-300 px-2 py-1 rounded-md w-full">
                        </div>
                        <div class="mb-2">
                            <label for="new_password" class="block text-gray-700 mb-1 text-sm sm:text-base">New Password:</label>
                            <input type="password" id="new_password" name="new_password" required
                                class="border border-gray-300 px-2 py-1 rounded-md w-full">
                        </div>
                        <div class="text-center">
                            <button type="submit" name="change_password"
                                class="bg-blue-500 text-white text-sm sm:text-base px-3 py-1 rounded-md hover:bg-blue-600">Change
                                Password</button>
                        </div>
                    </form>
                      </div>
            </div>

            <p class="text-center mt-2">
                <a href="user.php" class="text-blue-500 hover:underline text-sm sm:text-base">Return to User Dashboard</a>
            </p>
        </div>
    </div>
</body>

</html>
