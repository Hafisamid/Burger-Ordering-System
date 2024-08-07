<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$menuId = $data['menuId'];
$quantity = $data['quantity'];
$request = $data['request'];

// Fetch menu item details
$sql = "SELECT * FROM MenuItem WHERE Menu_ID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$menuId]);
$item = $stmt->fetch();

if ($item) {
    $cart_item = [
        'id' => $menuId,
        'name' => $item['Name'],
        'price' => $item['Price'],
        'quantity' => $quantity,
        'request' => $request,
    ];

    // Check if item already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$existing_item) {
        if ($existing_item['id'] == $menuId) {
            $existing_item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $cart_item;
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
