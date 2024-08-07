<?php
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['index']) && isset($data['quantity'])) {
    $index = $data['index'];
    $quantity = $data['quantity'];

    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}

echo json_encode(['status' => 'success']);
?>
