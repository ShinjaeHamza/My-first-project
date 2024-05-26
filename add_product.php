<?php
$hostname = "localhost"; // Your host name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "mydatabase"; // Your database name

// Include your database connection code here
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and escape special characters
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $category = mysqli_real_escape_string($conn, $_POST["category"]);

    // File upload handling
    $targetDir = "Products/"; // Directory where images will be uploaded
    $targetFile = $targetDir . basename($_FILES["image"]["name"]); // Path to the uploaded file
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, now insert data into the database using prepared statements
            $sql = "INSERT INTO products (name, price, description, category, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $price, $description, $category, $targetFile);
            $stmt->execute();

            // Provide feedback to the user
            echo "Product added successfully.";
            // Display the uploaded image
            echo "<img src='$targetFile' alt='Product Image'>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
