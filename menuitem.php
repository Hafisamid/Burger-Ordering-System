<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit();
}

include 'db.php'; // Include database connection

// Ensure the uploads directory exists
$uploadDir = 'uploads';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Pagination setup
$itemsPerPage = 4; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $itemsPerPage; // Calculate the offset

// Fetch all menu items with limit and offset
$sql = "SELECT * FROM MenuItem LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ensure $menu_items is an array
if (!$menu_items) {
    $menu_items = [];
}

// Calculate total number of pages
$totalSql = "SELECT COUNT(*) FROM MenuItem";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute();
$totalItems = $totalStmt->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $imagePath = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imagePath = $uploadDir . '/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        $sql = "INSERT INTO MenuItem (Name, Description, Price, Category, ImagePath) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $price, $category, $imagePath]);
        $_SESSION['message'] = 'Menu item added successfully!';
    } elseif (isset($_POST['delete'])) {
        $menu_id = $_POST['menu_id'];
        $sql = "DELETE FROM MenuItem WHERE Menu_ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$menu_id]);
        $_SESSION['message'] = 'Menu item deleted successfully!';
    } elseif (isset($_POST['update'])) {
        $menu_id = $_POST['menu_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $imagePath = $_POST['existing_image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imagePath = $uploadDir . '/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        $sql = "UPDATE MenuItem SET Name = ?, Description = ?, Price = ?, Category = ?, ImagePath = ? WHERE Menu_ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $price, $category, $imagePath, $menu_id]);
        $_SESSION['message'] = 'Menu item updated successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - Admin Dashboard</title>
    <link rel="stylesheet" href="stylesmenuadmin.css">
    <script>
        function showAlert(message) {
            alert(message);
            window.location.href = "menuitem.php";
        }

        function confirmLogout(event) {
            if (!confirm("Are you sure you want to log out?")) {
                event.preventDefault();
            }
        }

        function openModal() {
            document.getElementById("addMenuModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("addMenuModal").style.display = "none";
        }

        function confirmDelete(event) {
            if (!confirm("Are you sure you want to delete this menu item?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<script type="text/javascript">',
             'showAlert("'.$_SESSION['message'].'");',
             '</script>';
        unset($_SESSION['message']); // Clear the message after showing it
    }
    ?>
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
            <h1>Manage Menu</h1>
        </header>
        <div class="menu-management">
            <button onclick="openModal()" class="add-menu-btn">Add Menu</button>

            <!-- Add Menu Modal -->
            <div id="addMenuModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Add New Menu Item</h2>
                    <form method="post" action="menuitem.php" enctype="multipart/form-data">
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="text" name="description" placeholder="Description" required>
                        <input type="number" step="0.01" name="price" placeholder="Price" required>
                        <input type="text" name="category" placeholder="Category" required>
                        <input type="file" name="image" accept="image/*">
                        <button type="submit" name="add">Add Item</button>
                    </form>
                </div>
            </div>

            <h2>Existing Menu Items</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                <?php if (!empty($menu_items)): ?>
                    <?php foreach ($menu_items as $item): ?>
                    <tr>
                        <form method="post" action="menuitem.php" enctype="multipart/form-data">
                            <td><?php echo $item['Menu_ID']; ?></td>
                            <td><input type="text" name="name" value="<?php echo htmlspecialchars($item['Name']); ?>" required></td>
                            <td><input type="text" name="description" value="<?php echo htmlspecialchars($item['Description']); ?>" required></td>
                            <td><input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($item['Price']); ?>" required></td>
                            <td><input type="text" name="category" value="<?php echo htmlspecialchars($item['Category']); ?>" required></td>
                            <td>
                                <?php if ($item['ImagePath']): ?>
                                    <img src="<?php echo htmlspecialchars($item['ImagePath']); ?>" alt="Menu Image" width="100">
                                <?php endif; ?>
                                <input type="file" name="image" accept="image/*">
                                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($item['ImagePath']); ?>">
                            </td>
                            <td>
                                <input type="hidden" name="menu_id" value="<?php echo $item['Menu_ID']; ?>">
                                <button type="submit" name="update">Update</button>
                                <button type="submit" name="delete" onclick="confirmDelete(event)">Delete</button>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No menu items found.</td>
                    </tr>
                <?php endif; ?>
            </table>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i; ?>" <?= $i === $page ? 'style="font-weight: bold;"' : '' ?>>
                        <?= $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>
</html>
