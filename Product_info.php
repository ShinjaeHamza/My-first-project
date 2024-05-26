<?php
// Include database connection code
include 'db_connection.php';

// Check if product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $sql);

    // Check if product exists
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $product['name']; ?></title>
            <link href="PFE/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="./styles.css">
        </head>

        <body>
            <header>
                <!-- Breadcrumb navigation -->
                <div class="breadcrumb">
                    <a href="index.php">Home</a> / <span><?php echo isset($category) ? $category : 'Product info'; ?></span>
                </div>
                <!-- Header content here -->
            </header>

            <section class="product-details">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?php echo $product['image']; ?>" height="500" width="" alt="<?php echo $product['name']; ?>">
                        </div>

                        <div class="col-md-6">
                            <h2><?php echo $product['name']; ?></h2>
                            <p class="price">$<?php echo $product['price']; ?></p>
                            <p><?php echo $product['description']; ?></p>
                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                                <div class="quantity">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <h3 style="margin:0px 0px 20px 20px">Related Products</h3>
            <section>
                <div class="container">
                    <div class="related-products">


                        <?php
                        // Construct SQL query to fetch related products with the same category
                        $related_sql = "SELECT * FROM products WHERE category=(SELECT category FROM products WHERE product_id='$product_id') AND product_id != '$product_id' LIMIT 3";

                        // Execute the SQL query
                        $related_result = mysqli_query($conn, $related_sql);

                        // Check if there are related products
                        if ($related_result) {
                            // Display related products
                            while ($related_product = mysqli_fetch_assoc($related_result)) {
                        ?>

                                <div class="related-product">
                                    <img src="<?php echo $related_product['image']; ?>" height="200" width="300" alt="<?php echo $related_product['name']; ?>">

                                    <h4><?php echo $related_product['name']; ?></h4>
                                    <p class="price">$<?php echo $related_product['price']; ?></p>
                                    <a href="product_info.php?product_id=<?php echo $related_product['product_id']; ?>" class="btn btn-secondary">View Details</a>
                                </div>

                        <?php
                            }
                        } else {
                            // Handle the case where no related products are found
                            echo "No related products found.";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <footer>
                <!-- Footer content here -->
                <footer>
                    <!-- Footer content here -->

                    <!-- Display Cart Section -->
                    <div class="cart-container">
                        <h3>Shopping Cart</h3>
                        <div class="cart-items">
                            <!-- PHP code to display cart items -->
                            <?php
                            // Check if the cart session variable is set and not empty
                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                // Loop through each item in the cart
                                foreach ($_SESSION['cart'] as $item) {
                                    echo "<div class='cart-item'>";
                                    echo "<span class='item-name'>" . $item['name'] . "</span>";
                                    echo "<span class='item-price'>$" . $item['price'] . "</span>";
                                    echo "<span class='item-quantity'>Quantity: " . $item['quantity'] . "</span>";
                                    echo "</div>";
                                }
                            } else {
                                // Display a message if the cart is empty
                                echo "<p>Your cart is empty.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </footer>
            </footer>

        </body>

        </html>
<?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not provided.";
}
?>
<style>
    /* Main product container */
    .main-product {
        max-width: 200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Main product image */
    .main-product img {
        display: block;
        margin: 0 auto 20px;
        max-width: 100%;
        height: 100%;
    }

    /* Related products container */
    .related-products {
        gap: 20px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Related product item */
    .related-product {
        width: calc(25% - 20px);
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    /* Related product image */
    .related-product img {
        display: block;
        margin: 0 auto;
        max-width: 100%;
    }

    .container {
        max-width: 100% !important;
        margin: 0px 20px !important;

    }
</style>