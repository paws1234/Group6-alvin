<!DOCTYPE html>
<html>
<head>
    <title>Reservation Form</title>
    <link rel="stylesheet" type="text/css" href="css/reserve.css">
    <link rel="icon" href="images/ctu5.png" type="image/x-icon">
</head>
<body>
    <h1>Reservation Form</h1>
    
    <form method="post" action="process_reservation.php">
        <label for="date">Date and Time:</label>
        <input type="datetime-local" id="date" name="date" required><br>

        <label for="computer_count">Number of Computers:</label>
        <input type="number" id="computer_count" name="computer_count" min="1" max="40" required><br>

        <label for="purpose">Purpose:</label>
        <textarea id="purpose" name="purpose" required></textarea><br>

        <button type="submit">Submit Reservation</button>
    </form>
</body>
</html>
