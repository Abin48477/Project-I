<?php
include 'connection.php';

$filename = "project1_backup.sql";
$handle = fopen($filename, 'w+');

if ($handle) {
    // Header
    fwrite($handle, "-- Database Backup for 'project1'\n");
    fwrite($handle, "-- Generated: " . date("Y-m-d H:i:s") . "\n\n");
    fwrite($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n");
    fwrite($handle, "START TRANSACTION;\n");
    fwrite($handle, "SET time_zone = \"+00:00\";\n\n");

    $tables = array();
    $result = mysqli_query($conn, "SHOW TABLES");
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    foreach ($tables as $table) {
        $result = mysqli_query($conn, "SELECT * FROM `$table`");
        $num_fields = mysqli_num_fields($result);

        fwrite($handle, "DROP TABLE IF EXISTS `$table`;\n");
        $row2 = mysqli_fetch_row(mysqli_query($conn, "SHOW CREATE TABLE `$table`"));
        fwrite($handle, $row2[1] . ";\n\n");

        while ($row = mysqli_fetch_row($result)) {
            fwrite($handle, "INSERT INTO `$table` VALUES(");
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = str_replace("\n", "\\n", $row[$j]);
                if (isset($row[$j])) {
                    fwrite($handle, '"' . $row[$j] . '"');
                } else {
                    fwrite($handle, '""');
                }
                if ($j < ($num_fields - 1)) {
                    fwrite($handle, ',');
                }
            }
            fwrite($handle, ");\n");
        }
        fwrite($handle, "\n\n");
    }

    fwrite($handle, "COMMIT;\n");
    fclose($handle);
    echo "Backup file created successfully: <a href='$filename' download>$filename</a>";
} else {
    echo "Error creating file. Check permissions.";
}
?>