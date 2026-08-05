<?php
// We open the secret pipe to the treasure box!
include 'connection.php';
// We tell the computer to remember us today!
session_start();

// If you are not logged in, we send you back to the "Welcome Gate" (login page)!
if (!isset($_SESSION['user'])) {
    header("Location: login.php?message=Please log in to discover your Dosha!");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayurvedic Health Portal | Dosha Quiz</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=2.0">
    <script src="script.js?v=2.0" defer></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.3/dist/dotlottie-wc.js" type="module"></script>

    <script>
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
    </script>
    <link rel='stylesheet' href='../doshaQuiz/style.css?v=5.0' />
    <link rel="stylesheet" href="../doshaQuiz/results.css?v=1.0">
</head>

<body>
    <!-- header section -->
    <div id="home" class="header">
        <div class="logo">
            <a href="HomePage.php" class="logo-link" style="display: flex; align-items: center;">
                <!-- Our new animated logo! -->
                <dotlottie-wc src="https://lottie.host/187983ba-42e5-4a30-8b7f-8859d8b84932/7CtK2QviJK.lottie" style="height: 65px; width: auto; filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.18));" autoplay loop></dotlottie-wc>
            </a>
        </div>
        <nav>

            <a href="HomePage.php#home" data-i18n="navHome">Home</a>
            <a href="dosha-quiz.php" data-i18n="navQuiz">Dosha Quiz</a>
            <a href="HomePage.php#remedy" data-i18n="navRemedy">Remedy Finder</a>
            <a href="../PlantsImages/products.php" data-i18n="navProducts">Products</a>

            <a href="HomePage.php#contact" data-i18n="navContact">Contact</a>

            <a href="cart.php" class="cart-link">
                <span data-i18n="navCart">🛒 Cart</span>
                <span id="cart-count">
                    <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                </span>
            </a>

            <?php if (isset($_SESSION['user'])): ?>

                <?php
                // We ask the computer for your nickname and your prize points!
                $username = $_SESSION['user'];
                $user_res = mysqli_query($conn, "SELECT role, points, streak_count, dosha FROM users WHERE username='$username'");

                if ($user_res) {
                    $user_data = mysqli_fetch_assoc($user_res);
                } else {
                    // Oops, if we can't find everything, we just check if you are a "Boss" (admin)!
                    $fallback_res = mysqli_query($conn, "SELECT role FROM users WHERE username='$username'");
                    $user_data = ($fallback_res) ? mysqli_fetch_assoc($fallback_res) : ['role' => 'user'];
                }

                // Safe extraction
                $user_role = strtolower(trim($user_data['role'] ?? 'user'));
                $db_dosha = $user_data['dosha'] ?? '';

                // We put your "Team Sticker" (Dosha) on your forehead!
                if ($db_dosha) {
                    echo "<script>localStorage.setItem('userDosha', '$db_dosha');</script>";
                }

                if ($user_role === 'admin' && strtolower($username) !== 'abin'): ?>
                    <a href="../crud_operations/index.php">Admin Panel</a>
                <?php endif; ?>
                <a href="profile.php" data-i18n="navProfile">Profile</a>
                <a href="logout.php" data-i18n="navLogout">Logout (
                    <?php echo $_SESSION['user']; ?>)
                </a>
            <?php else: ?>
                <a href="login.php" data-i18n="navLogin">Login</a>
                <a href="register.php" data-i18n="navRegister">Register</a>
            <?php endif; ?>

        </nav>
    </div>
    <!-- Background Decoration -->
    <div class="bg-decoration" aria-hidden="true"></div>

    <div id="app">

        <!-- ════════════════════════════════════════
       WELCOME SCREEN
  ════════════════════════════════════════ -->
        <section id="welcome-screen" class="welcome-screen">
            <div class="welcome-card">
                <div class="welcome-mandala">
                    <!-- Spinning mandala SVG -->
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="45" stroke="var(--color-saffron)" stroke-width="0.5" stroke-dasharray="2 2" />
                        <path d="M50 5 L55 35 L85 40 L55 45 L50 75 L45 45 L15 40 L45 35 Z" fill="var(--color-saffron)" opacity="0.3" />
                        <circle cx="50" cy="50" r="10" fill="var(--color-saffron)" opacity="0.5" />
                    </svg>
                </div>
                <p class="welcome-tagline">ANCIENT WISDOM, MODERN ACCURACY</p>
                <h1 class="welcome-title">Discover Your Type</h1>
                <p class="welcome-desc">Unlock a deeper understanding of your body, mind, and spirit through this 15-question traditional Ayurvedic assessment.</p>
                
                <div class="welcome-doshas">
                    <div class="dosha-pill vata"><span>🌬️</span> Vata</div>
                    <div class="dosha-pill pitta"><span>🔥</span> Pitta</div>
                    <div class="dosha-pill kapha"><span>🌿</span> Kapha</div>
                </div>

                <div class="start-actions">
                    <button class="btn-start" onclick="startQuiz()">
                        Begin Journey 
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                    <p class="quiz-info">⏱️ Takes approx. 5 minutes • 15 Questions</p>
                </div>
            </div>
        </section>

        <!-- ════════════════════════════════════════
       QUIZ WRAPPER
  ════════════════════════════════════════ -->
        <main id="quiz-wrapper" class="hidden">
            <!-- Navbar Overlay -->
            <div class="quiz-nav hidden" id="quiz-nav">
                <div class="quiz-nav-content">
                    <div class="brand-info">
                        <div class="brand-dot"></div>
                        <span class="brand-name">Dosha Analysis</span>
                    </div>
                    <div id="question-counter" class="question-counter">Question 1 of 15</div>
                </div>
                <!-- Progress Line -->
                <div class="quiz-progress-track">
                    <div id="progress-fill" class="progress-fill" style="width: 0%"></div>
                </div>
            </div>

            <!-- Slide Container -->
            <div id="slide-container" class="slide-container">
                <!-- Populated by JS -->
            </div>
        </main>

        <!-- ════════════════════════════════════════
       LIVE METER (Sticky Bottom)
  ════════════════════════════════════════ -->
        <footer id="dosha-footer" class="dosha-meter hidden">
            <div class="meter-title">DYNAMICS</div>
            <div class="dosha-bars-wrapper">
                <!-- Vata -->
                <div class="meter-col meter-vata">
                    <div class="meter-header">
                        <span class="meter-label">🌬️ VATA</span>
                        <span id="pct-v" class="meter-pct">0%</span>
                    </div>
                    <div class="meter-track">
                        <div id="meter-bar-v" class="meter-bar" style="width: 0%"></div>
                    </div>
                </div>
                <!-- Pitta -->
                <div class="meter-col meter-pitta">
                    <div class="meter-header">
                        <span class="meter-label">🔥 PITTA</span>
                        <span id="pct-p" class="meter-pct">0%</span>
                    </div>
                    <div class="meter-track">
                        <div id="meter-bar-p" class="meter-bar" style="width: 0%"></div>
                    </div>
                </div>
                <!-- Kapha -->
                <div class="meter-col meter-kapha">
                    <div class="meter-header">
                        <span class="meter-label">🌿 KAPHA</span>
                        <span id="pct-k" class="meter-pct">0%</span>
                    </div>
                    <div class="meter-track">
                        <div id="meter-bar-k" class="meter-bar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- ════════════════════════════════════════
       RESULTS SCREEN
  ════════════════════════════════════════ -->
        <section id="results-screen" class="results-screen hidden">
            <div class="results-container">
                
                <!-- 1. RESULT HEADER -->
                <div class="results-header fade-up">
                    <p class="results-tag">✦ Holistic Health Analysis ✦</p>
                    <h2 class="results-title">Your Results</h2>
                </div>

                <div class="dominant-card fade-up" id="results-dominant-card">
                    <span class="dominant-emoji" id="results-dominant-emoji">🌬️</span>
                    <p class="dominant-sanskrit" id="results-dominant-sanskrit">वात</p>
                    <h3 class="dominant-name" id="results-dominant-name">Vata</h3>
                    <p class="dominant-element" id="results-dominant-element">Air & Space</p>
                    <p class="dominant-desc" id="results-dominant-desc"></p>
                    <div class="dominant-traits" id="results-traits"></div>
                </div>

                <!-- 2. BREAKDOWN (Circular Meters) -->
                <div class="results-breakdown fade-up">
                    <p class="breakdown-title">Dosha Composition</p>
                    <div class="circular-meters">
                        <!-- Vata Meter -->
                        <div class="meter-circle-wrapper">
                            <div class="meter-circle">
                                <svg>
                                    <circle class="circle-bg" cx="75" cy="75" r="70"></circle>
                                    <circle class="circle-fill" id="circle-v" cx="75" cy="75" r="70" style="stroke: var(--color-vata);"></circle>
                                </svg>
                                <span class="circle-text" id="circle-v-pct">0%</span>
                            </div>
                            <span class="meter-circle-label">🌬️ Vata</span>
                        </div>
                        <!-- Pitta Meter -->
                        <div class="meter-circle-wrapper">
                            <div class="meter-circle">
                                <svg>
                                    <circle class="circle-bg" cx="75" cy="75" r="70"></circle>
                                    <circle class="circle-fill" id="circle-p" cx="75" cy="75" r="70" style="stroke: var(--color-pitta);"></circle>
                                </svg>
                                <span class="circle-text" id="circle-p-pct">0%</span>
                            </div>
                            <span class="meter-circle-label">🔥 Pitta</span>
                        </div>
                        <!-- Kapha Meter -->
                        <div class="meter-circle-wrapper">
                            <div class="meter-circle">
                                <svg>
                                    <circle class="circle-bg" cx="75" cy="75" r="70"></circle>
                                    <circle class="circle-fill" id="circle-k" cx="75" cy="75" r="70" style="stroke: var(--color-kapha);"></circle>
                                </svg>
                                <span class="circle-text" id="circle-k-pct">0%</span>
                            </div>
                            <span class="meter-circle-label">🌿 Kapha</span>
                        </div>
                    </div>
                </div>

                <!-- 3. INSIGHTS (Symptoms & Merits) -->
                <div class="insight-grid fade-up">
                    <!-- Imbalance Symptoms -->
                    <div class="insight-card imbalance">
                        <h4>⚠️ Common Symptoms</h4>
                        <p class="small-tag">When your dosha is imbalanced:</p>
                        <ul class="insight-list" id="imbalance-list">
                            <!-- Populated by JS -->
                        </ul>
                    </div>
                    <!-- Balanced Merits -->
                    <div class="insight-card balanced">
                        <h4>✨ Balanced State</h4>
                        <p class="small-tag">When your dosha is centered:</p>
                        <ul class="insight-list" id="merit-list">
                            <!-- Populated by JS -->
                        </ul>
                    </div>
                </div>

                <!-- 4. DAILY HABIT TREE (Main Visual) -->
                <div class="habit-tree-section fade-up" id="habit-tree-section">
                    <h3 class="tree-title" id="tree-title">Habit Tree</h3>
                    <p class="tree-desc">Your personalized road to balance and vitality.</p>
                    
                    <div class="tree-container">
                        <!-- Connectors (SVG) -->
                        <svg class="tree-connectors" id="tree-svg">
                            <!-- Paths drawn by JS/CSS -->
                        </svg>

                        <!-- Center Node -->
                        <div class="tree-center-node scale-in">
                            <div class="branch-icon-circle" id="tree-center-icon">🌿</div>
                            <h5 id="tree-center-text">Grounding & Warmth</h5>
                            <p>Main Principle</p>
                        </div>

                        <!-- Branches (5 Nodes) -->
                        <div class="branch-nodes" id="branch-nodes">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>

                <!-- 5. SOURCES / AUTHENTICITY -->
                <div class="results-references fade-up">
                    <p>Referenced from the Ancient Texts:</p>
                    <div class="ref-logos">
                        <span>Charaka Samhita</span>
                        <span>•</span>
                        <span>Ashtanga Hridaya</span>
                        <span>•</span>
                        <span>Sushruta Samhita</span>
                    </div>
                    <p style="font-size: 0.7rem; margin-top: 10px;">&copy; 2026 Modern Ayurveda Lifestyle Recommendations</p>
                </div>

                <div style="text-align: center; margin-top: 50px;">
                    <button class="btn-retake fade-up" onclick="retakeQuiz()" id="btn-retake">
                        ↩ Retake the Quiz
                    </button>
                </div>
            </div>
        </section>

    </div><!-- /app -->

    <!-- Scripts -->
    <script src="../doshaQuiz/questions.js"></script>
    <script src="../doshaQuiz/quiz.js?v=5.0"></script>

    <!-- Nav bar override: make sure quiz nav is shown when quiz starts -->
    <script>
        // Start quiz: the wrapper show/hide handles most of it
        const _startQuiz = startQuiz;
        window.startQuiz = function () {
            _startQuiz();
            // Show sub-elements inside wrapper
            document.getElementById('quiz-nav').classList.remove('hidden');
            document.getElementById('dosha-footer').classList.remove('hidden');
        };

        const _retakeQuiz = retakeQuiz;
        window.retakeQuiz = function () {
            _retakeQuiz();
            document.getElementById('quiz-nav').classList.remove('hidden');
            document.getElementById('dosha-footer').classList.remove('hidden');
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Need to wait slightly for quiz object to be initialized if it's done upon starting
            // Actually, we can just patch DoshaQuiz prototype immediately since quiz.js is loaded
            if (typeof DoshaQuiz !== 'undefined' && DoshaQuiz.prototype.showResults) {
                const originalShowResults = DoshaQuiz.prototype.showResults;
                DoshaQuiz.prototype.showResults = function () {
                    // Call the original function to show results
                    originalShowResults.apply(this);

                    // Only save if logged in
                    if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
                        return;
                    }

                    // We do some "Magic Math" to see who won!
                    const totals = this.getTotals();
                    const total = totals.V + totals.P + totals.K;
                    if (total === 0) return;

                    const dominant = Object.entries(totals).sort((a, b) => b[1] - a[1])[0][0];
                    let dominantName = 'vata';
                    if (dominant === 'P') dominantName = 'pitta';
                    if (dominant === 'K') dominantName = 'kapha';

                    const pV = Math.round((totals.V / total) * 100);
                    const pP = Math.round((totals.P / total) * 100);
                    const pK = Math.round((totals.K / total) * 100);

                    // We whisper the final results to the computer's secret diary (save_dosha_result.php)!
                    fetch('save_dosha_result.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            vata_percentage: pV,
                            pitta_percentage: pP,
                            kapha_percentage: pK,
                            dominant_dosha: dominantName
                        })
                    }).then(res => res.json()).then(data => {
                        console.log("Dosha result saved successfully", data);
                        // Keep profile/nav in sync immediately after quiz completion
                        localStorage.setItem('userDosha', dominantName);
                    }).catch(err => console.error("Failed to save dosha result", err));
                };
            }
        });
    </script>
</body>

</html>
