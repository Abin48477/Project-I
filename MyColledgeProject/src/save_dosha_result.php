<?php
// We tell the computer to remember your name tag!
session_start();
// We open the secret pipe to the treasure box!
include 'connection.php';

header('Content-Type: application/json');

// We check if the game is knocking on our door correctly!
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // If it's a wrong way to knock, we say "Go away!"
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// We check if you have your name tag on (are logged in)!
if (!isset($_SESSION['user'])) {
    // If you're a stranger, we can't save your score!
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

// We read the secret message the game sent us about how well you did!
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    // If the message is garbled, we stop!
    echo json_encode(['error' => 'Invalid JSON payload']);
    exit;
}

$username = $_SESSION['user'];

// We find your secret name tag in the big book of members!
$userQuery = "SELECT id FROM users WHERE username='" . mysqli_real_escape_string($conn, $username) . "'";
$res = mysqli_query($conn, $userQuery);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_id = $row['id'];
} else {
    // If we can't find you, we can't save your prize!
    echo json_encode(['error' => 'User not found']);
    exit;
}

// We count all the Air, Fire, and Earth points you got!
$v = isset($data['vata_percentage']) ? (float) $data['vata_percentage'] : 0;
$p = isset($data['pitta_percentage']) ? (float) $data['pitta_percentage'] : 0;
$k = isset($data['kapha_percentage']) ? (float) $data['kapha_percentage'] : 0;
// We find out which team won!
$dom = isset($data['dominant_dosha']) ? mysqli_real_escape_string($conn, $data['dominant_dosha']) : 'Unknown';

// We write down your scores in our Hall of Fame (database table)!
$sql = "INSERT INTO dosha_results (user_id, vata_percentage, pitta_percentage, kapha_percentage, dominant_dosha) 
        VALUES ($user_id, $v, $p, $k, '$dom')";

if (mysqli_query($conn, $sql)) {
    // Keep user's current dominant dosha in users table for quick profile/nav access
    $updateUserDoshaSql = "UPDATE users SET dosha='$dom' WHERE id=$user_id";
    mysqli_query($conn, $updateUserDoshaSql);

    // If it's saved, we say "Yay! Your trophy is safe!"
    echo json_encode(['success' => true]);
} else {
    // If the trophy box is broken, we show an error message!
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
}
?>
