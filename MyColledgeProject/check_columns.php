<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
$res = mysqli_query($conn, "SELECT * FROM products LIMIT 1");
$row = mysqli_fetch_assoc($res);
echo json_encode(array_keys($row));
?>
