<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"], $_POST["status"])) {
    $order_id = $_POST["id"];
    $status = $_POST["status"];

    // Update order status in the database
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    if ($stmt->execute()) {
        header("location: manage_orders.php");
        exit;
    } else {
        echo "Error updating order status";
        exit;
    }
} else {
    echo "Invalid request";
    exit;
}
