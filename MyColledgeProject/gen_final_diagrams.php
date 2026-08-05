<?php
// --- DATABASE SCHEMA FETCH ---
$conn = mysqli_connect('localhost', 'root', '', 'project1');
$tables = [];
if ($conn) {
    $res = mysqli_query($conn, 'SHOW TABLES');
    while($row = mysqli_fetch_array($res)) {
        $t = $row[0];
        $cols = [];
        $res2 = mysqli_query($conn, "DESCRIBE $t");
        while($c = mysqli_fetch_assoc($res2)) {
            $cols[] = $c;
        }
        $tables[$t] = $cols;
    }
}

// --- GENERATE USE CASE DIAGRAM SVG ---
$svgUC = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg width="1000" height="900" viewBox="0 0 1000 900" xmlns="http://www.w3.org/2000/svg" style="background-color: white;">
  <!-- System Boundary -->
  <rect x="250" y="50" width="500" height="800" fill="none" stroke="black" stroke-width="2" />
  <text x="500" y="35" font-family="Arial" font-size="20" font-weight="bold" text-anchor="middle">Ayurvedic Health Portal System</text>

  <!-- Actors (Stickmen simplified) -->
  <!-- User -->
  <g transform="translate(100, 400)">
    <circle cx="0" cy="-40" r="20" fill="none" stroke="black" stroke-width="2" />
    <line x1="0" y1="-20" x2="0" y2="20" stroke="black" stroke-width="2" />
    <line x1="-30" y1="0" x2="30" y2="0" stroke="black" stroke-width="2" />
    <line x1="0" y1="20" x2="-20" y2="50" stroke="black" stroke-width="2" />
    <line x1="0" y1="20" x2="20" y2="50" stroke="black" stroke-width="2" />
    <text x="0" y="80" font-family="Arial" font-size="24" font-weight="bold" text-anchor="middle">User</text>
  </g>

  <!-- Admin -->
  <g transform="translate(900, 400)">
    <circle cx="0" cy="-40" r="20" fill="none" stroke="black" stroke-width="2" />
    <line x1="0" y1="-20" x2="0" y2="20" stroke="black" stroke-width="2" />
    <line x1="-30" y1="0" x2="30" y2="0" stroke="black" stroke-width="2" />
    <line x1="0" y1="20" x2="-20" y2="50" stroke="black" stroke-width="2" />
    <line x1="0" y1="20" x2="20" y2="50" stroke="black" stroke-width="2" />
    <text x="0" y="80" font-family="Arial" font-size="24" font-weight="bold" text-anchor="middle">Admin</text>
  </g>

  <!-- Use Cases (Ovals) -->
  <style> .uc { fill: white; stroke: black; stroke-width: 2; } .ut { font-family: Arial; font-size: 18; text-anchor: middle; font-weight: bold; } </style>
  
  <ellipse cx="500" cy="100" rx="140" ry="40" class="uc" /> <text x="500" y="105" class="ut">Register/Login</text>
  <ellipse cx="500" cy="200" rx="140" ry="40" class="uc" /> <text x="500" y="205" class="ut">Take Dosha Quiz</text>
  <ellipse cx="500" cy="300" rx="140" ry="40" class="uc" /> <text x="500" y="305" class="ut">View Recommendations</text>
  <ellipse cx="500" cy="400" rx="140" ry="40" class="uc" /> <text x="500" y="405" class="ut">Purchase Products</text>
  <ellipse cx="500" cy="500" rx="140" ry="40" class="uc" /> <text x="500" y="505" class="ut">Contact Support</text>

  <ellipse cx="500" cy="650" rx="140" ry="40" class="uc" /> <text x="500" y="655" class="ut">Manage Products</text>
  <ellipse cx="500" cy="750" rx="140" ry="40" class="uc" /> <text x="500" y="755" class="ut">View Orders</text>

  <!-- Connections User -->
  <line x1="130" y1="400" x2="360" y2="100" stroke="black" stroke-width="1.5" />
  <line x1="130" y1="400" x2="360" y2="200" stroke="black" stroke-width="1.5" />
  <line x1="130" y1="400" x2="360" y2="300" stroke="black" stroke-width="1.5" />
  <line x1="130" y1="400" x2="360" y2="400" stroke="black" stroke-width="1.5" />
  <line x1="130" y1="400" x2="360" y2="500" stroke="black" stroke-width="1.5" />

  <!-- Connections Admin -->
  <line x1="870" y1="400" x2="640" y2="100" stroke="black" stroke-width="1.5" />
  <line x1="870" y1="400" x2="640" y2="650" stroke="black" stroke-width="1.5" />
  <line x1="870" y1="400" x2="640" y2="750" stroke="black" stroke-width="1.5" />
</svg>';

file_put_contents("d:/xampp/htdocs/MyColledgeProject/DFD/UseCaseDiagram.svg", $svgUC);

// --- GENERATE DATABASE SCHEMA SVG ---
$svgDB = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg width="1200" height="1000" viewBox="0 0 1200 1000" xmlns="http://www.w3.org/2000/svg" style="background-color: white;">
  <text x="600" y="40" font-family="Arial" font-size="32" font-weight="bold" text-anchor="middle">Database Physical Schema</text>
';

$x = 50; $y = 100;
$row_height = 30;
$col_width = 300;

foreach ($tables as $name => $cols) {
    $height = (count($cols) + 1) * $row_height;
    $svgDB .= "  <rect x=\"$x\" y=\"$y\" width=\"$col_width\" height=\"$height\" fill=\"white\" stroke=\"black\" stroke-width=\"2\" />\n";
    $svgDB .= "  <rect x=\"$x\" y=\"$y\" width=\"$col_width\" height=\"$row_height\" fill=\"#f0f0f0\" stroke=\"black\" stroke-width=\"2\" />\n";
    $svgDB .= "  <text x=\"".($x + $col_width/2)."\" y=\"".($y + 22)."\" font-family=\"Arial\" font-size=\"20\" font-weight=\"bold\" text-anchor=\"middle\">$name</text>\n";
    
    $cy = $y + $row_height + 22;
    foreach ($cols as $c) {
        $pk = ($c['Key'] == 'PRI') ? " (PK)" : "";
        $txt = $c['Field'] . " " . $c['Type'] . $pk;
        $svgDB .= "  <text x=\"".($x + 10)."\" y=\"$cy\" font-family=\"Arial\" font-size=\"16\">$txt</text>\n";
        $cy += $row_height;
    }
    
    $y += $height + 40;
    if ($y > 800) { $y = 100; $x += $col_width + 50; }
}

$svgDB .= '</svg>';
file_put_contents("d:/xampp/htdocs/MyColledgeProject/DFD/DatabaseSchema.svg", $svgDB);

echo "Diagrams created successfully.";
?>
