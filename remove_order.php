<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["order_id"])) {
        $order_id = $_POST["order_id"];

        // Delete associated records from the details table
        $sql_details = "DELETE FROM details WHERE order_id = ?";
        $stmt_details = $conn->prepare($sql_details);
        $stmt_details->bind_param("i", $order_id);
        $stmt_details->execute();

        // Prepare and execute SQL statement to delete the order
        $sql_order = "DELETE FROM orders WHERE order_id = ?";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bind_param("i", $order_id);

        if ($stmt_order->execute()) {
            // Order successfully removed
            header("location: manage_orders.php");
            exit;
        } else {
            // Error occurred while deleting the order
            echo "Error removing order";
            exit;
        }
    } else {
        // Order ID not provided
        echo "Order ID not specified";
        exit;
    }
} else {
    // Redirect if accessed directly without POST request
    header("location: manage_orders.php");
    exit;
}
