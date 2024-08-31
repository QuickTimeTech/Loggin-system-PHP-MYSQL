<?php
    // Include the heading.php file
    include 'inc/heading.php';

    // Admin Page ONLY: Redirect to index.php if the user is not an admin
    if (!isset($_SESSION['username']) || $_SESSION['account_type'] !== 'admin') {
        header("Location: index.php"); // Redirect to index.php
        exit(); // Exit the script
    }

    // Function to get user details by ID
    function getUserById($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?"); // Prepare the SQL statement
        $stmt->bind_param("i", $id); // Bind the ID parameter
        $stmt->execute(); // Execute the statement
        return $stmt->get_result()->fetch_assoc(); // Fetch and return the result as an associative array
    }

    // Function to update user details
    function updateUser($conn, $id, $username, $email, $ip, $account_type) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, ip = ?, account_type = ? WHERE id = ?"); // Prepare the SQL statement
        $stmt->bind_param("ssssi", $username, $email, $ip, $account_type, $id); // Bind the parameters
        return $stmt->execute(); // Execute the statement and return the result
    }

    // Check if 'id' is set in the GET request
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Convert the ID to an integer
        $row = getUserById($conn, $id); // Get the user details by ID
    }

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = intval($_POST['id']); // Convert the ID to an integer
        $username = htmlspecialchars($_POST['username']); // Sanitize the username
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize the email
        $ip = htmlspecialchars($_POST['ip']); // Sanitize the IP address
        $account_type = htmlspecialchars($_POST['account_type']); // Sanitize the account type

        // Update the user details and check if the update was successful
        if (updateUser($conn, $id, $username, $email, $ip, $account_type)) {
            header("Location: table-view.php"); // Redirect to table-view.php
            exit(); // Exit the script
        } else {
            echo "Error updating record: " . $conn->error; // Display an error message
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'inc/nav.php'; ?>

    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="post" action="edit-user.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>
            <label for="ip">IP Address:</label><br>
            <input type="text" id="ip" name="ip" value="<?php echo htmlspecialchars($row['ip']); ?>" required><br>
            <label for="account_type">Account Type:</label><br>
            <select id="account_type" name="account_type" required>
                <option value="user" <?php if ($row['account_type'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($row['account_type'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select><br><br>
            <input type="submit" value="Update">
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
