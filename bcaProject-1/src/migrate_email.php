<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Letterbox Builder" page to add email boxes for every friend!
echo "<h2>The Letterbox Builder</h2>";

// 1. We check if friends already have a spot for their letterbox!
$check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'email'");
if (mysqli_num_rows($check) == 0) {
    // 2. We build a new room for the letterbox next to their nickname!
    mysqli_query($conn, "ALTER TABLE users ADD email VARCHAR(255) NULL AFTER username");

    // 3. We give everyone a temporary letterbox name so their room isn't empty!
    mysqli_query($conn, "UPDATE users SET email = CONCAT(username, '@temp.com') WHERE email IS NULL OR email = ''");

    // 4. We make the letterbox super official and make sure no two friends have the same one!
    $sql = "ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL, ADD UNIQUE(email)";
    if (mysqli_query($conn, $sql)) {
        // If it's done, we say "Yay! Everyone has a secret mail-box now!"
        echo "Letterboxes built successfully! Yippee!";
    } else {
        // If the hammer broke, we show an error!
        echo "Oops, the mail-box is stuck: " . mysqli_error($conn);
    }
} else {
    echo "Column 'email' already exists.";
}
?>