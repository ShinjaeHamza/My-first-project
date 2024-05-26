<?php
// Include database connection code
include 'db_connection.php';
$productsPerPage = 6;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the current page
$offset = ($page - 1) * $productsPerPage;

// Fetch all categories from the database
$sql_categories = "SELECT DISTINCT category FROM products";
$result_categories = mysqli_query($conn, $sql_categories);
$categories = [];
if (mysqli_num_rows($result_categories) > 0) {
    while ($row = mysqli_fetch_assoc($result_categories)) {
        $categories[] = $row['category'];
    }
}

// Initialize an empty array to store selected categories
$selected_categories = [];

// Check if category filter is applied
if (isset($_GET['category']) && is_array($_GET['category'])) {
    // Sanitize and store the selected categories
    $selected_categories = array_map(function ($cat) use ($conn) {
        return mysqli_real_escape_string($conn, $cat);
    }, $_GET['category']);
}

// Prepare the WHERE clause for category filtering
$category_filter = '';
$params = [];
if (!empty($selected_categories)) {
    $placeholders = array_fill(0, count($selected_categories), '?');
    $category_filter = "WHERE category IN (" . implode(',', $placeholders) . ")";
    $params = $selected_categories;
}

// Check if search query is applied
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
    if (!empty($category_filter)) {
        $category_filter .= " AND (name LIKE ? OR description LIKE ?)";
    } else {
        $category_filter = "WHERE name LIKE ? OR description LIKE ?";
    }
    $params[] = '%' . $search_query . '%';
    $params[] = '%' . $search_query . '%';
}

// Fetch products from the database based on the category filter and pagination
$sql = "SELECT * FROM products $category_filter LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    // Bind category values to the prepared statement
    $types = str_repeat('s', count($params)) . 'ii';
    $params[] = $productsPerPage;
    $params[] = $offset;
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    // Execute the statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products by Category</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
</head>

<body>
    <!-- Breadcrumb navigation -->
    <div class="breadcrumb">
        <a href="index.php">Home</a> / <span><?php echo empty($selected_categories) ? 'All Categories' : implode(', ', $selected_categories); ?></span>
    </div>

    <div class="page-description">
        <h2><?php echo empty($selected_categories) ? 'All Categories' : implode(', ', $selected_categories); ?> Products</h2>
        <p>This page displays products <?php echo empty($selected_categories) ? 'from all categories.' : 'in the selected categories.'; ?></p>
    </div>
    <div class="search-bar">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search for products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Filter by Category -->
    <div class="filter">
        <h3>Filter by Category:</h3>
        <form action="" method="GET">
            <?php
            foreach ($categories as $cat) {
                $checked = in_array($cat, $selected_categories) ? 'checked' : '';
                echo "<div>";
                echo "<input type='checkbox' id='category_$cat' name='category[]' value='$cat' $checked>";
                echo "<label for='category_$cat'>$cat</label>";
                echo "</div>";
            }
            ?>
            <button type="submit">Apply Filters</button>
        </form>
    </div>
    <div class="products">
        <?php
        // Check if products exist
        if (mysqli_num_rows($result) > 0) {
            // Display number of products
            $num_products = mysqli_num_rows($result);
            echo "<div class='product-count'>$num_products products found</div>";

            // Display products
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='product'>";
                echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
                echo "<a href='product_info.php?product_id=" . $row['product_id'] . "'>"; // LINK TO PRODUCT DETAILS with product ID
                echo "<div class='product-details'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>$" . $row['price'] . "</p>";
                echo "<button class='add-to-cart'>Product Details</button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            // No products found
            echo "<div class='no-products'>No products found.</div>";
        }
        ?>
    </div>

    <!-- Pagination -->
    <div aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            // Calculate total pages
            $sql_total = "SELECT COUNT(*) AS count FROM products";
            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_assoc($result_total);
            $totalPages = ceil($row_total['count'] / $productsPerPage);

            // Previous page link
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "' tabindex='-1'>Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link' tabindex='-1'>Previous</span></li>";
            }

            // Numbered pages
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                    echo "<li class='page-item active'><a class='page-link' href='#'>$i <span class='sr-only'>(current)</span></a></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
            }

            // Next page link
            if ($page < $totalPages) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>Next</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
            }
            ?>
        </ul>
    </div>

    <script src="Script.js"></script> <!-- Include your JavaScript file -->
</body>

</html>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        padding: 20px;
        margin: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
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

    .page-description {
        margin-bottom: 20px;
    }

    .page-description h2 {
        color: #333;
        margin: 0;
    }

    .product-count {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 16px;
        color: #666;
    }

    .filter {
        float: left;
        width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        margin-right: 20px;
        background-color: #fff;
        border-radius: 8px;
    }

    .filter h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .filter label {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .filter input[type="checkbox"] {
        margin-right: 5px;
    }

    .products-wrapper {
        display: flex;
    }

    .products {
        flex: 1;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .product {
        width: calc(33.33% - 20px);
        margin-right: 20px;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        height: 300px;
        position: relative;
    }

    .product:last-child {
        margin-right: 0;
    }

    .product img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
    }

    .product-details {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .product h3 {
        font-size: 16px;
        margin-bottom: 4px;
    }

    .product p {
        color: #666;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .add-to-cart {
        background-color: #4caf50;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #45a049;
    }

    .product .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product:hover .overlay {
        opacity: 1;
    }

    .product .overlay-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
    }

    .product .overlay-content a {
        text-decoration: none;
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    .product .overlay-content a:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .pagination {
        list-style: none;
        padding: 0;
        margin: 20px 0;
        display: flex;
        justify-content: center;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li.active {
        font-weight: bold;
    }

    .pagination li a,
    .pagination li span {
        padding: 5px 10px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
    }

    .pagination li a:hover {
        background-color: #f0f0f0;
    }
</style>