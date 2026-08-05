<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// We get ready to make a twin of our treasure box!
$db_name = "project1";
// We give the twin box a special name with today's date and time!
$filename = "db_backup_" . $db_name . "_" . date("Y-m-d_H-i-s") . ".sql";

// Headers to force download
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

// 1. We look at all the different rooms (tables) in our treasure box!
$tables = array();
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    // We write down the name of each room!
    $tables[] = $row[0];
}

// Cycle through each table
$return = "";
foreach ($tables as $table) {
    $result = mysqli_query($conn, "SELECT * FROM `$table`");
    $num_fields = mysqli_num_fields($result);

    // We tell the computer to clear out any old rooms with the same name!
    $return .= "DROP TABLE IF EXISTS `$table`;\n";

    // We write down the instructions on how to build the room again!
    $row2 = mysqli_fetch_row(mysqli_query($conn, "SHOW CREATE TABLE `$table`"));
    $return .= "\n\n" . $row2[1] . ";\n\n";

    // 2. We put all the toys (data) back into the instruction book!
    while ($row = mysqli_fetch_row($result)) {
        $return .= "INSERT INTO `$table` VALUES(";
        for ($j = 0; $j < $num_fields; $j++) {
            // We clean the toys so they look nice in the book!
            $row[$j] = addslashes($row[$j]);
            $row[$j] = str_replace("\n", "\\n", $row[$j]);
            if (isset($row[$j])) {
                $return .= '"' . $row[$j] . '"';
            } else {
                $return .= '""';
            }
            if ($j < ($num_fields - 1)) {
                $return .= ',';
            }
        }
        $return .= ");\n";
    }
    $return .= "\n\n\n";
}

echo $return;
exit();
?>