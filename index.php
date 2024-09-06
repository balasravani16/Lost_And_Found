<?php
session_start();
include 'includes/db.php';

// Fetch recent lost items
$lost_items_query = "SELECT * FROM lost_items ORDER BY date_lost DESC LIMIT 5";
$lost_items_result = $conn->query($lost_items_query);

// Fetch recent found items
$found_items_query = "SELECT * FROM found_items ORDER BY date_found DESC LIMIT 5";
$found_items_result = $conn->query($found_items_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lost and Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Lost and Found</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (!isset($_SESSION['role'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">User Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Admin Login</a>
                    </li>
                <?php else: ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/index.php">Admin Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-right mb-3">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                    <a class="btn btn-primary" href="report_lost.php">Report Lost Item</a>
                    <a class="btn btn-success" href="report_found.php">Report Found Item</a>
                <?php endif; ?>
            </div>
        </div>
        
        <h2>Recent Lost Items</h2>
        <?php if ($lost_items_result && $lost_items_result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($row = $lost_items_result->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo htmlspecialchars($row['item_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($row['description']); ?></p>
                        <small>Date Lost: <?php echo htmlspecialchars($row['date_lost']); ?></small>
                        <br>
                        <small>Location: <?php echo htmlspecialchars($row['location_lost']); ?></small>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No recent lost items found.</p>
        <?php endif; ?>

        <h2 class="mt-5">Recent Found Items</h2>
        <?php if ($found_items_result && $found_items_result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($row = $found_items_result->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo htmlspecialchars($row['item_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($row['description']); ?></p>
                        <small>Date Found: <?php echo htmlspecialchars($row['date_found']); ?></small>
                        <br>
                        <small>Location: <?php echo htmlspecialchars($row['location_found']); ?></small>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No recent found items found.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
