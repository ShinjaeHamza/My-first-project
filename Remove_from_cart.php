<?php
session_start();

// Get the product ID from the request
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
    // Remove the product from the cart
    unset($_SESSION['cart'][$product_id]);
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
