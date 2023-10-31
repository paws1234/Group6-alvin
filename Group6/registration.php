<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="icon" href="images/ctu5.png" type="image/x-icon">
    <?php
    session_start();
    if (isset($_SESSION['registration_error'])) {
        echo '<div class="error-message">' . $_SESSION['registration_error'] . '</div>';
        unset($_SESSION['registration_error']);
    }
    ?>
</head>
<body>
    <h1>User Registration</h1>
    <form action="process_registration.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
