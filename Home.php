<?php
session_start();

if(isset( $_SESSION['id']) && isset($_SESSION['username'])) {
    ?>

    <!DOCTYPE html>
    <html>
    <head>

    <title> Home </title>
    <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Heloo, <?php echo $_SESSION["username"]; ?></h1>
        <a href="logout.php">Log Out</a><
    </body>
    </html>
   
   <?php
} else{ 
    header("Location: authentification.php");
    exit();
}
?>