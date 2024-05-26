<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $image = $_POST["image"];

    $sql = "UPDATE products SET name = ?, price = ?, category = ?, image = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $name, $price, $category, $image, $id);

    if ($stmt->execute()) {
        header("location: manage_products.php");
        exit;
    } else {
        $error = "Error updating product";
    }
} else {
    $id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="form">
        <h2 class="form-title">Edit Product</h2>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="edit_product.php" method="post">
            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
            <div class="input-container">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
            </div>
            <div class="input-container">
                <label>Price:</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br>
            </div>
            <div class="input-container">
                <label>Category:</label>
                <input type="text" name="category" value="<?php echo $product['category']; ?>" required><br>
            </div>
            <div class="input-container">
                <label>Image URL:</label>
                <input type="text" name="image" value="<?php echo $product['image']; ?>" required><br>
            </div>
            <button type="submit" class="submit">Update Product</button>
        </form>
    </div>
</body>

</html>
<style>
    .body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f3f4f6;
        margin: 0;
    }

    .form {
        background-color: #fff;
        display: block;
        padding: 2rem;
        /* Increased padding */
        max-width: 350px;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        font-size: 1.25rem;
        line-height: 1.75rem;
        font-weight: 600;
        text-align: center;
        color: #000;
    }

    .input-container {
        position: relative;
        margin-bottom: 1rem;
    }

    .input-container label {
        margin-bottom: 0.5rem;
        display: block;
        font-weight: 500;
    }

    .input-container input {
        background-color: #fff;
        padding: 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        width: 100%;
        outline: none;
    }

    .submit {
        display: block;
        padding: 0.75rem 1.25rem;
        background-color: #4F46E5;
        color: #ffffff;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
        width: 100%;
        border: none;
        border-radius: 0.5rem;
        text-transform: uppercase;
        cursor: pointer;
        outline: none;
    }

    .submit:hover {
        background-color: #4338ca;
    }

    .error {
        color: red;
        text-align: center;
    }
</style>