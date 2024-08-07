<?php
session_start();
include 'db.php'; // Include your database connection

if (!isset($_SESSION['user_id']) || !isset($_SESSION['last_order_id'])) {
    header('Location: login.php'); // Redirect if no order ID is found or user is not logged in
    exit;
}

$order_id = $_SESSION['last_order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$orderStmt = $pdo->prepare("SELECT Order_ID, Order_Date, Total_Price FROM Orders WHERE Order_ID = ? AND User_ID = ?");
$orderStmt->execute([$order_id, $user_id]);
$order = $orderStmt->fetch(PDO::FETCH_ASSOC);

// Fetch items in the order along with their names
$itemsStmt = $pdo->prepare("
    SELECT oi.Menu_ID, oi.Quantity, mi.Name 
    FROM OrderItems oi
    JOIN MenuItem mi ON oi.Menu_ID = mi.Menu_ID
    WHERE oi.Order_ID = ?
");
$itemsStmt->execute([$order_id]);
$items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - C&O Burger</title>
    <link rel="stylesheet" href="stylesthank.css">  <!-- Link to the CSS file -->
</head>
<body>

<style> 

body {
    font-family: 'Arial', sans-serif;
    background-color: #663339;
    margin: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #FFA500; /* Orange color for buttons */
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #ff8c00; /* Darker orange */
}
</style>


<div class="container">
    <h1>Thank You for Your Order!</h1>
    <div class="order-summary">
        <h2>Order Summary</h2>
        <p>Order ID: <?php echo htmlspecialchars($order['Order_ID']); ?></p>
        <p>Order Date: <?php echo htmlspecialchars($order['Order_Date']); ?></p>

        <h3>Items Ordered:</h3>
        <ul>
            <?php foreach ($items as $item): ?>
                <li><div><?php echo htmlspecialchars($item['Name']); ?></div> <div>Quantity: <?php echo htmlspecialchars($item['Quantity']); ?></div></li>
            <?php endforeach; ?>
        </ul>

        <p class="total-price">Total Price: <strong>RM  <?php echo htmlspecialchars($order['Total_Price']); ?></strong></p>
    </div>

    <button onclick="window.print();">Print this receipt</button>
    <button onclick="location.href='order.php'" style="background-color: #4CAF50;">Continue Shopping</button>
</div>
</body>
</html>
