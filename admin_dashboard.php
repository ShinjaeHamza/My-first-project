<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

// Include database connection
include "Db_connection.php";

// Fetch and display products or any other admin-specific data here

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="add_product.html">Add Product</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="admin_logout.php">Logout</a></li>

            </ul>
        </nav>
    </header>

    <section>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>
    </section>
</body>

</html>