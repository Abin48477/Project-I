<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Shopping Bag Builder" page to make a place for all your toys!
echo "<h2>The Shopping Bag Builder</h2>";

// We build a big shopping bag room (table) with spots for your name and all your toys!
$table_sql = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id)
)";

if (mysqli_query($conn, $table_sql)) {
    // If it's built, we say "Yay! Your shopping bag is ready!"
    echo "<p style='color: green;'>Shopping bag room built successfully! Yippee!</p>";
} else {
    // If we can't build it, we show an error message!
    echo "<p style='color: red;'>Error building room: " . mysqli_error($conn) . "</p>";
}

echo "<h3>Migration Complete. <a href='HomePage.php'>Go Home</a></h3>";
?>