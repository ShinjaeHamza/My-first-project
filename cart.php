<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    <!-- Breadcrumb navigation -->
    <div class="breadcrumb">
        <a href="Products_by_category.php">Products by category</a> / <span><?php echo isset($category) ? $category : 'Product info'; ?></span>
    </div>
    <!-- Header content here -->
</head>

<body>
    <h1>Shopping Cart</h1>
    <?php if (!empty($_SESSION['cart'])) : ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $product) {
                    $subtotal = $product['price'] * $product['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50"> <?php echo $product['name']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form action="update_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                                <button type="submit">Update</button>
                            </form>
                            <form action="remove_from_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h2>Total: $<?php echo number_format($total, 2); ?></h2>
        <a href="checkout.php">Checkout</a>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>

</html>
<style>
    /* Body styling */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    /* Container styling */
    .container {
        max-width: 960px;
        margin: 20px auto;
        padding: 0 20px;
    }

    /* Heading styling */
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }

    table th,
    table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f0f0f0;
        text-align: left;
    }

    /* Image styling */
    table img {
        display: block;
        margin: 0 auto;
    }

    /* Actions button styling */
    form {
        display: flex;
        align-items: center;
    }

    form input[type="number"] {
        width: 50px;
        margin-right: 10px;
    }

    form button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #45a049;
    }

    /* Total styling */
    .total {
        text-align: right;
        margin-top: 20px;
    }

    .total h2 {
        font-size: 24px;
        margin: 0;
    }

    /* Checkout button styling */
    .checkout-btn {
        display: block;
        width: 200px;
        margin: 20px auto;
        text-align: center;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-decoration: none;
    }

    .checkout-btn:hover {
        background-color: #45a049;
    }

    .breadcrumb {
        margin-bottom: 20px;
        font-size: 14px;
        color: #666;
        padding: 10px 20px;
        background-color: #f9f9f9;
        border-bottom: 1px solid #ddd;
    }

    .breadcrumb a {
        text-decoration: none;
        color: #666;
    }

    .breadcrumb span {
        color: #000;
    }
</style>