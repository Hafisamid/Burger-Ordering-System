<?php
session_start();
include 'db.php'; // Include your database connection

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Calculate totals
$total_quantity = 0;
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_quantity += $item['quantity'];
    $total_price += $item['price'] * $item['quantity'];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel'])) {
        // Clear the cart
        $_SESSION['cart'] = [];
        // Redirect to order.php
        header('Location: order.php');
        exit;
    }

    if (isset($_POST['checkout'])) {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login if user is not logged in
            header('Location: login.php');
            exit;
        }

        // Ensure the cart is not empty
        if (empty($_SESSION['cart'])) {
            echo "Your cart is empty!";
            exit;
        }

        // Debugging line to inspect cart contents before processing
        echo '<pre>' . print_r($_SESSION['cart'], true) . '</pre>';

        $user_id = $_SESSION['user_id'];
        $order_date = date('Y-m-d H:i:s');

        try {
            $pdo->beginTransaction();

            // Insert into Orders table
            $sql = "INSERT INTO Orders (User_ID, Order_Date, Total_Price) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $order_date, $total_price]);
            $order_id = $pdo->lastInsertId();

            // Insert each item into OrderItems table
            foreach ($_SESSION['cart'] as $item) {
                // Check if 'menuId' is set and not null
                if (!isset($item['id']) || empty($item['id'])) {
                    continue; // Skip this item or handle it as needed
                }
                $sql = "INSERT INTO OrderItems (Order_ID, Menu_ID, Quantity, Request) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['request']]);
            }

            $pdo->commit();
            $_SESSION['cart'] = []; // Clear the cart
            $_SESSION['last_order_id'] = $order_id; // Store last order ID for thank you page
            header('Location: thank_you.php'); // Redirect to thank you page
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error during checkout: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - C&O Burger</title>
    <link rel="stylesheet" href="stylescart.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Your Cart</h1>
        <div class="cart-content">
            <table>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Request</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>RM <?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['request']); ?></td>
                        <td>RM <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <h2>Total Quantity: <?php echo $total_quantity; ?></h2>
            <h2>Total Price: RM <?php echo $total_price; ?></h2>
            <div class="cart-buttons">
                <button class="add-more" onclick="window.location.href='order.php'">Add More Items</button>
                <form method="post" class="cancel-form">
                    <button class="cancel-order" type="submit" name="cancel">Cancel Order</button>
                </form>
            </div>
        </div>
        <form method="post" class="checkout-form">
            <button class="checkout" type="submit" name="checkout">Checkout</button>
        </form>
    </div>
</body>
</html>
