<?php
session_start();

// Get the product ID and new quantity from the request
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($product_id > 0 && $quantity > 0 && isset($_SESSION['cart'][$product_id])) {
    // Update the product quantity in the cart
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
