<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Layout List" to see how big the toy boxes are!
echo "--- The Toy Box Layout ---" . PHP_EOL;
// 1. We look at the "Big Delivery Boxes" (Orders)!
$res = mysqli_query($conn, 'DESCRIBE orders');
while ($row = mysqli_fetch_assoc($res)) {
    // We print each room name and what goes inside!
    echo $row['Field'] . ' | ' . $row['Type'] . PHP_EOL;
}
echo "---" . PHP_EOL;
// 2. We look at the "Tiny Toy List" (Order Items) inside each box!
$res = mysqli_query($conn, 'DESCRIBE order_items');
while ($row = mysqli_fetch_assoc($res)) {
    // We print each little sticker name!
    echo $row['Field'] . ' | ' . $row['Type'] . PHP_EOL;
}
?>