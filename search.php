<?php
include 'includes/db.php';

$search_query = "";
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $query = "SELECT * FROM lost_items WHERE item_name LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($query);
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Search for Lost and Found Items</h2>
    <form method="GET" action="">
        <label for="query">Search:</label>
        <input type="text" id="query" name="query" value="<?php echo htmlspecialchars($search_query); ?>" required>
        <button type="submit">Search</button>
    </form>
    
    <h3>Search Results</h3>
    <?php if (count($results) > 0): ?>
        <ul>
            <?php foreach ($results as $item): ?>
                <li>
                    <strong><?php echo htmlspecialchars($item['item_name']); ?></strong><br>
                    Description: <?php echo htmlspecialchars($item['description']); ?><br>
                    Date Lost: <?php echo htmlspecialchars($item['date_lost']); ?><br>
                    Location Lost: <?php echo htmlspecialchars($item['location_lost']); ?><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</body>
</html>
