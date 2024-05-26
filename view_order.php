<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

include "db_connection.php";

if (isset($_GET["id"])) {
    $order_id = $_GET["id"];

    // Fetch order details from the database
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $order = $result->fetch_assoc();
    } else {
        echo "Order not found";
        exit;
    }
} else {
    echo "Order ID not specified";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Order Details</h1>
        <nav>
            <ul>
                <li><a href="manage_orders.php">Back to Orders</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="order-details">
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Customer Name:</strong> <?php echo $order['user_id']; ?></p>
            <p><strong>Total Amount:</strong> <?php echo $order['total_price']; ?></p>
            <p><strong>Status:</strong> <?php echo $order['order_date']; ?></p>

        </div>
        <form action="remove_order.php" method="post">
            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
            <button type="submit">Remove Order</button>
        </form>
    </section>
</body>

</html>
<style>
    /* Add CSS styles for the small button */
    .remove-order-btn {
        padding: 0.5rem 1rem;
        /* Adjust padding as needed */
        font-size: 0.875rem;
        /* Adjust font size as needed */
    }
</style>