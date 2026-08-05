<?php
// We open the secret pipe to the treasure box!
include 'connection.php';
// We tell the computer to remember who we are!
session_start();

// We check if you are the big boss (admin) or just a friend!
if (!isset($_SESSION['user'])) {
    // If you aren't signed in, go to the front door!
    header("Location: ../src/login.php");
    exit();
}
$username = $_SESSION['user'];
$user_check = mysqli_query($conn, "SELECT role FROM users WHERE username='$username'");
$user_role = mysqli_fetch_assoc($user_check)['role'];
if ($user_role !== 'admin') {
    // Only the big boss can throw things in the trash!
    header("Location: ../src/HomePage.php?error=access_denied");
    exit();
}

// If we know which whisper to throw away...
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    // We tell the treasure box to "Forget this message!"
    $query = "DELETE FROM contact_messages WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // If the trash can is stuck, we show an error!
        die("Query Failed" . mysqli_error($conn));
    } else {
        // We go back to the whisper page and say "It's gone!"
        header('location:messages.php?delete_msg=Message deleted successfully');
    }
}
?>