<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
if (!$conn) die("Connection failed");

$folders = [
    'ourProductsImages/',
    'PlantsImages/',
    'full_imageContainer/product/'
];

$res = mysqli_query($conn, "SELECT id, name FROM products");
$updated = 0;

while ($row = mysqli_fetch_assoc($res)) {
    $id = $row['id'];
    $name = strtolower($row['name']);
    $bestMatch = null;
    
    foreach ($folders as $folder) {
        $files = glob("d:/xampp/htdocs/MyColledgeProject/" . $folder . "*");
        foreach ($files as $file) {
            $filename = strtolower(basename($file));
            
            // Basic matching logic
            // Remove extensions and spaces/punctuation for comparison
            $cleanName = preg_replace('/[^a-z0-9]/', '', $name);
            $cleanFile = preg_replace('/[^a-z0-9]/', '', pathinfo($filename, PATHINFO_FILENAME));
            
            // Special mappings for typos/variations
            if (strpos($cleanName, 'ashwagandha') !== false) $cleanName = 'ashwaganda';
            if (strpos($cleanFile, 'ashowganda') !== false) $cleanFile = 'ashwaganda';
            if (strpos($cleanName, 'shilajit') !== false) $cleanName = 'shilijit';
            if (strpos($cleanName, 'shillijit') !== false) $cleanName = 'shilijit';
            if (strpos($cleanName, 'shilijit') !== false) $cleanName = 'shilijit';
            if (strpos($cleanName, 'shatavari') !== false) $cleanName = 'satabari';
            if (strpos($cleanName, 'chiraito') !== false) $cleanName = 'chirito';
            if (strpos($cleanName, 'sarpagandha') !== false) $cleanName = 'sarpaganda';

            if (strpos($cleanName, $cleanFile) !== false || strpos($cleanFile, $cleanName) !== false) {
                $bestMatch = "../" . $folder . basename($file);
                break 2;
            }
        }
    }
    
    if ($bestMatch) {
        mysqli_query($conn, "UPDATE products SET image = '$bestMatch' WHERE id = $id");
        echo "Updated $id ($name) -> $bestMatch\n";
        $updated++;
    }
}

echo "Total updated: $updated\n";
?>
