<?php
// Include your database connection code here
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container">
        <h2>Product Listing</h2>

        <div class="row">
            <?php
            // Check if there are products to display
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-4">
                        <div class="product">
                            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            <h3><?php echo $row['name']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <p>$<?php echo $row['price']; ?></p>
                            <button class="add-to-cart">Add to Cart</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>