<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// We check if you asked for a specific plant name!
if (isset($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    // We look in our "Nature's Toy Box" (medicinal_plants table) for this plant!
    $sql = "SELECT * FROM medicinal_plants WHERE name='$name'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // If we find it, we show you all its pretty details!
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        // If we can't find it, we say "Oops! That plant isn't in our box."
        echo json_encode(['success' => false, 'message' => 'Plant not found (searched for: ' . $name . ')']);
    }
} else {
    // If you didn't give us a name, we tell you we need one!
    echo json_encode(['success' => false, 'message' => 'No name provided']);
}
?>