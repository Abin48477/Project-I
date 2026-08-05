<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Big House Move" page to add new rooms to our treasure box!
echo "<h2>The Big House Move</h2>";

// These are the magic spells to build new rooms for coins and stickers!
$queries = [
    // Move 1: Make a room for how you paid for your toys!
    "ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_method VARCHAR(50) DEFAULT 'unspecified' AFTER total_amount",
    // Move 2: Make a room to say if you already gave the coins!
    "ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending' AFTER payment_method",
    // Move 3: Make a room for the special transaction secret code!
    "ALTER TABLE orders ADD COLUMN IF NOT EXISTS transaction_id VARCHAR(100) NULL AFTER payment_status"
];

echo "<h2>Starting Database Migration...</h2>";

foreach ($queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "<p style='color: green;'>Success: " . htmlspecialchars($query) . "</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . " | Query: " . htmlspecialchars($query) . "</p>";
    }
}

echo "<h3>Migration Complete. <a href='checkout.php'>Go to Checkout</a></h3>";
?>