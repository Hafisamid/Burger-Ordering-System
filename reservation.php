<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="stylesreserve.css"> <!-- Ensure this path is correct -->
</head>
<body>
    <?php
    session_start();
    include 'db.php'; // Ensure your DB connection settings are correct

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // Redirect if not logged in
        exit;
    }

    $message = ''; // To store the message to be displayed to the user

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $reserveDate = $_POST['datetime']; // Make sure to use the correct field name from your form
        $reserveTime = $_POST['datetime']; // Assuming time is part of the datetime input
        $numGuests = $_POST['numGuests'];
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("INSERT INTO reservation (User_ID, ReserveDate, ReserveTime, NumGuests) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $reserveDate, $reserveTime, $numGuests]);

        if ($stmt->rowCount()) {
            $message = 'Reservation successful!';
        } else {
            $message = 'Failed to make reservation.';
        }

        echo "<script type='text/javascript'>alert('$message'); window.location.href = 'reservation.php';</script>";
    }
    ?>

    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Make a Reservation</h1>
        <form action="reservation.php" method="POST">
            <label for="datetime">Reservation Date and Time:</label>
            <input type="text" id="datetime" name="datetime" placeholder="Select Date and Time" required>
            
            <label for="numGuests">Number of Guests:</label>
            <input type="number" id="numGuests" name="numGuests" min="1" required>
            
            <button type="submit">Submit Reservation</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
</body>
</html>
