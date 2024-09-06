<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

// Fetch lost and found items to review
$lost_items_query = "SELECT * FROM lost_items WHERE status = 'reported'";
$lost_items_result = $conn->query($lost_items_query);

$found_items_query = "SELECT * FROM found_items WHERE status = 'reported'";
$found_items_result = $conn->query($found_items_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Review Reports</h2>
        
        <h3>Lost Items</h3>
        <?php if ($lost_items_result && $lost_items_result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($row = $lost_items_result->fetch_assoc()): ?>
                    <a href="match_items.php?lost_item_id=<?php echo $row['id']; ?>" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo htmlspecialchars($row['item_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($row['description']); ?></p>
                        <small>Date Lost: <?php echo htmlspecialchars($row['date_lost']); ?></small>
                        <br>
                        <small>Location: <?php echo htmlspecialchars($row['location_lost']); ?></small>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No lost items to review.</p>
        <?php endif; ?>

        <h3 class="mt-5">Found Items</h3>
        <?php if ($found_items_result && $found_items_result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($row = $found_items_result->fetch_assoc()): ?>
                    <a href="match_items.php?found_item_id=<?php echo $row['id']; ?>" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo htmlspecialchars($row['item_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($row['description']); ?></p>
                        <small>Date Found: <?php echo htmlspecialchars($row['date_found']); ?></small>
                        <br>
                        <small>Location: <?php echo htmlspecialchars($row['location_found']); ?></small>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No found items to review.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
