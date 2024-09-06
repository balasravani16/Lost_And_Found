<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $date_found = $_POST['date_found'];
    $location_found = $_POST['location_found'];
    $image_path = 'images/' . basename($_FILES['image']['name']);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        $sql = "INSERT INTO found_items (user_id, item_name, description, date_found, location_found, image_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssss', $user_id, $item_name, $description, $date_found, $location_found, $image_path);
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
    <title>Report Found Item</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Report Found Item</h1>
    <form action="report_found.php" method="post" enctype="multipart/form-data">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <label for="date_found">Date Found:</label>
        <input type="date" name="date_found" required>
        <label for="location_found">Location Found:</label>
        <input type="text" name="location_found">
        <label for="image">Upload Image:</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
