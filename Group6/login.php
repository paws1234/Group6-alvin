<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <h1>Login</h1>
    <?php
    session_start();

    if (isset($_SESSION['login_error'])) {
        echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
        unset($_SESSION['login_error']);
    }
    ?>

    <form method="post" action="process_login.php">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <script>
        
        console.log("User Role: <?php echo isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Unknown'; ?>");
    </script>
</body>
</html>


