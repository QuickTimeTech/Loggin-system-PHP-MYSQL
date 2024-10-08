<?php
    // Include the heading.php file
    include 'inc/heading.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Area - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<?php include 'inc/nav.php'; ?>

    <div class="container mt-5">
        <h2>Members Area</h2>
        <p>Hello, <?php echo htmlspecialchars($username); ?>! You're in the members area.</p>
        <p>Your email: <?php echo htmlspecialchars($email); ?></p>
        <p>Account type: <?php echo htmlspecialchars($account_type); ?></p>
        <p>Account ID: <?php echo htmlspecialchars($id); ?></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

