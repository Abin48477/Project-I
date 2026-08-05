<?php
// We open the secret pipe to the treasure box!
include 'connection.php';

// This is our "Garden Planner" page to make a place for all our plants!
echo "<h2>The Garden Planner</h2>";

// Create Table
// We build a big, beautiful garden (table) with spots for plant names and magic instructions!
$sql = "CREATE TABLE IF NOT EXISTS medicinal_plants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    uses TEXT,
    advantages TEXT,
    dosage_vata VARCHAR(255),
    dosage_pitta VARCHAR(255),
    dosage_kapha VARCHAR(255)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'medicinal_plants' created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Data Array
$plants = [
    [
        'name' => 'Amala',
        'uses' => 'Digestion, Immune Booster, Hair Health',
        'advantages' => 'Rich in Vitamin C, acts as a powerful antioxidant.',
        'dosage_vata' => '1 tsp powder with sesame oil',
        'dosage_pitta' => '1 tsp powder with ghee',
        'dosage_kapha' => '1 tsp powder with honey'
    ],
    [
        'name' => 'Ashwagandha',
        'uses' => 'Stress relief, Energy booster, Strength',
        'advantages' => 'Reduces cortisol levels, improves sleep quality.',
        'dosage_vata' => '1/2 tsp with warm milk',
        'dosage_pitta' => '1/2 tsp with ghee (rarely used for high Pitta)',
        'dosage_kapha' => '1/2 tsp with honey or warm water'
    ],
    [
        'name' => 'Tulsi',
        'uses' => 'Cough, Cold, Respiratory health',
        'advantages' => 'Adaptogen, fights infections, supports heart health.',
        'dosage_vata' => 'Tea with ginger',
        'dosage_pitta' => 'Tea with rose petals',
        'dosage_kapha' => 'Tea with black pepper'
    ],
    [
        'name' => 'Silajit',
        'uses' => 'Stamina, Anti-aging, Vitality',
        'advantages' => 'Contains fulvic acid, rejuvenates the body.',
        'dosage_vata' => 'Pea-sized resin with warm milk',
        'dosage_pitta' => 'Pea-sized resin with milk (caution required)',
        'dosage_kapha' => 'Pea-sized resin with honey and triphala'
    ],
    [
        'name' => 'Kutki',
        'uses' => 'Liver health, Fever, Skin issues',
        'advantages' => 'Excellent hepatoprotective (liver protecting) herb.',
        'dosage_vata' => 'High dose not recommended (cooling)',
        'dosage_pitta' => '1/4 tsp with aloe vera juice',
        'dosage_kapha' => '1/4 tsp with honey'
    ],
    [
        'name' => 'Barro',
        'uses' => 'Eye health, Hair growth, Digestion',
        'advantages' => 'One of the three fruits in Triphala.',
        'dosage_vata' => 'Powder with oil',
        'dosage_pitta' => 'Powder with ghee',
        'dosage_kapha' => 'Powder with honey'
    ],
    [
        'name' => 'Bojho',
        'uses' => 'Speech clarity, Memory, Sore throat',
        'advantages' => 'Improves voice and cognitive function.',
        'dosage_vata' => 'Small piece cheated or powder with warm water',
        'dosage_pitta' => 'Not recommended (heating)',
        'dosage_kapha' => 'Powder with honey'
    ],
    [
        'name' => 'Chiraito',
        'uses' => 'Fever, Skin diseases, Blood purification',
        'advantages' => 'Bitter tonic, good for infections.',
        'dosage_vata' => 'Use with caution (drying)',
        'dosage_pitta' => 'Cold infusion (soak overnight)',
        'dosage_kapha' => 'Decoction or powder'
    ],
    [
        'name' => 'Harro',
        'uses' => 'Digestion, Detox, Vision',
        'advantages' => 'King of medicines in Ayurveda (Haritaki).',
        'dosage_vata' => 'With ghee',
        'dosage_pitta' => 'With sugar',
        'dosage_kapha' => 'With rock salt'
    ],
    [
        'name' => 'Pachaula',
        'uses' => 'Gastric trouble, Indigestion',
        'advantages' => 'Improves appetite and digestive fire.',
        'dosage_vata' => 'Powder with warm water',
        'dosage_pitta' => 'Avoid excess use',
        'dosage_kapha' => 'Powder with honey'
    ],
    [
        'name' => 'Sarpaganda',
        'uses' => 'Hypertension, Insomnia, Anxiety',
        'advantages' => 'Lowers blood pressure naturally.',
        'dosage_vata' => 'With warm milk before bed for sleep',
        'dosage_pitta' => 'With rose water',
        'dosage_kapha' => 'With honey'
    ],
    [
        'name' => 'Satuwa',
        'uses' => 'Poison antidote, Fever, Wounds',
        'advantages' => 'Traditional remedy for snake bites and infections.',
        'dosage_vata' => 'Paste externally or small internal dose',
        'dosage_pitta' => 'Paste with cooling herbs',
        'dosage_kapha' => 'Paste with turmeric'
    ],
    [
        'name' => 'Timur',
        'uses' => 'Toothache, Digestion, Circulation',
        'advantages' => 'Warming spice, good for cold climate.',
        'dosage_vata' => 'In food or oil massage',
        'dosage_pitta' => 'Avoid (very heating)',
        'dosage_kapha' => 'Chew seeds or tea'
    ],
    [
        'name' => 'Yarsagumba',
        'uses' => 'Libido, Stamina, Lung health',
        'advantages' => 'Himalayan Viagra, boosts immunity.',
        'dosage_vata' => 'Boiled in milk',
        'dosage_pitta' => 'With milk and ghee',
        'dosage_kapha' => 'With honey'
    ]
];

foreach ($plants as $plant) {
    $name = $plant['name'];
    $uses = $plant['uses'];
    $advantages = $plant['advantages'];
    $vata = $plant['dosage_vata'];
    $pitta = $plant['dosage_pitta'];
    $kapha = $plant['dosage_kapha'];

    $check = mysqli_query($conn, "SELECT id FROM medicinal_plants WHERE name='$name'");
    if (mysqli_num_rows($check) == 0) {
        $insert = "INSERT INTO medicinal_plants (name, uses, advantages, dosage_vata, dosage_pitta, dosage_kapha) 
                   VALUES ('$name', '$uses', '$advantages', '$vata', '$pitta', '$kapha')";
        if (mysqli_query($conn, $insert)) {
            echo "Added $name.<br>";
        } else {
            echo "Error adding $name: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "$name already exists.<br>";
    }
}
echo "<br>Done!";
?>