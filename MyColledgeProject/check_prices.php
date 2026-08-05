<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
$res = mysqli_query($conn, 'SELECT id, name, price, image FROM products');
while($row = mysqli_fetch_assoc($res)) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Price: " . $row['price'] . " | Image: " . $row['image'] . "\n";
}
?>
