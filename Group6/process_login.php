<?php
session_start();
include('includes/db.php');

class LoginHandler {
    private $db;

    public function __construct($db_host, $db_name, $db_user, $db_password) {
        $this->db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $stmt = $this->db->prepare("SELECT id, password, role FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $hashedPassword = $row['password'];

                    $isValidPassword = true;

                    if ($row['role'] === 'admin' || $row['role'] === 'staff' || $row['role'] === 'user') {
                        $isValidPassword = sodium_crypto_pwhash_str_verify($hashedPassword, $password);
                    }

                    if ($isValidPassword) {
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['user_role'] = $row['role'];
                    
                        if ($row['role'] === 'admin') {
                            header("Location: admin.php");
                        } elseif ($row['role'] === 'staff') {
                            header("Location: staff.php");
                        } elseif ($row['role'] === 'user') {
                            header("Location: user.php");
                        } else {
                            $_SESSION['login_error'] = "Invalid role";
                            header("Location: login.php");
                            exit();
                        }
                    } else {
                        $_SESSION['login_error'] = "Invalid username or password";
                        header("Location: login.php");
                        exit();
                    }
                } else {
                    $_SESSION['login_error'] = "Invalid username or password";
                    header("Location: login.php");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }
    }
}

$loginHandler = new LoginHandler($db_host, $db_name, $db_user, $db_password);
$loginHandler->setSessionCookieParams();
$loginHandler->handleLogin();