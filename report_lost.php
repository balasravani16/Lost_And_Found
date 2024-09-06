<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $date_lost = $_POST['date_lost'];
    $location_lost = $_POST['location_lost'];
    $image_path = 'images/' . basename($_FILES['image']['name']);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        $sql = "INSERT INTO lost_items (user_id, item_name, description, date_lost, location_lost, image_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssss', $user_id, $item_name, $description, $date_lost, $location_lost, $image_path);
        $stmt->execute();
        header('Location: index.php');
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Lost Item</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Report Lost Item</h1>
    <form action="report_lost.php" method="post" enctype="multipart/form-data">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <label for="date_lost">Date Lost:</label>
        <input type="date" name="date_lost" required>
        <label for="location_lost">Location Lost:</label>
        <input type="text" name="location_lost">
        <label for="image">Upload Image:</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
