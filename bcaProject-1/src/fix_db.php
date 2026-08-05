<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Giant Magic Hammer" to make sure the treasure box has all its rooms!
echo "<h2>The Giant Magic Hammer</h2>";

// This little magic trick checks if a room (column) is missing...
function addColumnIfNeeded($conn, $table, $column, $definition)
{
    echo "Checking for a tiny room called <strong>$column</strong>... ";

    $check = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    if (!$check) {
        // If we can't look inside, we show an error!
        echo "<span style='color: red;'>Error looking: " . mysqli_error($conn) . "</span><br>";
        return;
    }

    if (mysqli_num_rows($check) == 0) {
        // If the room is missing, we build it with our hammer!
        echo "Missing. Building now... ";
        $sql = "ALTER TABLE `$table` ADD COLUMN `$column` $definition";
        if (mysqli_query($conn, $sql)) {
            echo "<span style='color: green;'>Yay! Room built!</span><br>";
        } else {
            echo "<span style='color: red;'>Oops, hammer broke: " . mysqli_error($conn) . "</span><br>";
        }
    } else {
        // If the room is already there, we say "All good!"
        echo "<span style='color: blue;'>Already there. Skipping!</span><br>";
    }
}

// Add the columns one by one
addColumnIfNeeded($conn, 'orders', 'payment_method', "VARCHAR(50) DEFAULT 'unspecified' AFTER total_amount");
addColumnIfNeeded($conn, 'orders', 'payment_status', "ENUM('pending', 'paid', 'failed') DEFAULT 'pending' AFTER payment_method");
addColumnIfNeeded($conn, 'orders', 'transaction_id', "VARCHAR(100) NULL AFTER payment_status");

echo "<h3>Ensuring User Columns for Gamification</h3>";
addColumnIfNeeded($conn, 'users', 'points', "INT DEFAULT 0");
addColumnIfNeeded($conn, 'users', 'streak_count', "INT DEFAULT 0");
addColumnIfNeeded($conn, 'users', 'last_active_date', "DATE NULL");
addColumnIfNeeded($conn, 'users', 'last_quiz_date', "DATE NULL");
addColumnIfNeeded($conn, 'users', 'last_remedy_date', "DATE NULL");
addColumnIfNeeded($conn, 'users', 'dosha', "VARCHAR(20) NULL");

echo "<h3>Building the Shopping Bag Room (Cart Table)</h3>";
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
    // If it's built, we say "Great! Now you can save your toys!"
    echo "<p style='color: green;'>Shopping bag room is ready!</p>";
} else {
    // If we can't build it, we show an error message!
    echo "<p style='color: red;'>Error building room: " . mysqli_error($conn) . "</p>";
}

echo "<hr>";
echo "<h3>User Verification</h3>";
// Check if user 'prabin' exists
$user_check = mysqli_query($conn, "SELECT id, username FROM users WHERE username LIKE '%prabin%'");
if ($user_check && mysqli_num_rows($user_check) > 0) {
    echo "Found user(s) matching 'prabin':<br><ul>";
    while ($u = mysqli_fetch_assoc($user_check)) {
        echo "<li>ID: {$u['id']} | Username: {$u['username']}</li>";
    }
    echo "</ul>";
} else {
    echo "No user found with username containing 'prabin'.<br>";
    echo "Recent users:<br><ul>";
    $recent = mysqli_query($conn, "SELECT id, username FROM users ORDER BY id DESC LIMIT 5");
    while ($u = mysqli_fetch_assoc($recent)) {
        echo "<li>ID: {$u['id']} | Username: {$u['username']}</li>";
    }
    echo "</ul>";
}

echo "<br><a href='checkout.php'>Go back to Checkout</a>";
?>