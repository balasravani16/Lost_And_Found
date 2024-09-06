<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Lost and Found</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="report.php">Report</a>
            <?php if(isset($_SESSION['user'])): ?>
                <a href="logout.php">Logout</a>
                <?php if($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="admin.php">Admin</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>
