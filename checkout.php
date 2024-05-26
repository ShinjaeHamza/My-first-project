<?php
session_start();

// Establish database connection (Replace with your actual database credentials)
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user information is available in session or through authentication
$user_id = 2; // Example user ID, replace with actual user ID

// Retrieve cart items from session
$cart = $_SESSION['cart'];

// Calculate total price
$total_price = 0;
foreach ($cart as $product_id => $product) {
    $total_price += $product['price'] * $product['quantity'];
}

// Insert order into orders table
$order_date = date('Y-m-d H:i:s');
$sql = "INSERT INTO orders (user_id, total_price, order_date) VALUES ($user_id, $total_price, '$order_date')";
if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id; // Get the auto-generated order ID
    // Insert order details into details table
    foreach ($cart as $product_id => $product) {
        $quantity = $product['quantity'];
        $discount = 0; // Assuming no discount for simplicity
        $sql = "INSERT INTO details (order_id, product_id, quantity, discount) VALUES ($order_id, $product_id, $quantity, $discount)";
        $conn->query($sql);
    }
    // Clear the cart session data
    unset($_SESSION['cart']);
    // Redirect to a thank you page or order confirmation page
    header('Location: Confirm_order.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
