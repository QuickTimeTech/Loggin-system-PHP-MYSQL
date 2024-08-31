<?php
// Start a new session or resume the existing session
session_start();

// Unset all session variables
session_unset();

// Destroy the current session
session_destroy();

// Redirect the user to the index.php page
header("Location: index.php");

// Ensure the script stops executing after the redirect
exit();
?>
