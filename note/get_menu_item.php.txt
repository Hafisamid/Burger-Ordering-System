<?php
include 'db.php'; // Include the database connection

if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];
    $sql = "SELECT * FROM MenuItem WHERE Menu_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$menu_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($item);
}
?>
