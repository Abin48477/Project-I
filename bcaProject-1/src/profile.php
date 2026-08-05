<?php
// We start by opening our secret "Pipe" to the treasure box (database)!
include 'connection.php';
// We also tell the computer to remember who we are today (session start)!
session_start();

// If you are not logged in, we send you back to the "Welcome Gate" (login page)!
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

// We look into our treasure box to find everything about you!
// We try to get data from both the "users" table and the "profiles" table.
// We also grab your latest Dosha percentages from the "dosha_results" table!
$user_sql = "SELECT u.*, 
             p.bmi, p.whtr, p.health_score, p.full_name as profile_full_name, p.age as profile_age, p.height as profile_height, p.weight as profile_weight, p.waist as profile_waist,
             dr.vata_percentage, dr.pitta_percentage, dr.kapha_percentage
             FROM users u 
             LEFT JOIN profiles p ON u.id = p.user_id 
             LEFT JOIN (
                SELECT * FROM dosha_results WHERE id IN (SELECT MAX(id) FROM dosha_results GROUP BY user_id)
             ) dr ON u.id = dr.user_id
             WHERE u.username = '$username'";
$user_res = mysqli_query($conn, $user_sql);
$user_data = mysqli_fetch_assoc($user_res);

// Some basic math for our "Health Meter"!
$display_name = $user_data['profile_full_name'] ?: $user_data['username'];
$display_age = $user_data['profile_age'] ?: '--';
$display_height = $user_data['profile_height'] ?: '--';
$display_weight = $user_data['profile_weight'] ?: '--';
$display_dosha = $user_data['dosha'] ?: 'Unknown';
$health_score = $user_data['health_score'] ?: 79; // Default as requested
$bmi = $user_data['bmi'] ?: '--';
$whtr = $user_data['whtr'] ?: '--';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Health Profile - Ayurvedic Portal</title>
    <!-- We pick some pretty handwriting styles! -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=2.1">
    <style>
        :root {
            --primary-green: #2d6a4f;
            --light-green: #d8f3dc;
            --accent-green: #95d5b2;
            --dark-green: #1b4332;
        }

        body {
            background-color: #f8faf9;
            font-family: 'Poppins', sans-serif;
        }

        .profile-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        /* The big white card where all your health secrets live! */
        .profile-card {
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.05);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.03);
        }

        /* The Tab Menu (The 6 Doors!) */
        .profile-tabs {
            display: flex;
            background: #f1f8f4;
            padding: 10px;
            gap: 10px;
            overflow-x: auto;
            border-bottom: 2px solid var(--light-green);
        }

        .tab-btn {
            padding: 12px 25px;
            border: none;
            background: none;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            border-radius: 15px;
            transition: all 0.3s;
            white-space: nowrap;
            font-size: 0.95rem;
        }

        .tab-btn.active {
            background: var(--primary-green);
            color: white;
            box-shadow: 0 5px 15px rgba(45, 106, 79, 0.2);
        }

        .tab-content {
            display: none;
            padding: 40px;
            animation: fadeIn 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- MENU 1: OVERVIEW --- */
        .overview-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 30px;
            align-items: center;
        }

        .profile-photo-sec {
            text-align: center;
        }

        .photo-circle {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: #eee;
            margin: 0 auto 20px;
            border: 5px solid var(--light-green);
            overflow: hidden;
            position: relative;
        }

        .photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-btn {
            background: var(--primary-green);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .details-sec h2 {
            font-family: 'Playfair Display', serif;
            color: var(--dark-green);
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 12px;
            font-size: 1.1rem;
            color: #444;
        }

        .detail-item strong {
            color: var(--primary-green);
            width: 100px;
            display: inline-block;
        }

        /* Health Meter Circular Dashboard */
        .health-meter-sec {
            text-align: center;
        }

        .meter-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        .circular-progress {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(var(--primary-green) <?php echo $health_score * 3.6; ?>deg, #ededed 0deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circular-progress::before {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background-color: white;
        }

        .meter-value {
            position: relative;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-green);
            z-index: 2;
        }

        .meter-label {
            position: relative;
            font-size: 0.9rem;
            font-weight: 600;
            color: #888;
            margin-top: -5px;
        }

        .summary-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .stat-box {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-green);
        }

        .stat-label {
            font-size: 0.8rem;
            color: #888;
            text-transform: uppercase;
        }

        /* --- MENU 2 & 3: DIET & YOGA --- */
        .routine-card {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: 0.3s;
        }

        .routine-card:hover {
            border-color: var(--accent-green);
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
            transform: translateX(5px);
        }

        .routine-time {
            background: var(--light-green);
            color: var(--dark-green);
            padding: 10px 15px;
            border-radius: 12px;
            font-weight: 700;
            min-width: 90px;
            text-align: center;
        }

        .routine-info h4 {
            margin: 0;
            color: var(--primary-green);
        }

        .routine-info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 0.9rem;
        }

        .dosha-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .badge-vata { background: #e3f2fd; color: #1565c0; }
        .badge-pitta { background: #fff3e0; color: #e65100; }
        .badge-kapha { background: #f1f8e9; color: #33691e; }

        /* --- MENU 4: MEDICINE GRID --- */
        .medicine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .med-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .med-card:hover { border-color: var(--primary-green); }

        .med-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        /* --- MODAL FOR MEDICINE --- */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 25px;
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px; right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* --- MENU 6: SAVE LOGIC --- */
        .save-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 10px;
        }

        .save-btn {
            background: var(--dark-green);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- REUSED NAVBAR -->
    <div class="header" id="home">
        <div class="logo">
            <a href="HomePage.php" class="logo-link">
                <dotlottie-wc src="https://lottie.host/187983ba-42e5-4a30-8b7f-8859d8b84932/7CtK2QviJK.lottie" style="height: 60px; width: auto;" autoplay loop></dotlottie-wc>
            </a>
        </div>
        <nav>
            <a href="HomePage.php">Home</a>
            <a href="dosha-quiz.php">Quiz</a>
            <a href="../PlantsImages/products.php">Products</a>
            <a href="cart.php">🛒 Cart</a>
            <a href="profile.php" class="active">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <!-- The 6 Doors (Tabs) -->
            <div class="profile-tabs">
                <button class="tab-btn active" onclick="showTab(1)">🏠 Overview</button>
                <button class="tab-btn" onclick="showTab(2)">🥗 Diet Plan</button>
                <button class="tab-btn" onclick="showTab(3)">🧘 Yoga & Tips</button>
                <button class="tab-btn" onclick="showTab(4)">🌿 Medicines</button>
                <button class="tab-btn" onclick="showTab(5)">🖼️ Gallery</button>
                <button class="tab-btn" onclick="showTab(6)">⚙️ Settings & Pro Tips</button>
            </div>

            <!-- MENU 1: OVERVIEW -->
            <div id="tab1" class="tab-content active">
                <div class="overview-grid">
                    <div class="profile-photo-sec">
                        <div class="photo-circle">
                            <img src="<?php echo $user_data['profile_image'] ?: 'https://via.placeholder.com/180'; ?>" alt="Profile">
                        </div>
                        <label class="upload-btn">Upload Photo</label>
                    </div>
                    <div class="details-sec">
                        <h2><?php echo $display_name; ?></h2>
                        <div class="detail-item"><strong>Age:</strong> <?php echo $display_age; ?> years</div>
                        <div class="detail-item"><strong>Gender:</strong> <?php echo $user_data['gender'] ?: '--'; ?></div>
                        <div class="detail-item"><strong>Height:</strong> <?php echo $display_height; ?> cm</div>
                        <div class="detail-item"><strong>Weight:</strong> <?php echo $display_weight; ?> kg</div>
                        <div class="detail-item"><strong>Dosha:</strong> 
                            <span class="dosha-badge badge-<?php echo strtolower($display_dosha); ?>">
                                <?php echo $display_dosha; ?>
                            </span>
                        </div>
                        <?php if ($user_data['vata_percentage']): ?>
                        <div class="detail-item" style="font-size: 0.9rem; color: #777;">
                            💨 Vata: <?php echo round($user_data['vata_percentage']); ?>% | 
                            🔥 Pitta: <?php echo round($user_data['pitta_percentage']); ?>% | 
                            🌊 Kapha: <?php echo round($user_data['kapha_percentage']); ?>%
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="health-meter-sec">
                        <div class="meter-container">
                            <div class="circular-progress">
                                <div class="meter-value"><?php echo $health_score; ?></div>
                            </div>
                        </div>
                        <div class="meter-label">HEALTH SCORE</div>
                    </div>
                </div>

                <div class="summary-stats">
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $bmi; ?></div>
                        <div class="stat-label">BMI</div>
                    </div>
                    <div class="stat-box" style="border-left: 1px solid #eee; border-right: 1px solid #eee; padding: 0 40px;">
                        <div class="stat-value"><?php echo $whtr; ?></div>
                        <div class="stat-label">WHTR</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo $display_dosha; ?></div>
                        <div class="stat-label">Your Nature</div>
                    </div>
                </div>
            </div>

            <!-- MENU 2: DIET PLAN -->
            <div id="tab2" class="tab-content">
                <h3 style="color: var(--dark-green); margin-bottom: 25px;">Personalized <?php echo $display_dosha; ?> Diet</h3>
                <div class="routine-list">
                    <!-- This list changes based on what "Badge" (Dosha) you wear! -->
                    <?php
                    $diet = [
                        'Vata' => [
                            ['7 AM', 'Warm Almond Milk', 'A warm hug for your tummy!'],
                            ['9 AM', 'Dense Fruits with Nuts', 'Heavy and sweet toys for your energy!'],
                            ['1 PM', 'Grain + Legume Meal', 'Strong food for a strong body!'],
                            ['4 PM', 'Homemade Laddoos', 'A sweet little treat!'],
                            ['7 PM', 'Warm Vegetable Soup', 'Easy to sleep and happy tummy!']
                        ],
                        'Pitta' => [
                            ['7 AM', 'Aloe Vera Juice', 'Cools down your internal fire!'],
                            ['9 AM', 'Sweet Fruits & Oats', 'Sweet and calm start!'],
                            ['1 PM', 'Leafy Greens & Rice', 'Cooling colors for your plate!'],
                            ['4 PM', 'Coconut Water', 'Refresh like a beach!'],
                            ['7 PM', 'Mild Daliya', 'Light and sweet rest!']
                        ],
                        'Kapha' => [
                            ['7 AM', 'Warm Honey Water', 'Wakes up your body engine!'],
                            ['9 AM', 'Spicy Stewed Apple', 'Light and warm fire!'],
                            ['1 PM', 'Barley & Spices', 'Dry and light to keep you fast!'],
                            ['4 PM', 'Ginger Tea', 'A spicy kick!'],
                            ['7 PM', 'Mixed Veggie Stir-fry', 'Simple and light!']
                        ],
                        'Unknown' => [['--', 'Take the Quiz!', 'Find your special plan!']]
                    ];
                    $current_diet = $diet[$display_dosha] ?? $diet['Unknown'];
                    foreach($current_diet as $item): ?>
                        <div class="routine-card">
                            <div class="routine-time"><?php echo $item[0]; ?></div>
                            <div class="routine-info">
                                <h4><?php echo $item[1]; ?></h4>
                                <p><?php echo $item[2]; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- MENU 3: YOGA -->
            <div id="tab3" class="tab-content">
                <h3 style="color: var(--dark-green); margin-bottom: 25px;"><?php echo $display_dosha; ?> Yoga Flow</h3>
                <?php
                $yoga = [
                    'Vata' => 'Vata needs stability! Slow breathing & gentle stretching. Avoid jumping too much!',
                    'Pitta' => 'Pitta needs cooling! Moon salutations and calming meditation. Avoid hot rooms!',
                    'Kapha' => 'Kapha needs movement! Sun salutations and fast, dynamic poses to stay active!'
                ];
                echo "<p style='background: #fdfdfd; padding: 20px; border-radius: 15px; border: 1px dashed var(--accent-green);'>
                        <i class='fas fa-info-circle me-2'></i> " . ($yoga[$display_dosha] ?? "Take the quiz to find your rhythm!") . "</p>";
                ?>
                <div class="routine-list" style="margin-top: 20px;">
                    <div class="routine-card">
                        <div class="routine-time">Early</div>
                        <div class="routine-info">
                            <h4>Surya Namaskar</h4>
                            <p>Say hello to the sun and wake up your magic muscles!</p>
                        </div>
                    </div>
                    <div class="routine-card">
                        <div class="routine-time">Mid</div>
                        <div class="routine-info">
                            <h4>Nadi Shodhana</h4>
                            <p>Clear your nose-pipes for happy breathing!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MENU 4: MEDICINES -->
            <div id="tab4" class="tab-content">
                <h3 style="color: var(--dark-green); margin-bottom: 25px;">Recommended Herbal Shop</h3>
                <div class="medicine-grid">
                    <?php
                    $prod_sql = "SELECT * FROM products LIMIT 4";
                    $prod_res = mysqli_query($conn, $prod_sql);
                    while($prod = mysqli_fetch_assoc($prod_res)): ?>
                        <div class="med-card" onclick="openMedModal('<?php echo $prod['name']; ?>', '<?php echo $prod['image']; ?>', '<?php echo $prod['price']; ?>', '<?php echo $prod['id']; ?>')">
                            <img src="<?php echo $prod['image']; ?>" alt="Product">
                            <h5><?php echo $prod['name']; ?></h5>
                            <p>Rs. <?php echo $prod['price']; ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- MENU 5: GALLERY -->
            <div id="tab5" class="tab-content">
                <h3 style="color: var(--dark-green); margin-bottom: 25px;">Health Image Gallery</h3>
                <div class="medicine-grid">
                    <div class="med-card"><img src="../full_imageContainer/talkingdoctor.jpg" style="width:100%; height:150px; object-fit:cover;"></div>
                    <div class="med-card"><img src="../full_imageContainer/testing.jpg" style="width:100%; height:150px; object-fit:cover;"></div>
                    <div class="med-card"><img src="../full_imageContainer/kutki.png" style="width:100%; height:150px; object-fit:cover;"></div>
                    <div class="med-card"><img src="../full_imageContainer/doshaImage.jpg" style="width:100%; height:150px; object-fit:cover;"></div>
                </div>
            </div>

            <!-- MENU 6: SETTINGS & PRO TIPS -->
            <div id="tab6" class="tab-content">
                <div style="background: var(--light-green); padding: 25px; border-radius: 20px; margin-bottom: 40px;">
                    <h4 style="color: var(--dark-green);"><i class="fas fa-lightbulb me-2"></i> Daily Sanskrit Tip</h4>
                    <?php
                    $slokas = [
                        'Vata' => '"वायुरायुः बलं वायुः — Vāta is life and strength."',
                        'Pitta' => '"पित्तं तु अग्निस्वरूपम् — Pitta is the biological fire of the body."',
                        'Kapha' => '"श्लेष्मा हि बलं — Kapha is the source of strength and stability."',
                        'Default' => '"स्वस्थस्य स्वास्थ्य रक्षणं — Ayurveda is the guardian of the healthy person\'s health."'
                    ];
                    $current_sloka = $slokas[$display_dosha] ?? $slokas['Default'];
                    ?>
                    <p id="sloka-text" style="font-style: italic; margin-top: 10px;"><?php echo $current_sloka; ?></p>
                    <small>Source: Classical Ayurvedic Texts (Bṛhat-trayī)</small>
                </div>

                <div class="save-form">
                    <h3 style="color: var(--dark-green); margin-bottom: 20px;">Update My Health Secret Book</h3>
                    <form action="save_profile_action.php" method="POST">
                        <div class="form-row" style="display:flex; gap:15px;">
                            <div class="form-group" style="flex:1;">
                                <label>Full Name</label>
                                <input type="text" name="full_name" value="<?php echo $display_name; ?>">
                            </div>
                            <div class="form-group" style="flex:1;">
                                <label>Age</label>
                                <input type="number" name="age" value="<?php echo $display_age; ?>">
                            </div>
                        </div>
                        <div class="form-row" style="display:flex; gap:15px;">
                            <div class="form-group" style="flex:1;">
                                <label>Height (cm)</label>
                                <input type="number" name="height" id="h_input" value="<?php echo $display_height; ?>">
                            </div>
                            <div class="form-group" style="flex:1;">
                                <label>Weight (kg)</label>
                                <input type="number" name="weight" id="w_input" value="<?php echo $display_weight; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Waist (cm)</label>
                            <input type="number" name="waist" id="waist_input" value="<?php echo $user_data['profile_waist']; ?>">
                        </div>
                        <button type="submit" class="save-btn">💾 Save My Health Map</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Medicine Popup Modal -->
    <div id="medModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeMedModal()">&times;</span>
            <div style="text-align: center;">
                <img id="modal-img" src="" style="width: 200px; border-radius: 15px; margin-bottom: 20px;">
                <h2 id="modal-name" style="font-family:'Playfair Display'; color:var(--dark-green);"></h2>
                <p id="modal-price" style="font-size: 1.5rem; color:var(--primary-green); font-weight:700;"></p>
                <div style="margin-top: 25px;">
                    <a id="modal-buy-btn" href="" class="btn-payment-method" style="background:var(--primary-green); color:white; padding:12px 25px; border-radius:50px; text-decoration:none; display:inline-block; font-weight:700;">
                        Add to Cart <i class="fas fa-shopping-cart ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- This is the "Bottom of the House" (Footer) where we say goodbye and keep our copyright badge! -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section about">
                <h3>Ayurvedic Health Portal</h3>
                <p>Bringing you the wisdom of Ayurveda for a healthier life. Experience nature's touch with our premium
                    products.</p>
            </div>
            <div class="footer-section links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="dosha-quiz.php">Dosha Quiz</a></li>
                    <li><a href="HomePage.php#remedy">Remedy Finder</a></li>
                    <li><a href="../PlantsImages/products.php">Products</a></li>
                    <li><a href="HomePage.php#contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h3>Contact Info</h3>
                <p>📧 support@ayurveda.com</p>
                <p>📞 +977-9876543210</p>
                <p>📍 Kathmandu, Nepal</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 Ayurvedic Health Portal | Designed with ❤️
        </div>
    </footer>

    <script>
        // Magic Trick to change rooms!
        function showTab(n) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab' + n).classList.add('active');
            document.getElementsByClassName('tab-btn')[n-1].classList.add('active');
        }

        // Magic Box for Medicines!
        function openMedModal(name, img, price, id) {
            document.getElementById('modal-name').innerText = name;
            document.getElementById('modal-img').src = img;
            document.getElementById('modal-price').innerText = 'Rs. ' + price;
            document.getElementById('modal-buy-btn').href = 'add_to_cart.php?id=' + id;
            document.getElementById('medModal').style.display = 'flex';
        }

        function closeMedModal() {
            document.getElementById('medModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('medModal')) {
                closeMedModal();
            }
        }
    </script>
</body>
</html>
