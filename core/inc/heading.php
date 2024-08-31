<?php
// Start the session
session_start();

// Check if the 'username' session variable is set
if (!isset($_SESSION['username'])) {
    // If not, redirect to the login page
    header("Location: ../index.php");
    // Exit the script
    exit();
}

// Assign session variables to local variables
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$account_type = $_SESSION['account_type'];
$id = $_SESSION['id'];

include '../config.php';
?>
