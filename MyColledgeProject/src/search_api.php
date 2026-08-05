<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// We tell the computer we are sending a list of toys!
header('Content-Type: application/json');

// We read what you typed in the search box (keyword)!
$keyword = isset($_GET['q']) ? $_GET['q'] : '';
// We check which shelf you want to look at (category)!
$category = isset($_GET['category']) ? $_GET['category'] : '';
// We check how many coins you want to spend (price)!
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 999999;
$min_rating = isset($_GET['min_rating']) ? floatval($_GET['min_rating']) : 0;
// We check if you want the toys sorted in a special way!
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// This is our magic map (SQL) to find the right toys!
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];
$types = "";

// If you wrote something in the search box...
if ($keyword !== '') {
    // ...we look for toys with that name or special tags!
    $sql .= " AND (name LIKE ? OR category LIKE ? OR ingredients LIKE ? OR disease_tags LIKE ?)";
    $search_term = "%$keyword%";
    $params = array_merge($params, [$search_term, $search_term, $search_term, $search_term]);
    $types .= "ssss";
}

// If you picked a specific shelf (category)...
if ($category !== '') {
    // ...we only look at toys on that shelf!
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

// We make sure the toy price is not too big or too small!
$sql .= " AND price BETWEEN ? AND ?";
$params[] = $min_price;
$params[] = $max_price;
$types .= "dd";

// If you want toys that everyone loves (stars)...
if ($min_rating > 0) {
    // ...we only find toys with many stars!
    $sql .= " AND rating >= ?";
    $params[] = $min_rating;
    $types .= "d";
}

// We decide which toy should come first in the list!
switch ($sort) {
    case 'price_low':
        // Cheapest toys first!
        $sql .= " ORDER BY price ASC";
        break;
    case 'price_high':
        // Most expensive toys first!
        $sql .= " ORDER BY price DESC";
        break;
    case 'popularity':
        // Toys with many stars first!
        $sql .= " ORDER BY rating DESC";
        break;
    case 'newest':
    default:
        // Fresh toys first!
        $sql .= " ORDER BY created_at DESC";
        break;
}

// We tell the computer to follow the map and find the toys!
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    // We put each toy into a big cardboard box...
    $products[] = $row;
}

// ...and we send the box to you!
echo json_encode($products);
?>