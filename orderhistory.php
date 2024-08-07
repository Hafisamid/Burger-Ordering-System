<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="orderhistorystyle.css">
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
        <h1>Order History</h1>
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check user login and authorization
        if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
            header('Location: login.php');
            exit();
        }

        // Include the database connection
        include 'db.php'; // Adjust path as needed

        try {
            $sql = "SELECT u.Username, o.Order_Date, m.Name, oi.quantity, o.Total_Price 
                    FROM orders o 
                    JOIN user u ON o.User_ID = u.User_ID 
                    JOIN orderitems oi ON o.Order_ID = oi.order_id 
                    JOIN menuitem m ON oi.menu_id = m.Menu_ID
                    ORDER BY o.Order_Date DESC, u.Username";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($results) > 0) {
                echo "<table>
                        <tr>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Menu</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>";
                foreach ($results as $row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["Username"]) . "</td>
                            <td>" . htmlspecialchars($row["Order_Date"]) . "</td>
                            <td>" . htmlspecialchars($row["Name"]) . "</td>
                            <td>" . htmlspecialchars($row["quantity"]) . "</td>
                            <td>" . htmlspecialchars($row["Total_Price"]) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
        ?>
    </div>
</body>
</html>
