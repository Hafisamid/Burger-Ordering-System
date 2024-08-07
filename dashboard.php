<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="stylesdashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>C&O BURGER</h2>
      <!--  <a href="dashboard.php">Dashboard</a>-->
        <a href="report.php">Report</a>
        <a href="menuitem.php">Menu</a>
        
        
    </div>
    <div class="content">
        <header>
            <h1>ADMIN DASHBOARD</h1>
            <div class="user-info">
                <img src="admin_icon.png" alt="Admin Icon">
                <span>Admin</span>
            </div>
        </header>
        <div class="charts">
            <div class="chart-box">
                <h3>Bestseller Menu</h3>
                <canvas id="menuChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Sale Statistic</h3>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Customer Map</h3>
                <canvas id="customerChart"></canvas>
            </div>
            <div class="chart-box">
                <h3>Reservation Statistic</h3>
                <canvas id="reservationChart"></canvas>
            </div>
        </div>
    </div>
</body>
</html>

