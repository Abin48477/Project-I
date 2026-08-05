<?php
include 'connection.php';

// Check if guna column exists before dropping
$check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'guna'");
if (mysqli_num_rows($check) > 0) {
    $result = mysqli_query($conn, "ALTER TABLE users DROP COLUMN guna");
    if ($result) {
        echo "<p style='color:green;font-family:sans-serif;'>✅ SUCCESS: <code>guna</code> column dropped from <code>users</code> table.</p>";
    } else {
        echo "<p style='color:red;font-family:sans-serif;'>❌ ERROR: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:orange;font-family:sans-serif;'>⚠️ Column <code>guna</code> not found – may have already been removed.</p>";
}

mysqli_close($conn);

// Self-delete this script after running
$self = __FILE__;
echo "<p style='font-family:sans-serif;'>🗑️ This cleanup script will now delete itself...</p>";
unlink($self);
echo "<p style='font-family:sans-serif;font-weight:bold;'>✅ All done. <a href='HomePage.php'>Return to Home</a></p>";
?>