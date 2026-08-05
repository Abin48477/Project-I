<?php
// We tell the computer to remember who we are one last time!
session_start();
// We take off our name tag and put away all our secret stickers!
session_unset();
// We close the clubhouse door and turn off the lights!
session_destroy();
// We walk back to the front of the house!
header("Location: HomePage.php");
// We say "Goodbye! See you next time!"
exit();
?>