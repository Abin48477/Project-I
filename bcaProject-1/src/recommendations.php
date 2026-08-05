<?php
// We open the secret pipe to the treasure box!
include 'connection.php';
// We tell the computer to remember who we are!
session_start();

// This part looks at which "Team" you are in (Vata, Pitta, or Kapha)!
$dosha = isset($_GET['dosha']) ? strtolower($_GET['dosha']) : '';

// If we don't know your team, we check your secret badge in the treasure box!
if (empty($dosha) && isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $res = mysqli_query($conn, "SELECT dosha FROM users WHERE username='$username'");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        // We find the dosha you had before!
        $dosha = strtolower($row['dosha']);
    }
}

if (!in_array($dosha, ['vata', 'pitta', 'kapha'])) {
    // If you don't have a team yet, let's go play the quiz game!
    header("Location: HomePage.php?msg=Please take the quiz first");
    exit();
}

// This is our big "Expert Advice Book" where we keep magic tips for everyone!
$content = [
    'vata' => [
        'name' => 'Vata',
        // Description of the "Vata" energy
        'desc' => 'Vata is characterized by the elements of Air and Space. It governs movement, circulation, and the nervous system.',
        'products' => [
            ['name' => 'Ashwagandha Powder', 'reason' => 'Grounding and calming for the nervous system.'],
            ['name' => 'Patanjali Honey', 'reason' => 'Warming and nourishing for dry Vata nature.'],
            ['name' => 'Patanjali Saundarya Aloe Vera Gel', 'reason' => 'Hydrating to combat VATA dryness.']
        ],
        'diet' => [
            'eat' => 'Warm, cooked, and oily foods. Focus on sweet, sour, and salty tastes.',
            'amount' => 'Regular small meals to maintain steady energy levels.',
            'when' => 'Eat at regular intervals, avoiding fasting or skipping meals.',
            'herbs' => 'Ginger, cinnamon, and Tulsi tea with honey.'
        ],
        'lifestyle' => [
            'exercise' => 'Gentle activities like Yoga, Tai Chi, or walking.',
            'climate' => 'Stay warm and avoid cold, windy environments.',
            'routine' => 'Establish a strict daily routine with early bedtime.'
        ],
        'knowledge' => [
            'quote' => 'तत्र रूक्षः लघुः शीतः खरः सूक्ष्मः चलः अनिलः।',
            'translation' => 'Vata is dry, light, cold, rough, subtle, and mobile.'
        ]
    ],
    'pitta' => [
        'name' => 'Pitta',
        'desc' => 'Pitta is governed by Fire and Water. It controls metabolism, digestion, and heat in the body.',
        'products' => [
            ['name' => 'Patanjali Saundarya Shower Gel', 'reason' => 'Cooling and soothing for the skin.'],
            ['name' => 'Amla Capsules', 'reason' => 'Potent antioxidant to manage Pitta heat.'],
            ['name' => 'Aloe Vera Juice', 'reason' => 'Soothes the digestive fire.']
        ],
        'diet' => [
            'eat' => 'Cooling, hydrating foods like cucumbers, melons, and leafy greens. Tastes: sweet, bitter, astringent.',
            'amount' => 'Moderate portions; do not overeat despite strong hunger.',
            'when' => 'Eat the largest meal at noon when digestive fire is highest.',
            'herbs' => 'Coriander, mint, and fennel.'
        ],
        'lifestyle' => [
            'exercise' => 'Moderate intensity, preferably in the cooler parts of the day.',
            'climate' => 'Cool, well-ventilated spaces are best.',
            'routine' => 'Balance work with leisure; avoid excessive competition.'
        ],
        'knowledge' => [
            'quote' => 'पित्तं सस्नेह तीक्ष्ण उष्णं लघु विस्त्रं सरं द्रवम्।',
            'translation' => 'Pitta is slightly oily, sharp, hot, light, fleshy-smelling, spreading, and liquid.'
        ]
    ],
    'kapha' => [
        'name' => 'Kapha',
        'desc' => 'Kapha is rooted in Earth and Water. it provides structure, stability, and lubrication to the body.',
        'products' => [
            ['name' => 'Kesh Kanti Hair Cleaner', 'reason' => 'Stimulating and cleansing for Kapha oiliness.'],
            ['name' => 'Tulsi Capsules', 'reason' => 'Clears congestion and boosts metabolism.'],
            ['name' => 'Triphala Powder', 'reason' => 'Aids internal cleansing and weight management.']
        ],
        'diet' => [
            'eat' => 'Warm, light, and dry foods. Focus on pungent, bitter, and astringent tastes.',
            'amount' => 'Smaller portions; avoid heavy desserts and fried foods.',
            'when' => 'Light breakfast or skip it if not hungry. Avoid late-night meals.',
            'herbs' => 'Black pepper, ginger, and garlic.'
        ],
        'lifestyle' => [
            'exercise' => 'Vigorous exercise like running, cycling, or intense yoga.',
            'climate' => 'Warm, dry environment is ideal.',
            'routine' => 'Seek novelty and variety; avoid sleeping during the day.'
        ],
        'knowledge' => [
            'quote' => 'गुरु शीत मृदु स्निग्ध मधुर स्थिर पिच्छिलाः श्लेष्मणः।',
            'translation' => 'Kapha is heavy, cold, soft, oily, sweet, stable, and slimy.'
        ]
    ]
];

$dData = $content[$dosha];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dData['name']; ?> Recommendations - Ayurvedic Health Portal</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #2d6a4f;
            --secondary: #40916c;
            --accent: #b7e4c7;
            --bg: #f8f9fa;
            --white: #ffffff;
            --text: #1b4332;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            line-height: 1.6;
        }

        .hero {
            height: 60vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../full_imageContainer/doshaImage.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            animation: fadeIn 1s ease-out;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .container {
            max-width: 1200px;
            margin: -100px auto 50px;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .info-box {
            background: var(--white);
            padding: 30px;
            border-radius: 20px;
            border-left: 5px solid var(--secondary);
            transition: transform 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
        }

        .product-list {
            list-style: none;
        }

        .product-list li {
            padding: 15px 0;
            border-bottom: 1px dashed var(--accent);
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .product-list li strong {
            color: var(--primary);
            min-width: 150px;
        }

        .sanskrit-verse {
            background: #f0fdf4;
            padding: 40px;
            border-radius: 30px;
            text-align: center;
            margin-top: 50px;
        }

        .sanskrit-verse .verse {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--secondary);
            margin-bottom: 15px;
            font-style: italic;
        }

        .sanskrit-verse .translation {
            font-size: 1.1rem;
            color: #666;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 40px;
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: var(--secondary);
            box-shadow: 0 10px 20px rgba(45, 106, 79, 0.3);
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .container {
                margin-top: -50px;
            }

            .glass-card {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

    <section class="hero">
        <div>
            <h1><?php echo $dData['name']; ?> Balance</h1>
            <p><?php echo $dData['desc']; ?></p>
        </div>
    </section>

    <div class="container">
        <!-- These are the "Magic Potions" we recommend for you! -->
        <div class="glass-card">
            <h2>🌿 Recommended Products</h2>
            <ul class="product-list">
                <?php foreach ($dData['products'] as $p): ?>
                    <li>
                        <!-- The name of the special potion! -->
                        <strong><?php echo $p['name']; ?></strong>
                        <!-- Why it is good for you! -->
                        <span><?php echo $p['reason']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="grid">
            <div class="glass-card">
                <h2>🥗 Diet Guidance</h2>
                <div class="info-box" style="margin-bottom: 20px;">
                    <!-- What kind of yummy food should you eat? -->
                    <strong>What to Eat:</strong>
                    <p><?php echo $dData['diet']['eat']; ?></p>
                </div>
                <div class="info-box" style="margin-bottom: 20px;">
                    <!-- When is the best time for your tummy to eat? -->
                    <strong>When to Eat:</strong>
                    <p><?php echo $dData['diet']['when']; ?></p>
                </div>
                <div class="info-box">
                    <!-- Special magic herbs that help your body! -->
                    <strong>Recommended Herbs:</strong>
                    <p><?php echo $dData['diet']['herbs']; ?></p>
                </div>
            </div>

            <div class="glass-card">
                <h2>🧘 Lifestyle Balance</h2>
                <div class="info-box" style="margin-bottom: 20px;">
                    <!-- How should you move your body? -->
                    <strong>Exercise:</strong>
                    <p><?php echo $dData['lifestyle']['exercise']; ?></p>
                </div>
                <div class="info-box" style="margin-bottom: 20px;">
                    <!-- Where is the best place for you to be? -->
                    <strong>Environment:</strong>
                    <p><?php echo $dData['lifestyle']['climate']; ?></p>
                </div>
                <div class="info-box">
                    <!-- What should you do every single day? -->
                    <strong>Daily Routine:</strong>
                    <p><?php echo $dData['lifestyle']['routine']; ?></p>
                </div>
            </div>
        </div>

        <div class="sanskrit-verse">
            <!-- This is a secret message from a very old and wise book! -->
            <h2>📚 Wise Words</h2>
            <div class="verse"><?php echo $dData['knowledge']['quote']; ?></div>
            <!-- This is what the wise book says in our language! -->
            <div class="translation"><?php echo $dData['knowledge']['translation']; ?></div>
        </div>

        <div style="text-align: center;">
            <a href="HomePage.php" class="back-btn">Return to Home</a>
        </div>
    </div>

</body>

</html>