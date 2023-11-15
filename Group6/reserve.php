<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reservation Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="icon" href="images/ctu.png" type="image/x-icon">
</head>

<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen"> 
        <div class="max-w-3xl w-full bg-white p-4 sm:p-8 md:p-12 lg:p-16 rounded shadow-md" style="padding: 2%;"> 
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-semibold text-center mb-4">Reservation Form</h1> 

            <form method="post" action="process_reservation.php" class="mx-auto max-w-md px-4"> 
                <label for="date" class="text-gray-700 font-semibold text-base sm:text-lg">Date and Time:</label> 
                <input type="datetime-local" id="date" name="date" required class="w-full border border-gray-300 rounded-md py-2 px-3 mb-3 text-base sm:text-lg"> 

                <label for="computer_count" class="text-gray-700 font-semibold text-base sm:text-lg">Number of Computers:</label> 
                <input type="number" id="computer_count" name="computer_count" min="1" max="40" required class="w-full border border-gray-300 rounded-md py-2 px-3 mb-3 text-base sm:text-lg"> 

                <label for="purpose" class="text-gray-700 font-semibold text-base sm:text-lg">Purpose:</label> 
                <textarea id="purpose" name="purpose" required class="w-full border border-gray-300 rounded-md py-2 px-3 mb-3 text-base sm:text-lg"></textarea> 

                <button type="submit" class="w-full bg-blue-500 hover.bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-base sm:text-lg mb-3">Submit Reservation</button> 
                <button onclick="window.location.href='user.php'" class="w-full bg-blue-500 hover.bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-base sm:text-lg">Go to User Page</button>
            </form>
        </div>
    </div>
</body>

</html>

