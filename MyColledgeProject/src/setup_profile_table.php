<?php
include 'connection.php';

// We are building a special "Treasure Map" (table) to keep all your health secrets!
$sql = "CREATE TABLE IF NOT EXISTS profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    full_name VARCHAR(100),
    age INT,
    gender VARCHAR(20),
    height DECIMAL(5,2),
    weight DECIMAL(5,2),
    waist DECIMAL(5,2),
    bmi DECIMAL(5,2),
    whtr DECIMAL(5,2),
    health_score INT DEFAULT 0,
    dosha_v INT DEFAULT 0,
    dosha_p INT DEFAULT 0,
    dosha_k INT DEFAULT 0,
    profile_image VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sql)) {
    echo "Success! Your health treasure map is ready!";
} else {
    echo "Oops! The map couldn't be made: " . mysqli_error($conn);
}
?>
