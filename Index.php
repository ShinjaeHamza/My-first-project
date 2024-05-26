<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Souq Sebt</title>
  <link href="PFE/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./styles.css">

</head>

<body>
  <header>
    <div class="header-content">
      <div class="logo">
        <img src="Images\LOGO.png" alt="Logo">
      </div>
      <nav>
        <ul class="menu">
          <li><a href="#">Home</a></li>
          <li><a href="products_by_category.php">Shop</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="./logout.php">Logout</a></li>
          <li><a href="./registration_form.php">Register</a></li>


          </form>
        </ul>
      </nav>
      <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button type="submit">Search</button>
      </div>
      <div class="user-actions">
        <?php
        session_start();
        // Check if the user is logged in
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          // Display the username with black color
          echo "<span style='color: black;'>Welcome, " . $_SESSION["username"] . "</span>";
        } else {
          // Redirect the user to the login page if not logged in
          header("location: login.php");
          exit;
        }
        ?>

        <a href="user_profile.php" class="user-icon"><img src="Images\User.png" alt="User Icon"></a>

      </div>
    </div>

  </header>


  <style>


  </style>
  </header>

  <section class="hero">
    <h2>Find the Best Deals Here</h2>
    <p>Discover a wide range of products at amazing prices.</p>
    <a href="products_by_category.php" class="btn">Shop Now</a>
  </section>


  <section class="product-section">
    <div class="row">
      <?php
      // Include database connection code
      include 'db_connection.php';

      // Define an array of categories
      $categories = array("Ebooks", "Gift Cards", "Video Games");

      // Loop through each category
      foreach ($categories as $category) {
        // Fetch products based on category from the database
        $sql = "SELECT * FROM products WHERE category='$category' LIMIT 3";
        $result = mysqli_query($conn, $sql);

        // Check if products exist for this category
        if (mysqli_num_rows($result) > 0) {
          // Display category header
          echo "<div class='comment'>$category</div>";

          // Loop through each row of products
          while ($row = mysqli_fetch_assoc($result)) {
            // Display each product
            echo "<div class='column'>";
            echo "<div class='product'>";
            echo "<a href='product_info.php?product_id=" . $row['product_id'] . "'>"; // LINK TO PRODUCT DETAILS with product ID
            echo "<div class='product-image'>";
            echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
            echo "</div>";
            echo "<div class='product-details'>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<p class='price'>$" . $row['price'] . "</p>";
            echo "<button class='product_details'>Product Details</button>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
            echo "</div>";
          }
        } else {
          // If no products found for this category
          echo "<div class='comment'>No $category found.</div>";
        }
      }
      ?>
    </div>
  </section>



  <title>Secondary Banner</title>
  <style>
    /* Basic styling */
  </style>
  </head>

  <body>



    <footer>
      <div class="payment-methods">
        <img src="Images\visa.png" alt="Visa">
        <img src="Images\mastercard.png" alt="Mastercard">
        <img src="Images\paypal.png" alt="PayPal">
        <!-- Add more payment method icons here -->
      </div>
      <p>&copy; 2024 Souq Sebt. All rights reserved.</p>
      <style>
        .payment-methods img {
          width: 30px;
          /* Adjust the size of the payment method icons as needed */
          margin-right: 10px;
        }

        .footer {
          position: relative;
          /* Make the footer a positioned container */
          background-color: #333;
          color: #fff;
          text-align: center;
          padding: 20px 0;
        }
      </style>
    </footer>
  </body>

</html>