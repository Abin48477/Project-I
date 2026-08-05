<?php
// This is like a secret pipe that connects our game to a giant box of treasure!
// We tell the computer where the box is, and what the key is!
$conn = mysqli_connect("localhost", "root", "", "project1"); // This is the magic key to open our treasure box!

// This checks if the pipe is broken or if we can't find the box!
if (!$conn) {
    // If the pipe is broken, we tell everyone "Oh no! We can't reach the treasure!"
    die("Connection failed: " . mysqli_connect_error());
}   
?>  