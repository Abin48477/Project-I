<?php
include 'connection.php';

// First, check if the product already exists
$check_query = "SELECT * FROM products WHERE productName = 'shilitit'";
$check_result = mysqli_query($conn, $check_query);
$existing_product = mysqli_fetch_assoc($check_result);

if ($existing_product) {
    // Update existing product
    $query = "UPDATE products SET price = 999, image = 'PlantsImages/shilijit.jpg' WHERE productName = 'shilitit'";
    if (mysqli_query($conn, $query)) {
        echo "Product 'shilitit' updated successfully with price 999 and image shilijit.jpg";
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
} else {
    // Insert new product
    $query = "INSERT INTO products (productName, price, image) VALUES ('shilitit', 999, 'PlantsImages/shilijit.jpg')";
    if (mysqli_query($conn, $query)) {
        echo "Product 'shilitit' inserted successfully with price 999 and image shilijit.jpg";
    } else {
        echo "Error inserting product: " . mysqli_error($conn);
    }
}

// Show all products to verify
echo "<br><br><strong>All Current Products:</strong><br>";
$all_products = mysqli_query($conn, "SELECT id, productName, price, image FROM products");
while ($row = mysqli_fetch_assoc($all_products)) {
    echo "ID: " . $row['id'] . " | Name: " . $row['productName'] . " | Price: " . $row['price'] . " | Image: " . $row['image'] . "<br>";
}

mysqli_close($conn);
?>
