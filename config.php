<?php 
// Database connection details
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "password-management";
#################################

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If not, terminate the script and display an error message
    die("Connection failed: " . $conn->connect_error);
}
?>