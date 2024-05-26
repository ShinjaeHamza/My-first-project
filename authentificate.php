<?php
session_start();

// Check if the user is already logged in, if yes, redirect to the index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// If the user is not logged in, you might redirect them to the login page
// header("location: login.php");
// exit;
