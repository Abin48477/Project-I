<?php
include 'connection.php';

echo "<h2>Migrating Users Table for Gamification</h2>";

function addColumnIfNeeded($conn, $table, $column, $definition)
{
    echo "Checking <strong>$column</strong>... ";
    $check = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "ALTER TABLE `$table` ADD COLUMN `$column` $definition";
        if (mysqli_query($conn, $sql)) {
            echo "<span style='color: green;'>Added.</span><br>";
        } else {
            echo "<span style='color: red;'>Failed: " . mysqli_error($conn) . "</span><br>";
        }
    } else {
        echo "<span style='color: blue;'>Exists.</span><br>";
    }
}

// Add columns for Streak and Points
addColumnIfNeeded($conn, 'users', 'points', "INT DEFAULT 0");
addColumnIfNeeded($conn, 'users', 'streak_count', "INT DEFAULT 0");
addColumnIfNeeded($conn, 'users', 'last_active_date', "DATE NULL");

echo "<h3>Migration Complete. <a href='login.php'>Go to Login</a></h3>";
?>