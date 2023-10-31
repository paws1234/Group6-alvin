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
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="icon" href="images/ctu5.png" type="image/x-icon">
</head>
<body>
    <h1>User Profile</h1>
    <p>Welcome, <?php echo htmlspecialchars($userInfo['username']); ?>!</p>
    <h2>Username</h2>
    <p>Username: <?php echo htmlspecialchars($userInfo['username']); ?></p>
    <h2>Change Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" required>
        <br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <input type="submit" name="change_password" value="Change Password">
    </form>

    <p><a href="user.php">Return to User Dashboard</a></p>
</body>
</html>
