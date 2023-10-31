<?php
session_start();
include('includes/db.php');

class UserRegistration {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function setSessionCookieParams() {
        $sessionParams = session_get_cookie_params();
        session_set_cookie_params(
            $sessionParams["lifetime"],
            $sessionParams["path"],
            $sessionParams["domain"],
            true,
            true
        );
    }

    public function registerUser($username, $password, $confirmPassword) {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $username) && strlen($password) >= 8 && $password === $confirmPassword) {
            if (extension_loaded('sodium')) {
                $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
                $opsLimit = defined('SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE') ? SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE : SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE;
                $memLimit = defined('SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE') ? SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE : SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE;
                $hashedPassword = sodium_crypto_pwhash_str(
                    $password,
                    $opsLimit,
                    $memLimit
                );
                if ($hashedPassword !== false) {
                    try {
                        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
                        $stmt = $this->conn->prepare($query);
                        $stmt->execute([$username, $hashedPassword]);
                        session_regenerate_id(true);
                        header("Location: login.php");
                        exit();
                    } catch (PDOException $e) {
                        echo "Registration failed. Please try again.";
                    }
                } else {
                    echo "Password hashing failed.";
                }
            } else {
                echo "Sodium extension is not available. Please install and enable it to use password hashing.";
            }
        } else {
            $_SESSION['registration_error'] = "Invalid username or password for registration. Username should only contain alphanumeric characters and underscore, and the password should be at least 8 characters long and match the confirmation password.";
            header("Location: registration.php");
            exit();
        }
    }
}

$userRegistration = new UserRegistration($conn);
$userRegistration->setSessionCookieParams();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $userRegistration->registerUser($username, $password, $confirmPassword);
}
?>