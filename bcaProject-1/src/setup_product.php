<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Toy Factory" page to make sure we have the cool 'shilitit' toy!
echo "<h2>The Toy Factory</h2>";

// 1. We look in the treasure box to see if the 'shilitit' toy is already there!
$check_query = "SELECT * FROM products WHERE productName = 'shilitit'";
$check_result = mysqli_query($conn, $check_query);

if (!$check_result) {
    die("Query failed: " . mysqli_error($conn));
}

$existing_product = mysqli_fetch_assoc($check_result);

$image_path = 'PlantsImages/shilijit.jpg';

if ($existing_product) {
    // 2. If it's there but looking old, we give it a fresh price and a pretty picture!
    $update_query = "UPDATE products SET price = 999, image = '$image_path' WHERE productName = 'shilitit'";
    if (mysqli_query($conn, $update_query)) {
        echo "✓ Toy 'shilitit' is now fresh and new!\n";
    } else {
        echo "✗ Oops, the toy glue didn't work: " . mysqli_error($conn);
    }
} else {
    // Insert new product
    $insert_query = "INSERT INTO products (productName, price, image) VALUES ('shilitit', 999, '$image_path')";
    if (mysqli_query($conn, $insert_query)) {
        echo "✓ Product 'shilitit' created successfully!\n";
        echo "  - Price: 999\n";
        echo "  - Image: $image_path\n";
    } else {
        echo "✗ Error inserting product: " . mysqli_error($conn);
    }
}

echo "\n--- Product Details ---\n";
$query = "SELECT id, productName, price, image FROM products WHERE productName = 'shilitit'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if ($product) {
    echo "ID: " . $product['id'] . "\n";
    echo "Name: " . $product['productName'] . "\n";
    echo "Price: " . $product['price'] . "\n";
    echo "Image: " . $product['image'] . "\n";
} else {
    echo "Product not found in database!";
}

mysqli_close($conn);
?>
