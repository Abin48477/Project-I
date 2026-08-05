<?php
$conn = mysqli_connect('localhost', 'root', '', 'project1');
if (!$conn) die("Connection failed");

$products = [
    [
        'name' => 'Ashwagandha Churna',
        'description' => 'Pure Ashwagandha powder for stress relief and energy.',
        'price' => 450.00,
        'image' => '../ourProductsImages/ashowganda_churna.jpg',
        'category' => 'Herbal Powder',
        'disease_tags' => 'stress, fatigue, immunity',
        'ingredients' => 'Withania somnifera root'
    ],
    [
        'name' => 'Chiraito Extract',
        'description' => 'Bitter herb best for blood purification and fever.',
        'price' => 250.00,
        'image' => '../ourProductsImages/chirito.jpg',
        'category' => 'Extract',
        'disease_tags' => 'fever, skin, blood purifier',
        'ingredients' => 'Swertia chirayita'
    ],
    [
        'name' => 'Kutki Power',
        'description' => 'Effective for liver health and digestion.',
        'price' => 850.00,
        'image' => '../ourProductsImages/kutki product.png',
        'category' => 'Supplement',
        'disease_tags' => 'liver, digestion, weight loss',
        'ingredients' => 'Picrorhiza kurroa'
    ],
    [
        'name' => 'Pure Shilajit Resin',
        'description' => 'Ancient Himalayan resin for strength and vitality.',
        'price' => 1250.00,
        'image' => '../ourProductsImages/shilijit.jpg',
        'category' => 'Resin',
        'disease_tags' => 'strength, stamina, minerals',
        'ingredients' => 'Asphaltum punjabianum'
    ],
    [
        'name' => 'Yarsagumba Special',
        'description' => 'The Himalayan Viagra for energy and immunity.',
        'price' => 5000.00,
        'image' => '../ourProductsImages/yarsagumba.jpg',
        'category' => 'Premium',
        'disease_tags' => 'immunity, vitality, respiratory',
        'ingredients' => 'Ophiocordyceps sinensis'
    ],
    [
        'name' => 'Sarpagandha Tablets',
        'description' => 'Best for managing high blood pressure and anxiety.',
        'price' => 380.00,
        'image' => '../ourProductsImages/sarpaganda.jpg',
        'category' => 'Tablets',
        'disease_tags' => 'hypertension, anxiety, sleep',
        'ingredients' => 'Rauwolfia serpentina'
    ],
    [
        'name' => 'Shatavari Powder',
        'description' => 'Hormonal balance and female health support.',
        'price' => 560.00,
        'image' => '../ourProductsImages/satabari.png',
        'category' => 'Herbal Powder',
        'disease_tags' => 'hormones, female health, lactation',
        'ingredients' => 'Asparagus racemosus'
    ],
    [
        'name' => 'Sesame Hair Oil',
        'description' => 'Nourishing oil for strong and shiny hair.',
        'price' => 220.00,
        'image' => '../ourProductsImages/sesame oil.png',
        'category' => 'Oil',
        'disease_tags' => 'hair fall, dandruff, scalp health',
        'ingredients' => 'Sesamum indicum'
    ],
    [
        'name' => 'Amala Candy',
        'description' => 'Sweet and sour vitamin C boost.',
        'price' => 150.00,
        'image' => '../PlantsImages/amala.jpg',
        'category' => 'Confectionary',
        'disease_tags' => 'immunity, digestion, vitamin C',
        'ingredients' => 'Phyllanthus emblica'
    ],
    [
        'name' => 'Tulsi Holy Basil Drops',
        'description' => 'Concentrated tulsi for respiratory health.',
        'price' => 180.00,
        'image' => '../PlantsImages/tulsi.webp',
        'category' => 'Drops',
        'disease_tags' => 'cough, cold, immunity',
        'ingredients' => 'Ocimum tenuiflorum'
    ]
];

// Clean existing products to avoid duplicates during this "reset/repop" if needed, 
// but user said "add", so I'll just check if they exist by name.

foreach ($products as $p) {
    $name = mysqli_real_escape_string($conn, $p['name']);
    $desc = mysqli_real_escape_string($conn, $p['description']);
    $price = $p['price'];
    $img = mysqli_real_escape_string($conn, $p['image']);
    $cat = mysqli_real_escape_string($conn, $p['category']);
    $tags = mysqli_real_escape_string($conn, $p['disease_tags']);
    $ing = mysqli_real_escape_string($conn, $p['ingredients']);

    $check = mysqli_query($conn, "SELECT id FROM products WHERE name='$name'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO products (name, description, price, image, category, disease_tags, ingredients, rating, created_at) 
                VALUES ('$name', '$desc', $price, '$img', '$cat', '$tags', '$ing', 4.5, NOW())";
        mysqli_query($conn, $sql);
        echo "Added: $name\n";
    } else {
        // Update existing ones to have correct images
        mysqli_query($conn, "UPDATE products SET image='$img', price=$price WHERE name='$name'");
        echo "Updated: $name\n";
    }
}

echo "Seeding complete.\n";
?>
