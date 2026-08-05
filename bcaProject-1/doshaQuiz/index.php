<!-- This is a secret message for the computer to speak the right language! -->
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!-- This says "Hello! I am a website!" -->
<!DOCTYPE html>
<!-- This tells the computer we are typing in English! -->
<html lang="en">

<!-- This is the 'brain' part of the page where we keep name tags and library books! -->
<head>
    <!-- This helps the computer understand our alphabet! -->
    <meta charset="UTF-8" />
    <!-- This makes the page fit perfectly on a phone or tablet! -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <!-- This is a tiny story about the quiz for the internet to read! -->
    <meta name="description"
        content="Discover your Ayurvedic Dosha — Vata, Pitta, or Kapha — through this personalized 15-question quiz." />
    <!-- This makes the top of the browser look like a soft desert sand color! -->
    <meta name="theme-color" content="#faf8f4" />
    <!-- This is the page's name tag! -->
    <title>Dosha Quiz — Discover Your Ayurvedic Type</title>
    <!-- This is where we get the pretty colors and clothes for our page! -->
    <link rel="stylesheet" href="style.css" />
</head>

<!-- This is the 'body' where all the fun people and toys live! -->
<body>

    <!-- These are shiny magic bubbles floating in the background! -->
    <div class="bg-decoration" aria-hidden="true"></div>

    <!-- This is the big box that holds everything! -->
    <div id="app">

        <!-- This is the 'Hello Screen' we see first! -->
        <section id="welcome-screen" class="welcome-screen">

            <!-- This is the big magic flower made of circles and petals! -->
            <svg class="welcome-mandala" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Blue, Red, Green, and Gold rings! -->
                <circle cx="100" cy="100" r="90" stroke="#c9a84c" stroke-width="0.8" stroke-dasharray="4 4" />
                <circle cx="100" cy="100" r="70" stroke="#5b9bd5" stroke-width="0.8" stroke-dasharray="6 4" />
                <circle cx="100" cy="100" r="50" stroke="#e8735a" stroke-width="0.8" stroke-dasharray="3 5" />
                <circle cx="100" cy="100" r="30" stroke="#5aaa80" stroke-width="0.8" stroke-dasharray="4 3" />

                <!-- Pretty petals floating around! -->
                <ellipse cx="100" cy="25" rx="8" ry="16" fill="#c9a84c" opacity="0.25" />
                <ellipse cx="100" cy="175" rx="8" ry="16" fill="#c9a84c" opacity="0.25" />
                <ellipse cx="25" cy="100" rx="16" ry="8" fill="#5b9bd5" opacity="0.25" />
                <ellipse cx="175" cy="100" rx="16" ry="8" fill="#5b9bd5" opacity="0.25" />

                <!-- Diagonal petals spinning! -->
                <ellipse cx="54" cy="54" rx="8" ry="16" fill="#e8735a" opacity="0.2" transform="rotate(-45 54 54)" />
                <ellipse cx="146" cy="54" rx="8" ry="16" fill="#e8735a" opacity="0.2" transform="rotate(45 146 54)" />
                <ellipse cx="54" cy="146" rx="8" ry="16" fill="#5aaa80" opacity="0.2" transform="rotate(45 54 146)" />
                <ellipse cx="146" cy="146" rx="8" ry="16" fill="#5aaa80" opacity="0.2"
                    transform="rotate(-45 146 146)" />

                <!-- The tiny heart in the middle of our flower! -->
                <circle cx="100" cy="100" r="6" fill="#c9a84c" opacity="0.7" />
                <circle cx="100" cy="100" r="3" fill="#c9a84c" />
            </svg>

            <!-- A little sparkle message! -->
            <p class="welcome-tagline">✦ Ancient Wisdom · Modern Life ✦</p>
            <!-- The big giant title! -->
            <h1 class="welcome-title">Discover Your<br />Dosha Type</h1>
            <!-- A story about what we are going to do! -->
            <p class="welcome-desc">
                Answer 15 honest questions about your body and mind.
                Reveal whether you are Vata, Pitta, or Kapha — and what that means for your health and life.
            </p>

            <!-- Three little team badges: Wind, Fire, and Plant! -->
            <div class="welcome-doshas">
                <div class="dosha-pill vata">🌬️ Vata</div>
                <div class="dosha-pill pitta">🔥 Pitta</div>
                <div class="dosha-pill kapha">🌿 Kapha</div>
            </div>

            <!-- The big 'Ready, Set, Go!' button! -->
            <button class="btn-start" onclick="startQuiz()" id="btn-start">
                Begin Your Journey →
            </button>
            <!-- A tiny note for the grown-ups! -->
            <p class="quiz-info">15 questions · ~5 minutes · 100% private</p>
        </section>


        <!-- This is the secret box that stays hidden until we press the 'Go' button! -->
        <div id="quiz-wrapper" class="hidden">

            <!-- This is the scoreboard at the top of the stadium! -->
            <header class="quiz-header" id="dosha-header">
                <!-- This is the top part of the scoreboard! -->
                <div class="header-top">
                    <!-- The team name! -->
                    <div class="header-brand">
                        <!-- A little shiny dot! -->
                        <div class="brand-dot"></div>
                        <span class="brand-name">Dosha Quiz</span>
                    </div>
                    <!-- This tell us how many pages we've finished! -->
                    <span class="question-counter" id="question-counter">Question 1 of 15</span>
                </div>
                <!-- This is the path we walk on! It fills with color as we go! -->
                <div class="progress-track" role="progressbar" aria-label="Quiz progress" id="progress-track">
                    <!-- The computer will draw the path here! -->
                </div>
            </header>

            <!-- This is the big playground where all the questions are! -->
            <main class="quiz-main">
                <!-- This is the box where the robot brain puts our question papers! -->
                <div class="slide-container" id="slide-container">
                    <!-- The robot brain will put slides here! -->
                </div>
            </main>

            <!-- This is the balloon station at the bottom to see your score! -->
            <div class="dosha-meter hidden" id="dosha-footer" role="status" aria-live="polite"
                aria-label="Live Dosha Meter">
                <!-- The title of our balloon shop! -->
                <div class="meter-title">✦ Live Dosha Meter</div>
                <!-- This box holds all three balloons! -->
                <div class="dosha-bars-wrapper">
                    <!-- The Wind (Vata) balloon row! -->
                    <div class="meter-row meter-vata">
                        <div class="meter-header">
                            <span class="meter-label">🌬️ Vata</span>
                            <!-- The number of wind points! -->
                            <span class="meter-pct" id="pct-v">0%</span>
                        </div>
                        <!-- The track where the balloon grows! -->
                        <div class="meter-track">
                            <div class="meter-bar" id="meter-bar-v"></div>
                        </div>
                    </div>
                    <!-- The Fire (Pitta) balloon row! -->
                    <div class="meter-row meter-pitta">
                        <div class="meter-header">
                            <span class="meter-label">🔥 Pitta</span>
                            <!-- The number of fire points! -->
                            <span class="meter-pct" id="pct-p">0%</span>
                        </div>
                        <div class="meter-track">
                            <div class="meter-bar" id="meter-bar-p"></div>
                        </div>
                    </div>
                    <!-- The Plant (Kapha) balloon row! -->
                    <div class="meter-row meter-kapha">
                        <div class="meter-header">
                            <span class="meter-label">🌿 Kapha</span>
                            <!-- The number of plant points! -->
                            <span class="meter-pct" id="pct-k">0%</span>
                        </div>
                        <div class="meter-track">
                            <div class="meter-bar" id="meter-bar-k"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This is the 'Remote Control' for our game! -->
            <nav class="nav-bar hidden" id="quiz-nav">
                <!-- The 'Step Forward' button (we hide this because it's automatic!) -->
                <button class="btn btn-next" id="btn-next" disabled aria-label="Go to next question">
                    Next
                    <!-- A little arrow pointing right! -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </nav>

        </div><!-- All done with the quiz box! -->


        <!-- This is the Big Celebration Room where we get our medal! -->
        <section id="results-screen" class="results-screen hidden">

            <!-- The celebration title! -->
            <div class="results-header fade-up">
                <p class="results-tag">✦ Your Ayurvedic Profile ✦</p>
                <h2 class="results-title">Your Dominant Dosha</h2>
                <p class="results-subtitle">Based on your answers across all 15 questions</p>
            </div>

            <!-- This is your Giant Shiny Medal! -->
            <div class="dominant-card fade-up" id="results-dominant-card">
                <!-- A big sticker! -->
                <span class="dominant-emoji" id="results-dominant-emoji">🌬️</span>
                <!-- A fancy ancient word! -->
                <p class="dominant-sanskrit" id="results-dominant-sanskrit">वात</p>
                <!-- Your type's name! -->
                <h3 class="dominant-name" id="results-dominant-name">Vata</h3>
                <!-- What magic element you are! -->
                <p class="dominant-element" id="results-dominant-element">Air &amp; Space</p>
                <!-- A story about YOU! -->
                <p class="dominant-desc" id="results-dominant-desc"></p>
                <!-- Little badges you earned! -->
                <div class="dominant-traits" id="results-traits"></div>
            </div>

            <!-- This shows your final point counts! -->
            <div class="results-breakdown fade-up">
                <p class="breakdown-title">Your Dosha Breakdown</p>

                <!-- Points for Wind! -->
                <div class="breakdown-bar-row">
                    <span class="breakdown-dosha" style="color:#5b9bd5">🌬️ Vata</span>
                    <div class="breakdown-track">
                        <div class="breakdown-fill" id="bd-v"
                            style="background:linear-gradient(90deg,#7baec4,#5b9bd5);width:0%"></div>
                    </div>
                    <span class="breakdown-pct" id="bd-v-pct" style="color:#5b9bd5">0%</span>
                </div>

                <!-- Points for Fire! -->
                <div class="breakdown-bar-row">
                    <span class="breakdown-dosha" style="color:#e8735a">🔥 Pitta</span>
                    <div class="breakdown-track">
                        <div class="breakdown-fill" id="bd-p"
                            style="background:linear-gradient(90deg,#e8a07a,#e8735a);width:0%"></div>
                    </div>
                    <span class="breakdown-pct" id="bd-p-pct" style="color:#e8735a">0%</span>
                </div>

                <!-- Points for Plant! -->
                <div class="breakdown-bar-row">
                    <span class="breakdown-dosha" style="color:#5aaa80">🌿 Kapha</span>
                    <div class="breakdown-track">
                        <div class="breakdown-fill" id="bd-k"
                            style="background:linear-gradient(90deg,#7dc4a0,#5aaa80);width:0%"></div>
                    </div>
                    <span class="breakdown-pct" id="bd-k-pct" style="color:#5aaa80">0%</span>
                </div>
            </div>

            <!-- Smart Tips Corner! -->
            <div class="results-advice fade-up">

                <!-- Best foods to eat! -->
                <div class="advice-section">
                    <p class="advice-label">🥗 Diet Guidance</p>
                    <p class="advice-text" id="result-diet"></p>
                </div>

                <!-- Fun games and habits! -->
                <div class="advice-section">
                    <p class="advice-label">🧘 Lifestyle</p>
                    <p class="advice-text" id="result-lifestyle"></p>
                </div>

                <!-- Things to be careful about! -->
                <div class="advice-section">
                    <p class="advice-label">⚠️ Watch Out For</p>
                    <p class="advice-text" id="result-challenges"></p>
                </div>

            </div>

            <!-- The 'Can we play again?' button! -->
            <button class="btn-retake fade-up" onclick="retakeQuiz()" id="btn-retake">
                ↩ Retake the Quiz
            </button>

        </section>

    </div><!-- End of our big world! -->

    <!-- These are the magic books that tell the computer how to play the game! -->
    <script src="questions.js"></script>
    <script src="quiz.js"></script>

    <!-- A secret code that makes sure the game shows up right! -->
    <script>
        // When we start the game...
        const _startQuiz = startQuiz;
        window.startQuiz = function () {
            _startQuiz();
            // Show the remote control and the balloon bar!
            document.getElementById('quiz-nav').classList.remove('hidden');
            document.getElementById('dosha-footer').classList.remove('hidden');
        };

        // When we want to replay...
        const _retakeQuiz = retakeQuiz;
        window.retakeQuiz = function () {
            _retakeQuiz();
            // Show the remote control and the balloon bar again!
            document.getElementById('quiz-nav').classList.remove('hidden');
            document.getElementById('dosha-footer').classList.remove('hidden');
        };
    </script>

</body>

</html>
