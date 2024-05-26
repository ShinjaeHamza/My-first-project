<?php
session_start();

// Process the order here (e.g., save to database, send email, etc.)

// Clear the cart
unset($_SESSION['cart']);

header('Location: order_success.php');
exit;
