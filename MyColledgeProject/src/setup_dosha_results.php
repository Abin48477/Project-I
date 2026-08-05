<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Scoreboard Setup" page to make a place for all your game points!
echo "<h2>The Scoreboard Setup</h2>";

// We build a big scoreboard (table) with spots for your name and your Air, Fire, and Earth scores!
$sql = "CREATE TABLE IF NOT EXISTS dosha_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vata_percentage DECIMAL(5,2) DEFAULT 0,
    pitta_percentage DECIMAL(5,2) DEFAULT 0,
    kapha_percentage DECIMAL(5,2) DEFAULT 0,
    dominant_dosha VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    // If it's built, we say "Yay! Now we can see who's winning!"
    echo 'Scoreboard built successfully! Yippee!';
} else {
    // If we can't build it, we show an error message!
    echo 'Error building scoreboard: ' . mysqli_error($conn);
}
?>