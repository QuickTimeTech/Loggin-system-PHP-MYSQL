<?php
    // Include the heading.php file
    include 'inc/heading.php';

    // Admin Page ONLY
    // Check if the user is not logged in or not an admin
    if (!isset($_SESSION['username']) || $_SESSION['account_type'] !== 'admin') {
        // Redirect to the index page if the user is not an admin
        header("Location: index.php");
        exit();
    }

    // Delete record
    // Check if the 'delete' parameter is set in the URL
    if (isset($_GET['delete'])) {
        // Get the 'delete' parameter value
        $id = $_GET['delete'];
        // Execute the delete query to remove the user with the specified ID
        $conn->query("DELETE FROM users WHERE id=$id");
        // Redirect to the table-view page after deletion
        header("Location: table-view.php");
    }

    // Fetch records
    // Execute the query to fetch all users from the database
    $result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table view - Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        .table-dark {
            background-color: #454d55;
        }
        .table-dark th, .table-dark td {
            border-color: #565e64;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, 1);
        }
    </style>
</head>
<body>
    
<?php include 'inc/nav.php'; ?>

    <div class="container mt-5">
        <h2>User List</h2>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>IP Address</th>
                        <th>Account Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['ip']; ?></td>
                        <td><?php echo $row['account_type']; ?></td>
                        <td>
                            <a href="edit-user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="table-view.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
