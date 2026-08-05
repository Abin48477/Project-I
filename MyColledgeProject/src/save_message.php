<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// We check if someone is trying to send a letter!
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // We read all the words you wrote in the boxes!
    // It's like listening carefully to what you have to say!
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    // We check if you forgot to write your name or your message!
    if (empty($name) || empty($email) || empty($message)) {
        // If you forgot, we tell you to go back and fill it in!
        echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
        exit;
    }

    // We put all your words into one big envelope!
    $full_message = "Subject: $subject\n\n$message";

    // Prepare a quick note to the admin so they see it right away.
    $adminEmail = 'support@ayurveda.com'; // Update if your admin inbox changes
    $mailSubject = "New Contact Message: $subject";
    $mailBody = "From: $name <$email>\n\n$message";
    // We put the envelope into our secret letterbox (database table)!
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$full_message')";

    if (mysqli_query($conn, $sql)) {
        // If it fits, we say "Great! We got your letter!"
        // Send a notification email to the admin; ignore mail errors silently
        @mail($adminEmail, $mailSubject, $mailBody, "From: $email");

        echo json_encode(['status' => 'success', 'message' => 'Message saved successfully.']);
    } else {
        // If the letterbox is stuck, we show a red oops message!
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
} else {
    // If you try to peak without sending a letter, we say "Wrong door!"
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
