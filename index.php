<?php
// Start a new session or resume the existing session
session_start();

// Include the configuration file
include 'config.php';

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to log login attempts
function log_attempt($username, $ip, $status) {
    // Open the CSV file in append mode
    $file = fopen('login_attempts.csv', 'a');
    // Write the login attempt details to the CSV file
    fputcsv($file, [$username, $ip, $status, date('Y-m-d H:i:s')]);
    // Close the file
    fclose($file);
}

// Function to check the number of login attempts from a specific IP address
function check_attempts($ip) {
    // Open the CSV file in read mode
    $file = fopen('login_attempts.csv', 'r');
    $attempts = 0;
    // Set the time limit to 5 minutes ago
    $time_limit = strtotime('-5 minutes');

    // Read each row of the CSV file
    while (($data = fgetcsv($file)) !== FALSE) {
        // Check if the IP address matches and the attempt was within the last 5 minutes
        if ($data[1] == $ip && strtotime($data[3]) > $time_limit) {
            $attempts++;
        }
    }

    // Close the file
    fclose($file);
    return $attempts;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the POST request
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Get the IP address of the user
    $ip = $_SERVER['REMOTE_ADDR'];

    // Check the number of login attempts from this IP address
    $attempts = check_attempts($ip);
    $remaining_attempts = 5 - $attempts;

    // If there are 5 or more attempts, show an error message and exit
    if ($attempts >= 5) {
        echo "<div class='alert alert-danger' role='alert'>Too many login attempts. Please try again in 5 minutes.</div>";
        exit();
    }

    // Prepare a SQL statement to select user details
    $stmt = $conn->prepare("SELECT id, password, email, account_type, ip FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the username exists in the database
    if ($stmt->num_rows > 0) {
        // Bind the result variables
        $stmt->bind_result($id, $hashed_password, $email, $account_type, $stored_ip);
        $stmt->fetch();

        // Check if the IP address matches the stored IP address
        if ($ip !== $stored_ip) {
            log_attempt($username, $ip, 'failure');
            echo "<div class='alert alert-warning' role='alert'>Wrong IP address for this account. Please contact administration.</div>";
        // Verify the password
        } elseif (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['account_type'] = $account_type;
            session_write_close();
            log_attempt($username, $ip, 'success');
            // Redirect to the core/index.php page
            header("Location: core/index.php");
            exit();
        } else {
            log_attempt($username, $ip, 'failure');
            echo "<div class='alert alert-warning' role='alert'>Invalid password. You have $remaining_attempts attempts left.</div>";
        }
    } else {
        log_attempt($username, $ip, 'failure');
        echo "<div class='alert alert-warning' role='alert'>No user found with that username. You have $remaining_attempts attempts left.</div>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #212529;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .form-control {
            background-color: #495057;
            border: none;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Login Page</h2>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</body>
</html>
