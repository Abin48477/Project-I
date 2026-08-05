<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
$res = mysqli_query($conn, 'SELECT COUNT(*) as count FROM products');
$row = mysqli_fetch_assoc($res);
echo "Database count: " . $row['count'] . "\n";

$res = mysqli_query($conn, 'SELECT id, name, image FROM products LIMIT 5');
while($row = mysqli_fetch_assoc($res)) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Image: " . $row['image'] . "\n";
}
?>
