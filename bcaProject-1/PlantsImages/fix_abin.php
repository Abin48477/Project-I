<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Hammer and Screwdriver" page to fix broken name tags!
echo "<h2>The Treasure Book Repair Shop</h2>";

// 1. Check Table Structure
$res = mysqli_query($conn, "DESCRIBE users");
echo "<h3>Users Table Structure:</h3><table border='1'><tr><th>Field</th><th>Type</th><th>Default</th></tr>";
while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Default']}</td></tr>";
}
echo "</table>";

// 1. We make sure every new friend starts with a "User" hat!
echo "Setting secret rule for new hats... ";
$alter = mysqli_query($conn, "ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'user'");
if ($alter)
    echo "Done! Everyone gets a normal hat now.<br>";

// 2. We make sure our friend 'abin' has a normal hat too!
$fix = mysqli_query($conn, "UPDATE users SET role = 'user' WHERE username = 'abin'");
if ($fix) {
    echo "<p style='color:green;'>Yay! Friend 'abin' is now wearing a normal hat!</p>";
}

// 3. See all users and roles
echo "<h3>Current Users:</h3><table border='1'><tr><th>Username</th><th>Role</th></tr>";
$all = mysqli_query($conn, "SELECT username, role FROM users");
while ($u = mysqli_fetch_assoc($all)) {
    echo "<tr><td>{$u['username']}</td><td>{$u['role']}</td></tr>";
}
echo "</table>";
?>