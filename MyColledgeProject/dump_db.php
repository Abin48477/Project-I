<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
if (!$conn) die("Connection failed");
$res = mysqli_query($conn, 'SHOW TABLES');
while($row = mysqli_fetch_array($res)) {
    $table = $row[0];
    echo "Table: $table\n";
    $cols = mysqli_query($conn, "DESCRIBE $table");
    while($c = mysqli_fetch_assoc($cols)) {
        echo " - " . $c['Field'] . " (" . $c['Type'] . ")\n";
    }
}
?>
