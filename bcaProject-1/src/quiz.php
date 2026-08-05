<!-- Wrapper to encapsulate quiz styles -->
<div id="quiz-wrapper">
    <div class="quiz-container">
        <div class="card-overlay">

            <!-- Quiz Play Area -->
            <div id="quiz-area">
                <div class="quiz-header">
                    <div class="quiz-title" data-i18n="quizTitle">Ayurvedic Dosha Quiz</div>
                    <div class="quiz-info">
                        <h3><span data-i18n="quizQuestionLabel">Question</span> <span id="current-q">1</span> <span
                                data-i18n="quizOfLabel">/</span> <span id="total-q">10</span></h3>
                    </div>
                </div>

                <div class="question-box" id="question-box">
                    <p class="question-text" id="question-text">Loading question...</p>
                </div>

                <div class="options-grid" id="options-grid">
                    <!-- Buttons will be injected here by JS -->
                </div>
            </div>

            <!-- Result Area -->
            <div id="result-area" class="result-box" style="display:none;">
                <h2 data-i18n="quizResultTitle">Your Body Constitution</h2>
                <p><span data-i18n="quizDominantLabel">Your dominant Dosha is:</span> <span id="dominant-dosha"
                        style="font-weight:bold; color:var(--text-secondary); font-size: 24px;"></span></p>
                <div id="dosha-description" style="margin: 20px 0; line-height: 1.6;"></div>
                <button class="restart-btn" onclick="location.reload()" data-i18n="quizRestartBtn">Preform
                    Again</button>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let currentQuestionIndex = 0;
        let counts = { vata: 0, pitta: 0, kapha: 0 };
        const typesReference = ["vata", "pitta", "kapha"];

        const questionText = document.getElementById('question-text');
        const optionsGrid = document.getElementById('options-grid');
        const currentQSpan = document.getElementById('current-q');
        const totalQSpan = document.getElementById('total-q');
        const quizArea = document.getElementById('quiz-area');
        const resultArea = document.getElementById('result-area');
        const dominantDoshaSpan = document.getElementById('dominant-dosha');
        const doshaDescription = document.getElementById('dosha-description');
        const questionBox = document.getElementById('question-box');

        function getQuestions() {
            const lang = localStorage.getItem('preferredLanguage') || 'en';
            return translations[lang].quizQuestions;
        }

        function getDescriptions() {
            const lang = localStorage.getItem('preferredLanguage') || 'en';
            return {
                vata: translations[lang].vataDesc,
                pitta: translations[lang].pittaDesc,
                kapha: translations[lang].kaphaDesc
            };
        }

        function initQuiz() {
            if (typeof translations === 'undefined') {
                setTimeout(initQuiz, 100);
                return;
            }
            if (totalQSpan) {
                totalQSpan.innerText = getQuestions().length;
                loadQuestion();
            }
        }

        initQuiz();

        function loadQuestion() {
            if (!questionBox) return;

            questionBox.classList.remove('fade-out', 'fade-in');
            optionsGrid.classList.remove('fade-out', 'fade-in');
            void questionBox.offsetWidth;
            questionBox.classList.add('fade-in');
            optionsGrid.classList.add('fade-in');

            const questions = getQuestions();
            const currentData = questions[currentQuestionIndex];
            currentQSpan.innerText = currentQuestionIndex + 1;
            questionText.innerText = currentData.q;
            optionsGrid.innerHTML = '';

            currentData.opts.forEach((opt, index) => {
                const btn = document.createElement('button');
                btn.classList.add('option-btn');
                btn.innerText = opt;
                btn.onclick = () => selectAnswer(typesReference[index]);
                optionsGrid.appendChild(btn);
            });
        }

        function selectAnswer(type) {
            counts[type]++;
            const allBtns = optionsGrid.querySelectorAll('.option-btn');
            allBtns.forEach(btn => btn.classList.add('disabled'));

            setTimeout(() => {
                questionBox.classList.add('fade-out');
                optionsGrid.classList.add('fade-out');
                setTimeout(() => {
                    currentQuestionIndex++;
                    if (currentQuestionIndex < getQuestions().length) {
                        loadQuestion();
                    } else {
                        showResult();
                    }
                }, 400);
            }, 500);
        }

        function showResult() {
            quizArea.style.display = 'none';
            resultArea.style.display = 'block';
            resultArea.classList.add('fade-in');

            let dominant = 'vata';
            if (counts.pitta > counts[dominant]) dominant = 'pitta';
            if (counts.kapha > counts[dominant]) dominant = 'kapha';

            dominantDoshaSpan.innerText = dominant.charAt(0).toUpperCase() + dominant.slice(1);
            localStorage.setItem('userDosha', dominant);

            if (typeof setCookie === 'function') {
                setCookie('userDosha', dominant, 30);
            }

            if (typeof displayDoshaRecommendations === 'function') {
                displayDoshaRecommendations();
            }

            const descriptions = getDescriptions();
            doshaDescription.innerText = descriptions[dominant];

            fetch(`update_points.php?action=quiz_complete&dosha=${dominant}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.message.includes('+5')) {
                            showAyurvedicPopup("Quest Complete!", "Your Dosha profile is saved permanent.", 5);
                        } else {
                            showAyurvedicPopup("Profile Updated", data.message);
                        }
                    }
                });
        }

        // Listen for language changes to update UI instantly
        window.addEventListener('languageChanged', () => {
            if (quizArea.style.display !== 'none') {
                loadQuestion();
            } else {
                const dominant = localStorage.getItem('userDosha') || 'vata';
                const descriptions = getDescriptions();
                doshaDescription.innerText = descriptions[dominant];
            }
        });
    });
</script>