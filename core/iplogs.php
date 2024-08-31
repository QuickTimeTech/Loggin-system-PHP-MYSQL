<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'inc/heading.php';

// Admin Page ONLY
if (!isset($_SESSION['username']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Generate CSRF token
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<?php
// Read the CSV file
$filename = '../login_attempts.csv';
$data = [];
if (($handle = fopen($filename, 'r')) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $data[] = [
            'username' => $row[0],
            'ip' => $row[1],
            'result' => $row[2],
            'time' => $row[3]
        ];
    }
    fclose($handle);
}

// Sort data by time (newest first)
usort($data, function($a, $b) {
    return strtotime($b['time']) - strtotime($a['time']);
});

// Group data by IP
$groupedData = [];
foreach ($data as $entry) {
    $groupedData[$entry['ip']][] = $entry;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Attempts</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: white;
        }
        .card-dark {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
<?php include 'inc/nav.php'; ?>
<div class="container mt-5">
    <?php foreach ($groupedData as $ip => $entries): ?>
        <div class="card card-dark mb-3">
            <div class="card-header" data-toggle="collapse" data-target="#collapse-<?php echo md5($ip); ?>" aria-expanded="false" aria-controls="collapse-<?php echo md5($ip); ?>" style="cursor: pointer;">
                IP: <?php echo htmlspecialchars($ip); ?>
            </div>
            <div id="collapse-<?php echo md5($ip); ?>" class="collapse">
                <div class="card-body">
                    <?php foreach ($entries as $entry): ?>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($entry['username']); ?></p>
                        <p><strong>Result:</strong> <?php echo htmlspecialchars($entry['result']); ?></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($entry['time']); ?></p>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
