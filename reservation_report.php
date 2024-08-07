<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit();
}

include 'db.php'; // Include your database connection

// Initialize variables for selected month and year
$selectedMonth = isset($_POST['month']) ? $_POST['month'] : date('Y-m');
$selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

// Fetch reservation report
$reservationQuery = "SELECT r.Reservation_ID, u.Username, r.ReserveDate, r.ReserveTime, r.NumGuests 
                     FROM Reservation r
                     JOIN User u ON r.User_ID = u.User_ID
                     WHERE DATE_FORMAT(r.ReserveDate, '%Y-%m') = :selectedMonth";
$reservationStmt = $pdo->prepare($reservationQuery);
$reservationStmt->execute(['selectedMonth' => $selectedMonth]);
$reservationResults = $reservationStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Report - Admin Dashboard</title>
    <link rel="stylesheet" href="stylesreservereport.css">
    <script>
        function confirmLogout(event) {
            if (!confirm("Are you sure you want to log out?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
  <div class="sidebar">
        <h2>C&O BURGER</h2>
        <a href="menuitem.php">Menu</a>
        <a href="report.php">Report</a>
        <a href="reservation_report.php">Reservation</a>
         <a href="orderhistory.php">Order History</a>
        <a href="registeradmin.php">Add Admin</a>
        <a href="logout.php" onclick="confirmLogout(event)">Logout</a> 

    </div>
    <div class="content">
        <header>
            <div class="header-left">
                <h1>Reservation Report</h1>
            </div>
            <div class="user-info">
                <span>Admin</span>
            </div>
        </header>
        <form method="post" action="reservation_report.php" class="filter-form">
            <label for="month">Select Month:</label>
            <input type="month" id="month" name="month" value="<?php echo htmlspecialchars($selectedMonth); ?>">
            <button type="submit">Filter</button>
        </form>
        <div class="table-container">
            <h3>Reservation Report for <?php echo htmlspecialchars($selectedMonth); ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Username</th>
                        <th>Reserve Date</th>
                        <th>Reserve Time</th>
                        <th>Number of Guests</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservationResults as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['Reservation_ID']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['Username']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['ReserveDate']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['ReserveTime']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['NumGuests']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
