<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Photo Studio" to give the 'shilitit' toy a brand new picture!
echo "<h2>The Toy Photo Studio</h2>";

// 1. We find the new, pretty photo of the toy!
$image_path = 'ourProductsImages/shilijit.jpg';
// 2. We tell the treasure box to swap the old photo for the new one!
$update_query = "UPDATE products SET price = 999, image = '$image_path' WHERE productName = 'shilitit'";

if (mysqli_query($conn, $update_query)) {
    // If it's done, we say "Yay! Look at the shiny new picture!"
    echo "✓ Toy 'shilitit' looks beautiful now!\n";
} else {
    // If the camera is broken, we show an error!
    echo "✗ Error with the camera: " . mysqli_error($conn);
}

echo "\n--- Updated Product Details ---\n";
$query = "SELECT id, productName, price, image FROM products WHERE productName = 'shilitit'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if ($product) {
    echo "ID: " . $product['id'] . "\n";
    echo "Name: " . $product['productName'] . "\n";
    echo "Price: " . $product['price'] . "\n";
    echo "Image: " . $product['image'] . "\n";
}

mysqli_close($conn);
?>
