<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
$res = mysqli_query($conn, 'SELECT id, name, image FROM products');
while($row = mysqli_fetch_assoc($res)) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Path: " . $row['image'] . "\n";
}
?>
