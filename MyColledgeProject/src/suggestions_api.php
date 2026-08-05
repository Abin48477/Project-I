<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

header('Content-Type: application/json');

// We listen to the first few letters you type!
$query = isset($_GET['q']) ? $_GET['q'] : '';

// If you only typed one letter, we wait for more!
// We want to be really sure about what you're looking for!
if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

// We try to guess which toy you want to find!
$search = $query . "%";
// We ask the computer to find the top 5 toy names that start with those letters!
$stmt = $conn->prepare("SELECT name FROM products WHERE name LIKE ? LIMIT 5");
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    // We whisper the toy name back to you!
    $suggestions[] = $row['name'];
}

echo json_encode($suggestions);
?>