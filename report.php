<?php
session_start();


// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit();
}

include 'db.php'; // Include your database connection

// Initialize variables for selected month and year
$selectedYear = 2024;

// Fetch most popular food items
$popularFoodQuery = "SELECT m.Name, SUM(oi.Quantity) as TotalQuantity 
                     FROM OrderItems oi 
                     JOIN MenuItem m ON oi.Menu_ID = m.Menu_ID 
                     JOIN Orders o ON oi.Order_ID = o.Order_ID
                     WHERE YEAR(o.Order_Date) = :selectedYear
                     GROUP BY m.Name
                     ORDER BY TotalQuantity DESC
                     LIMIT 5"; // Limit to top 5 most popular items
$popularFoodStmt = $pdo->prepare($popularFoodQuery);
$popularFoodStmt->execute(['selectedYear' => $selectedYear]);
$popularFoodResults = $popularFoodStmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch reservation counts by month
$reservationCountQuery = "SELECT DATE_FORMAT(ReserveDate, '%Y-%m') as ReserveMonth, COUNT(*) as ReservationCount 
                          FROM reservation 
                          WHERE YEAR(ReserveDate) = :selectedYear
                          GROUP BY ReserveMonth 
                          ORDER BY ReserveMonth";
$reservationCountStmt = $pdo->prepare($reservationCountQuery);
$reservationCountStmt->execute(['selectedYear' => $selectedYear]);
$reservationCountResults = $reservationCountStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report - Admin Dashboard</title>
    <link rel="stylesheet" href="stylesreport.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h1>REPORT</h1>
            </div>
            <div class="user-info">
                <span>Admin</span>
            </div>
        </header>
        <div class="charts-container">
            <div class="chart-box">
                <h3>Most Popular Food Items in <?php echo $selectedYear; ?></h3>
                <canvas id="popularFoodChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Reservation Counts by Month in <?php echo $selectedYear; ?></h3>
                <canvas id="reservationCountChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Most Popular Food Items Chart
        const popularFoodCtx = document.getElementById('popularFoodChart').getContext('2d');
        const popularFoodData = {
            labels: <?php echo json_encode(array_column($popularFoodResults, 'Name')); ?>,
            datasets: [{
                label: 'Total Quantity Ordered',
                data: <?php echo json_encode(array_column($popularFoodResults, 'TotalQuantity')); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };
        const popularFoodChart = new Chart(popularFoodCtx, {
            type: 'bar',
            data: popularFoodData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Reservation Counts by Month Chart
        const reservationCountCtx = document.getElementById('reservationCountChart').getContext('2d');
        const reservationCountData = {
            labels: <?php echo json_encode(array_column($reservationCountResults, 'ReserveMonth')); ?>,
            datasets: [{
                label: 'Number of Reservations',
                data: <?php echo json_encode(array_column($reservationCountResults, 'ReservationCount')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        const reservationCountChart = new Chart(reservationCountCtx, {
            type: 'bar',
            data: reservationCountData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
