<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Big Blueprint" to make sure our treasure box looks perfect!
echo "--- Starting the Great Blueprint Check ---\n";

// 1. We change the "productName" sticker to a simple "name" sticker!
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM products LIKE 'productName'");
if (mysqli_num_rows($check_column) > 0) {
    $rename_query = "ALTER TABLE products CHANGE productName name VARCHAR(255) NOT NULL";
    if (mysqli_query($conn, $rename_query)) {
        echo "✓ Swapped stickers: 'productName' is now 'name'!\n";
    } else {
        echo "✗ Oh no, the sticker is stuck: " . mysqli_error($conn) . "\n";
    }
} else {
    echo "• Sticker is already 'name'. Perfect!\n";
}

// 2. We add more rooms (columns) to our toy box so we can store more secrets!
$columns_to_add = [
    "category VARCHAR(100) AFTER name",
    "ingredients TEXT AFTER description",
    "disease_tags TEXT AFTER ingredients",
    "rating FLOAT DEFAULT 0 AFTER price"
];

foreach ($columns_to_add as $col) {
    $col_name = explode(' ', $col)[0];
    $check_col = mysqli_query($conn, "SHOW COLUMNS FROM products LIKE '$col_name'");
    if (mysqli_num_rows($check_col) == 0) {
        $add_query = "ALTER TABLE products ADD $col";
        if (mysqli_query($conn, $add_query)) {
            echo "✓ Room '$col_name' added to the box!\n";
        } else {
            echo "✗ Hammer broke while building '$col_name': " . mysqli_error($conn) . "\n";
        }
    } else {
        echo "• Room '$col_name' is already there!\n";
    }
}

// 3. Update sample data for search testing
$sample_updates = [
    [
        "name" => "Ashwagandha Powder",
        "category" => "Immunity",
        "ingredients" => "Pure Ashwagandha Root",
        "disease_tags" => "Stress, Anxiety, Fatigue",
        "price" => 450.00,
        "rating" => 4.8
    ],
    [
        "name" => "Ashwagandha Capsules",
        "category" => "Immunity",
        "ingredients" => "Ashwagandha Extract",
        "disease_tags" => "Stress, Weakness",
        "price" => 550.00,
        "rating" => 4.7
    ],
    [
        "name" => "Bhringraj Oil",
        "category" => "Hair Care",
        "ingredients" => "Bhringraj, Sesame Oil",
        "disease_tags" => "Hair fall, Dandruff",
        "price" => 350.00,
        "rating" => 4.9
    ],
    [
        "name" => "Amla Capsules",
        "category" => "Immunity",
        "ingredients" => "Amla Extract",
        "disease_tags" => "Vitamin C Deficiency, Hair fall, Digestion",
        "price" => 299.00,
        "rating" => 4.5
    ],
    [
        "name" => "Herbal Hair Tonic",
        "category" => "Hair Care",
        "ingredients" => "Neem, Tulsi, Reetha",
        "disease_tags" => "Hair fall, Scalp Health",
        "price" => 420.00,
        "rating" => 4.6
    ]
];

foreach ($sample_updates as $product) {
    $name = mysqli_real_escape_string($conn, $product['name']);
    $cat = mysqli_real_escape_string($conn, $product['category']);
    $ing = mysqli_real_escape_string($conn, $product['ingredients']);
    $tags = mysqli_real_escape_string($conn, $product['disease_tags']);
    $price = $product['price'];
    $rating = $product['rating'];

    // Check if product exists
    $check = mysqli_query($conn, "SELECT id FROM products WHERE name = '$name'");
    if (mysqli_num_rows($check) > 0) {
        $update_sql = "UPDATE products SET category='$cat', ingredients='$ing', disease_tags='$tags', price='$price', rating='$rating' WHERE name='$name'";
        mysqli_query($conn, $update_sql);
        echo "✓ Updated product '$name'\n";
    } else {
        $insert_sql = "INSERT INTO products (name, category, ingredients, disease_tags, price, rating, image) VALUES ('$name', '$cat', '$ing', '$tags', '$price', '$rating', 'https://via.placeholder.com/300')";
        mysqli_query($conn, $insert_sql);
        echo "✓ Inserted product '$name'\n";
    }
}

echo "--- Migration Completed ---\n";
mysqli_close($conn);
?>