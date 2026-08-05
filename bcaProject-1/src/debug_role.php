<?php
// We open the secret pipe to the treasure box!
include 'connection.php';
// We tell the computer to remember our name!
session_start();

// This is our "Detective Glass" to see if you have a Big Boss hat!
echo "<h2>The Detective's Glass</h2>";

// 1. Let's see whose name is written on the clubhouse door!
$s_user = $_SESSION['user'] ?? 'Not logged in';
echo "The door says: <strong>$s_user</strong> is here!<br><hr>";

// 2. Check specific users
$users_to_check = ['abin', 'prabin', $s_user];

foreach ($users_to_check as $u) {
    if ($u === 'Not logged in')
        continue;

    // We look into the treasure book to find out what hat you're wearing!
    echo "Looking for friend: <strong>$u</strong> in the book...<br>";
    $res = mysqli_query($conn, "SELECT id, username, role FROM users WHERE username='$u'");
    if ($row = mysqli_fetch_assoc($res)) {
        $raw_role = $row['role'];
        $processed_role = strtolower(trim($raw_role));

        echo "Raw Role (DB): [" . $raw_role . "]<br>";
        echo "Processed Role: [" . $processed_role . "]<br>";

        if ($processed_role === 'admin') {
            echo "<span style='color:red; font-weight:bold;'>result: IS ADMIN</span>";
        } else {
            echo "<span style='color:green; font-weight:bold;'>result: IS USER</span>";
        }
    } else {
        echo "User '$u' not found in database.";
    }
    echo "<br><br>";
}
?>