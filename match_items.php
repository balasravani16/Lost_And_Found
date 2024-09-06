<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

$lost_item_id = isset($_GET['lost_item_id']) ? intval($_GET['lost_item_id']) : 0;
$found_item_id = isset($_GET['found_item_id']) ? intval($_GET['found_item_id']) : 0;

$lost_item = null;
$found_item = null;

if ($lost_item_id) {
    $lost_item_query = "SELECT * FROM lost_items WHERE id = ?";
    $stmt = $conn->prepare($lost_item_query);
    $stmt->bind_param('i', $lost_item_id);
    $stmt->execute();
    $lost_item = $stmt->get_result()->fetch_assoc();
}

if ($found_item_id) {
    $found_item_query = "SELECT * FROM found_items WHERE id = ?";
    $stmt = $conn->prepare($found_item_query);
    $stmt->bind_param('i', $found_item_id);
    $stmt->execute();
    $found_item = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Match Found Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Match Found Item</h2>
        
        <h3>Found Item Details</h3>
        <?php if ($found_item): ?>
            <div class="list-group">
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($found_item['item_name']); ?></h5>
                    <p class="mb-1"><?php echo htmlspecialchars($found_item['description']); ?></p>
                    <small>Date Found: <?php echo htmlspecialchars($found_item['date_found']); ?></small>
                    <br>
                    <small>Location: <?php echo htmlspecialchars($found_item['location_found']); ?></small>
                </div>
            </div>
        <?php else: ?>
            <p>No found item selected.</p>
        <?php endif; ?>

        <h3 class="mt-5">Lost Item Details</h3>
        <?php if ($lost_item): ?>
            <div class="list-group">
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($lost_item['item_name']); ?></h5>
                    <p class="mb-1"><?php echo htmlspecialchars($lost_item['description']); ?></p>
                    <small>Date Lost: <?php echo htmlspecialchars($lost_item['date_lost']); ?></small>
                    <br>
                    <small>Location: <?php echo htmlspecialchars($lost_item['location_lost']); ?></small>
                </div>
            </div>
        <?php else: ?>
            <p>No lost item selected.</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
