<?php
// We tell the computer to remember your name tag (session)!
session_start();
// We open the secret pipe to the treasure box!
include 'connection.php';

header('Content-Type: application/json');

// If you aren't wearing your name tag, we can't give you prizes!
if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

$username = $_SESSION['user'];
$action = $_REQUEST['action'] ?? '';
$dosha = mysqli_real_escape_string($conn, $_REQUEST['dosha'] ?? '');
$points_to_add = 0;
$message = "";
$date_column = "";
$today = date('Y-m-d');

// We check your shiny point balance and when was the last time you played!
$user_data_res = mysqli_query($conn, "SELECT points, last_quiz_date, last_remedy_date FROM users WHERE username = '$username'");
$user_data = mysqli_fetch_assoc($user_data_res);

if (!$user_data) {
    // If we can't find you in our book, we stop!
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit();
}

// These are our special notes for what we want to update!
$update_parts = [];
$show_success = false;

// Determine points and check daily limits
switch ($action) {
    case 'quiz_complete':
        // If you finished the game and found your team...
        if ($dosha) {
            $update_parts[] = "dosha = '$dosha'";
        }
        // We check if you already got points today!
        if (empty($user_data['last_quiz_date']) || $user_data['last_quiz_date'] != $today) {
            // Yay! 5 shiny points for you!
            $points_to_add = 5;
            $message = "Quiz Completed! +5 Points";
            $update_parts[] = "points = points + $points_to_add";
            $update_parts[] = "last_quiz_date = '$today'";
            $show_success = true;
        } else {
            // If you played already, we just update your team badge!
            $message = "Dosha Profile Updated!";
            $show_success = true;
        }
        break;
    case 'remedy_search':
        // If you found a magic cure for a tummy ache or a cough...
        if (empty($user_data['last_remedy_date']) || $user_data['last_remedy_date'] != $today) {
            // Yay! +5 more shiny coins for being a good helper!
            $points_to_add = 5;
            $message = "Remedy Searched! +5 Points";
            $update_parts[] = "points = points + $points_to_add";
            $update_parts[] = "last_remedy_date = '$today'";
            $show_success = true;
        } else {
            // If you already searched today, we say "You're already super smart!"
            $message = "Points already earned today for remedy search";
        }
        break;
}

if (empty($update_parts)) {
    echo json_encode(['status' => 'info', 'message' => 'No updates needed', 'new_points' => $user_data['points']]);
    exit();
}

// We tell the computer to update the big treasure box!
$update_sql = "UPDATE users SET " . implode(", ", $update_parts) . " WHERE username = '$username'";
if (mysqli_query($conn, $update_sql)) {
    // We check the new total to show you how rich you are!
    $res = mysqli_query($conn, "SELECT points FROM users WHERE username = '$username'");
    $row = mysqli_fetch_assoc($res);

    echo json_encode([
        'status' => 'success',
        'message' => $message,
        'new_points' => $row['points']
    ]);
} else {
    // If the box is stuck, we show an error!
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}
?>