<?php
// This is our secret pipe that goes into the treasure box!
$servername = "localhost"; // The clubhouse address!
$username = "root"; // Our secret name!
$password = ""; // Our secret key!
$database = "project1"; // The name of our big treasure box!

// We push the secret pipe into the treasure box!
$conn = mysqli_connect($servername, $username, $password, $database);

// We check if the pipe is working!
if (!$conn) {
    // If it's broken, we say "Oh no!"
    die("Connection failed: " . mysqli_connect_error());
}
?>