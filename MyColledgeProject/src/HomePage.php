<?php
// We start by opening our secret "Pipe" to the treasure box (database)!
include 'connection.php';
// We also tell the computer to remember who we are today (session start)!
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayurvedic Health Portal</title>
    <!-- We pick some pretty handwriting styles from the internet library! -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- We put on our "Magic Crayon Box" (style.css) and "Magic Wand" (script.js)! -->
    <link rel="stylesheet" href="style.css?v=2.0">
    <script src="script.js?v=2.0" defer></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.3/dist/dotlottie-wc.js" type="module"></script>

    <script>
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
    </script>
</head>

<body>
    <!-- This is the "Magic Hat" (header) that stays at the top! -->
    <div id="home" class="header">
        <div class="logo">
            <a href="HomePage.php" class="logo-link" style="display: flex; align-items: center;">
                <!-- Our new animated logo! -->
                <dotlottie-wc src="https://lottie.host/187983ba-42e5-4a30-8b7f-8859d8b84932/7CtK2QviJK.lottie" style="height: 75px; width: auto; filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.18));" autoplay loop></dotlottie-wc>
            </a>
        </div>
        <nav>
            <!-- These are our "Magic Doors" (links) to different rooms! -->
            <a href="HomePage.php#home" data-i18n="navHome">Home</a>
            <a href="dosha-quiz.php" data-i18n="navQuiz">Dosha Quiz</a>
            <a href="HomePage.php#remedy" data-i18n="navRemedy">Remedy Finder</a>
            <a href="../PlantsImages/products.php" data-i18n="navProducts">Products</a>

            <a href="HomePage.php#contact" data-i18n="navContact">Contact</a>

            <!-- This is our "Shopping Bag" door! -->
            <a href="cart.php" class="cart-link">
                <span data-i18n="navCart">🛒 Cart</span>
                <span id="cart-count">
                    <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                </span>
            </a>

            <?php if (isset($_SESSION['user'])): ?>

                <?php
                // If you are logged in, the computer looks into the treasure box to find your name and your prizes!
                $username = $_SESSION['user'];
                $user_res = mysqli_query($conn, "SELECT role, points, streak_count, dosha FROM users WHERE username='$username'");

                if ($user_res) {
                    $user_data = mysqli_fetch_assoc($user_res);
                } else {
                    // Oops, if we can't find it, we just say you're a regular friend (user)!
                    $fallback_res = mysqli_query($conn, "SELECT role FROM users WHERE username='$username'");
                    $user_data = ($fallback_res) ? mysqli_fetch_assoc($fallback_res) : ['role' => 'user'];
                }

                // Safe extraction
                $user_role = strtolower(trim($user_data['role'] ?? 'user'));
                $db_dosha = $user_data['dosha'] ?? '';

                // We put a secret team badge (Dosha) in your pocket!
                if ($db_dosha) {
                    echo "<script>localStorage.setItem('userDosha', '$db_dosha');</script>";
                }

                // If you're the "Boss" (Admin), you get a special key to the control room!
                if ($user_role === 'admin' && strtolower($username) !== 'abin'): ?>
                    <a href="../crud_operations/index.php">Admin Panel</a>
                <?php endif; ?>
                <a href="profile.php" data-i18n="navProfile">Profile</a>
                <a href="logout.php" data-i18n="navLogout">Logout (
                    <?php echo $_SESSION['user']; ?>)
                </a>
            <?php else: ?>
                <!-- If you're new, we show the "Join Us" doors (Login/Register)! -->
                <a href="login.php" data-i18n="navLogin">Login</a>
                <a href="register.php" data-i18n="navRegister">Register</a>
            <?php endif; ?>

        </nav>
    </div>
    <!-- These are the big giant pictures that change like a movie! (Hero Carousel) -->
    <div class="hero-carousel">
        <div class="hero-slide active">
            <img src="../full_imageContainer/talkingdoctor.jpg" alt="talkingdoctor">
        </div>
        <div class="hero-slide">
            <img src="../full_imageContainer/testing.jpg" alt="testing">
        </div>
        <div class="hero-slide">
            <img src="../full_imageContainer/kutki.png" alt="beautiful_doctor">
        </div>
        <div class="hero-slide">
            <img src="../full_imageContainer/image.png" alt="image_1">
        </div>
        <div class="hero-slide">
            <img src="../full_imageContainer/doshaImage.jpg" alt="doshaImage">
        </div>
    </div>

    <!-- This part brings in pictures of pretty plants! -->
    <div class="plantsImages">
        <?php
        include 'plantsImages.php';
        ?>
    </div>
    <!-- This part shows our "Watch & Buy" movie section! -->
    <div>
        <?php
        include 'Watch&buy.php';
        ?>
    </div>
    <!-- products sections -->
    <!-- This is a secret message that pops up to tell you how to feel better based on your team (Dosha)! -->
    <div id="dosha-popup" class="dosha-toast shadow-lg" style="display:none;">
        <div class="toast-header-custom">
            <span class="icon">🌿</span>
            <span class="title">Personalized Recommendation</span>
            <button class="close-toast" onclick="closeDoshaPopup()">&times;</button>
        </div>
        <div class="toast-body">
            <p id="user-dosha-msg">Your <strong><span id="popup-dosha-name"></span></strong> nature imbalance is
                detected.</p>
            <p id="user-dosha-advice" class="advice-text"></p>
            <div id="popup-products-grid" class="mini-products-grid">
                <!-- Our magic toys (products) appear here! -->
            </div>
            <a href="recommendations.php" id="popup-learn-more" class="btn-more">Learn More</a>
        </div>
    </div>

    <!-- This part brings in our beautiful "Shopping Shelf" (product carousel)! -->
    <div id="products" class="ourProducts">
        <?php
        include 'productCarousel.php';
        ?>
    </div>

    <!-- Old quiz removed -->
    <!-- <div class="advertisment">
        <img src="advertisment.png" alt="advertisment">
    </div> -->

    <!-- This is our "Magic Help Book" (Remedy Finder) where you can search for help! -->
    <section id="remedy" class="remedy-section">
        <div class="remedy-container">
            <h2>Find Ayurvedic Remedies</h2>
            <p class="remedy-subtitle">Enter symptom like "cough" or "headache"</p>

            <div class="search-box">
                <!-- This is the box where you type your symptom! -->
                <input type="text" id="symptomInput" placeholder="Type symptom..." />
                <button id="searchBtn" class="search-btn">Search</button>
            </div>

            <!-- This is the secret result paper that shows the answer! -->
            <div id="result_Box" class="result-box" style="display:none;">
                <p id="result_Text"></p>
            </div>
        </div>
    </section>

    <!-- This is our "Greeting Box" (Contact) where you can send us a letter! -->
    <section id="contact" class="contact-section">
        <div class="contact-container shadow-lg">
            <div class="contact-header text-center">
                <h2 data-i18n="contactTitle">Get in Touch</h2>
                <p data-i18n="contactSubtitle">Have questions? We'd love to hear from you!</p>
            </div>
            <form id="contactForm" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <!-- Tell us your name! -->
                        <label for="name" data-i18n="labelName">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Your Name" data-i18n="placeholderName"
                            required>
                    </div>
                    <div class="form-group">
                        <!-- Tell us your secret mail address so we can write back! -->
                        <label for="email" data-i18n="labelEmail">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Your Email"
                            data-i18n="placeholderEmail" required>
                    </div>
                </div>
                <div class="form-group">
                    <!-- What is your letter about? -->
                    <label for="subject" data-i18n="labelSubject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="What is this about?"
                        data-i18n="placeholderSubject" required>
                </div>
                <div class="form-group">
                    <!-- Write all your happy thoughts here! -->
                    <label for="message" data-i18n="labelMessage">Your Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="How can we help?"
                        data-i18n="placeholderMessage" required></textarea>
                </div>
                <!-- Press this button to fly your letter to us! -->
                <button type="submit" class="submit-contact-btn" data-i18n="btnSendMessage">Send Message</button>
            </form>
            <div id="contactSuccess" class="alert alert-success mt-3" style="display:none;"
                data-i18n="contactSuccessMsg">
                ✅ Your message has been sent successfully! We'll get back to you soon.
            </div>
        </div>
    </section>

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

</body>

</html>

