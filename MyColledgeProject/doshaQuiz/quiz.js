// ===================================================
// Hello! This is the Game Master's Brain! 🧠
// It knows how to turn pages and count your points!
// ===================================================

// This is our big robot brain that plays the game with us!
class DoshaQuiz {
    // This is where the robot wakes up and gets ready!
    constructor() {
        this.currentIndex = 0; // We start at the very first page, number zero!
        this.answers = {}; // This is a secret bucket where we keep all your choices!
        this.totalQuestions = QUESTIONS.length; // This counts how many pages are in our big book!
        this.isAnimating = false; // This tells us if a page is currently sliding like a slide!

        this.initDOM(); // This tells the robot to look around and find all the buttons!
        this.renderQuestions(); // This tells the robot to draw all the pretty pictures!
        this.updateUI(); // This makes sure everything on the screen looks right!
    }

    /* ─────────────── LOOKING FOR BUTTONS ─────────────── */
    // This is where the robot finds all the toys on the screen to play with!
    initDOM() {
        // Find the blue bar that grows when we finish questions!
        this.progressFill = document.getElementById('progress-fill');
        // Find the counter that counts "1, 2, 3..." for us!
        this.questionCounter = document.getElementById('question-counter');
        // Find the big box that holds all the question pages!
        this.slideContainer = document.getElementById('slide-container');
        // Find the 'Go Next' button to see new pages!
        this.btnNext = document.getElementById('btn-next');
        // Find the Vata bar (like a blue wind bar!)
        this.meterV = document.getElementById('meter-bar-v');
        // Find the Pitta bar (like a red fire bar!)
        this.meterP = document.getElementById('meter-bar-p');
        // Find the Kapha bar (like a green leaf bar!)
        this.meterK = document.getElementById('meter-bar-k');
        // Find the numbers for Vata points!
        this.pctV = document.getElementById('pct-v');
        // Find the numbers for Pitta points!
        this.pctP = document.getElementById('pct-p');
        // Find the numbers for Kapha points!
        this.pctK = document.getElementById('pct-k');
        // Find the header at the top of our house!
        this.doshaHeader = document.getElementById('dosha-header');
        // Find the footer at the bottom of our house!
        this.doshaFooter = document.getElementById('dosha-footer');
        // Find the whole game box wrapper!
        this.quizWrapper = document.getElementById('quiz-wrapper');
        // Find the screen that shows your big trophy at the end!
        this.resultsScreen = document.getElementById('results-screen');

        // If we find the 'Next' button, we tell it to listen for our finger tap!
        if (this.btnNext) this.btnNext.addEventListener('click', () => this.goNext());
    }

    /* ─────────────── MAGICALLY DRAW THE CARDS ─────────────── */
    // This part takes the pictures from our book and puts them on the floor!
    renderQuestions() {
        // We look at every single page in our big book of questions!
        QUESTIONS.forEach((q, qi) => {
            // We make a new paper for each question!
            const slide = document.createElement('div');
            // We give the paper a name and make the first one visible!
            slide.className = 'question-slide' + (qi === 0 ? ' active' : '');
            // We give it a special ID tag so we don't lose it!
            slide.id = `slide-${qi}`;

            // We make all the little answer stickers for this page!
            const answersHTML = q.answers.map((a, ai) => `
        <div class="answer-card" id="card-${qi}-${ai}"
             data-qi="${qi}" data-ai="${ai}"
             data-dosha="${this.dominantDosha(a.scores)}"
             onclick="quiz.selectAnswer(${qi}, ${ai})">
          <div class="card-check">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </div>
          <div class="card-icon">${a.icon}</div>
          <div class="card-content">
            <div class="card-label">${a.label}</div>
            <div class="card-text">${a.text}</div>
          </div>
        </div>
      `).join('');

            // We write the question words and category on our paper!
            slide.innerHTML = `
        <span class="question-category">✦ ${q.category}</span>
        <h2 class="question-text">${q.question}</h2>
        <div class="answers-grid">${answersHTML}</div>
      `;

            // We put our finished paper into the big game box!
            this.slideContainer.appendChild(slide);
        });
    }

    /* ─────────────── PICKING A STICKER ─────────────── */
    // This is where you pick your favorite choice!
    selectAnswer(qi, ai) {
        // Check if you already picked a sticker on this page!
        const prev = this.answers[qi];

        // If you did, we have to take the glowing color off the old one!
        if (prev !== undefined) {
            const prevCard = document.getElementById(`card-${qi}-${prev.ai}`);
            if (prevCard) {
                prevCard.classList.remove('selected-vata', 'selected-pitta', 'selected-kapha');
            }
        }

        // We find the sticker you just clicked!
        const answer = QUESTIONS[qi].answers[ai];
        // We find out if it's an Air, Fire, or Earth type!
        const dosha = this.dominantDosha(answer.scores);
        // We put your choice into our secret basket!
        this.answers[qi] = { ai, scores: answer.scores };

        // We find the sticker on the screen...
        const card = document.getElementById(`card-${qi}-${ai}`);
        // ...and make it glow with its special color!
        card.classList.add(`selected-${dosha}`);

        // We make the phone go 'Bzzzt!' so you know you picked it!
        if (navigator.vibrate) navigator.vibrate(30);

        // We update the numbers on the screen!
        this.updateUI();
        // We update the thermometer bars at the bottom!
        this.updateDoshaMeter();

        // We wait just a tiny bit, then flip to the next page automatically!
        if (this.autoAdvanceTimer) clearTimeout(this.autoAdvanceTimer);
        
        // If there are more pages left to see...
        if (qi < this.totalQuestions - 1) {
            // ...we count to 700 and then flip!
            this.autoAdvanceTimer = setTimeout(() => {
                // Check if we are still on this page and not moving!
                if (this.currentIndex === qi && !this.isAnimating) {
                    this.goNext(); // Flip!
                } else if (this.currentIndex === qi && this.isAnimating) {
                    // Oops! Still moving, wait 200 more beats!
                    setTimeout(() => this.goNext(), 200);
                }
            }, 700);
        } else if (qi === this.totalQuestions - 1) {
            // If it's the very last page, we wait then show the results trophy!
            this.autoAdvanceTimer = setTimeout(() => {
               if (this.currentIndex === qi && !this.isAnimating) {
                   this.showResults(); // Show trophy!
               } else if (this.currentIndex === qi && this.isAnimating) {
                   setTimeout(() => this.showResults(), 200);
               }
            }, 700);
        }
    }

    // This is like saying "Next Page, please!"
    goNext() {
        // If the page is already sliding, we wait!
        if (this.isAnimating) return;
        // If you didn't pick a sticker yet, you can't go!
        if (!this.answers[this.currentIndex]) return;

        // If we are at the end, show the results!
        if (this.currentIndex >= this.totalQuestions - 1) {
            this.showResults();
            return;
        }

        // Otherwise, move to the next number page!
        this.navigateTo(this.currentIndex + 1);
    }



    /* ─────────────── MAGICALLY SLIDE TO THE NEXT PAGE ─────────────── */
    // This part makes the pages go 'zoom' left and right!
    navigateTo(next) {
        // First, we tell the robot brain: "Wait, we are moving the page!"
        this.isAnimating = true;
        // We tell our fingers: "Don't touch anything yet, it's moving!"
        if(this.slideContainer) this.slideContainer.style.pointerEvents = 'none';

        // We find the page we are on now...
        const currentSlide = document.getElementById(`slide-${this.currentIndex}`);
        // ...and the page we want to see next!
        const nextSlide = document.getElementById(`slide-${next}`);

        // We make sure the next page is ready to jump on screen!
        nextSlide.classList.remove('slide-out-left', 'slide-out-right', 'active');
        // We start the page on the right!
        nextSlide.style.transform = 'translateX(50px)';
        
        // We tell the computer to take a deep breath before moving!
        void nextSlide.offsetWidth;

        // We tell the old page: "Time to leave! Bye bye!"
        currentSlide.classList.remove('active');
        // It exits to the left!
        currentSlide.classList.add('slide-out-left');

        // We tell the new page: "Your turn! Jump on screen!"
        nextSlide.classList.add('active');

        // We count to 700 and then we are all done moving!
        setTimeout(() => {
            // We clean up the old page's mess...
            currentSlide.classList.remove('slide-out-left', 'slide-out-right');
            // ...and tell the robot: "We are officially on the new page now!"
            this.currentIndex = next;
            // "The page has stopped sliding!"
            this.isAnimating = false;
            // "Fingers can touch the screen again!"
            if (this.slideContainer) this.slideContainer.style.pointerEvents = 'auto';
            // "Show the new numbers at the top!"
            this.updateUI();
        }, 700);
    }

    /* ─────────────── POLISHING OUR TOYS ─────────────── */
    // This makes sure the numbers and bars look right!
    updateUI() {
        // We look at the blue bar at the top...
        if (this.progressFill) {
            // ...and we stretch it out based on how many pages we finished!
            const pct = ((this.currentIndex) / this.totalQuestions) * 100;
            this.progressFill.style.width = pct + '%';
        }

        // We find the little counter that says "Question X of 15"...
        if (this.questionCounter) {
            // ...and we tell it the new page number!
            this.questionCounter.textContent = `Question ${this.currentIndex + 1} of ${this.totalQuestions}`;
        }
        


        // We check the 'Next' button too!
        this.updateNextButton();

        // We make sure we start reading from the top of the new page!
        const slide = document.getElementById(`slide-${this.currentIndex}`);
        if (slide) slide.scrollTop = 0;
    }

    // This is for the 'Next' button toys!
    updateNextButton() {
        // If the button isn't there, we don't do anything!
        if (!this.btnNext) return;
        
        // We hide the button because the game flips pages by itself!
        this.btnNext.style.display = 'none';
        
        // We double check if you picked an answer yet!
        const hasAnswer = this.answers[this.currentIndex] !== undefined;
        // If you didn't, the button stays turned off!
        this.btnNext.disabled = !hasAnswer;
    }

    /* ─────────────── BALLOON BARS ─────────────── */
    // This part blows air into our Air, Fire, and Earth balloons!
    updateDoshaMeter() {
        // We count how many points we have in total!
        const totals = this.getTotals();
        // We make sure it's at least 1 so we don't have an empty box!
        const max = Math.max(totals.V + totals.P + totals.K, 1);

        // We find out how big each balloon should be!
        const vPct = Math.round((totals.V / max) * 100);
        const pPct = Math.round((totals.P / max) * 100);
        const kPct = Math.round((totals.K / max) * 100);

        // We tell each balloon bar to grow!
        this.animateMeterBar(this.meterV, this.pctV, vPct);
        this.animateMeterBar(this.meterP, this.pctP, pPct);
        this.animateMeterBar(this.meterK, this.pctK, kPct);
    }

    // This makes the balloon bar grow smoothly!
    animateMeterBar(bar, pctEl, value) {
        // If the bar isn't there, we don't blow!
        if (!bar || !pctEl) return;
        
        // We look at how big the bar was before...
        const prev = parseFloat(bar.style.width) || 0;
        // ...and we set it to the new bigger size!
        bar.style.width = value + '%';
        // We update the little number tag!
        pctEl.textContent = value + '%';

        // If it got bigger, we make it glow like a flashlight!
        if (value > prev) {
            bar.classList.remove('glow-pulse');
            // We tell the computer: "Look at the bar now!"
            void bar.offsetWidth;
            // "Make it blink!"
            bar.classList.add('glow-pulse');
        }
    }

    /* ─────────────── TA-DA! THE BIG FINALE ─────────────── */
    // This shows your big trophy and tell you what your type is! 🏆
    showResults() {
        // We gather all our points!
        const totals = this.getTotals();
        // we find the one you have the most of!
        const dominant = Object.entries(totals).sort((a, b) => b[1] - a[1])[0][0];
        // We get the special trophy description for that type! (V, P, or K)
        const result = DOSHA_RESULTS[dominant];
        // We count all your points one last time!
        const total = totals.V + totals.P + totals.K;

        // We find out the numbers for your final report!
        const pV = total ? Math.round((totals.V / total) * 100) : 0;
        const pP = total ? Math.round((totals.P / total) * 100) : 0;
        const pK = total ? Math.round((totals.K / total) * 100) : 0;

        // 1. Update Header & Card
        if (document.getElementById('results-dominant-emoji')) document.getElementById('results-dominant-emoji').textContent = result.emoji;
        if (document.getElementById('results-dominant-sanskrit')) document.getElementById('results-dominant-sanskrit').textContent = result.sanskrit;
        if (document.getElementById('results-dominant-name')) document.getElementById('results-dominant-name').textContent = result.name;
        if (document.getElementById('results-dominant-element')) document.getElementById('results-dominant-element').textContent = result.element;
        if (document.getElementById('results-dominant-desc')) document.getElementById('results-dominant-desc').textContent = result.description;

        // 2. Clear and fill the trait badges
        const traitsEl = document.getElementById('results-traits');
        if (traitsEl) {
            traitsEl.innerHTML = result.traits.map(t => `<span class="trait-badge">${t}</span>`).join('');
        }

        // 3. Update main colored card
        const dominantCard = document.getElementById('results-dominant-card');
        if (dominantCard) {
            dominantCard.style.background = result.gradient;
        }

        // 4. Update Circular Meters (Animated)
        this.updateCircularMeter('circle-v', 'circle-v-pct', pV);
        this.updateCircularMeter('circle-p', 'circle-p-pct', pP);
        this.updateCircularMeter('circle-k', 'circle-k-pct', pK);

        // 5. Populate Symptoms & Merits
        this.populateLists(result);

        // 6. Draw the Magic Habit Tree
        this.renderHabitTree(result);

        // 7. Toggle Screens
        if (this.quizWrapper) this.quizWrapper.classList.add('hidden');
        const qNav = document.getElementById('quiz-nav');
        if (qNav) qNav.classList.add('hidden');
        if (this.doshaFooter) this.doshaFooter.classList.add('hidden');
        
        if (this.resultsScreen) {
            this.resultsScreen.classList.remove('hidden');
            this.resultsScreen.classList.add('visible');
        }

        // Zoom back up to the top!
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Helper for circular progress
    updateCircularMeter(circleId, textId, pct) {
        const circle = document.getElementById(circleId);
        const text = document.getElementById(textId);
        if (!circle || !text) return;

        // The circumference for Radius 70 is 440
        const circumference = 2 * Math.PI * 70;
        circle.style.strokeDasharray = circumference;
        
        // At the start, we wait a tiny bit to trigger transition
        circle.style.strokeDashoffset = circumference;
        setTimeout(() => {
            const offset = circumference - (pct / 100) * circumference;
            circle.style.strokeDashoffset = offset;
            text.textContent = pct + '%';
        }, 300);
    }

    // Helper for lists
    populateLists(result) {
        const imbList = document.getElementById('imbalance-list');
        const merList = document.getElementById('merit-list');
        
        if (imbList) {
            imbList.innerHTML = result.challenges.map(c => `<li>${c}</li>`).join('');
        }
        if (merList) {
            // "Merits" can be "balanced" versions of traits or just traits
            merList.innerHTML = result.traits.map(t => `<li>${t}</li>`).join('');
        }
    }

    // Helper for Habit Tree
    renderHabitTree(result) {
        const nodesContainer = document.getElementById('branch-nodes');
        const centerIcon = document.getElementById('tree-center-icon');
        const centerText = document.getElementById('tree-center-text');
        
        if (!nodesContainer) return;

        // Update Center
        centerIcon.textContent = result.emoji;
        centerText.textContent = `Balanced ${result.name} Life`;

        // Create 5 Habit Nodes
        const habits = [
            { icon: '🥗', text: result.diet, label: 'Optimal Diet' },
            { icon: '🧘', text: result.lifestyle, label: 'Lifestyle' },
            { icon: '☕', text: 'Warm liquids & spice', label: 'Beverages' },
            { icon: '🕒', text: 'Regular routine', label: 'Daily Rhythm' },
            { icon: '🌬️', text: 'Deep breathing', label: 'Self Care' }
        ];

        nodesContainer.innerHTML = habits.map((h, i) => `
            <div class="branch-node branch-${i+1} scale-in" style="animation-delay: ${0.2 + (i*0.1)}s">
                <div class="branch-icon-circle">${h.icon}</div>
                <div class="branch-content">
                    <h6>${h.label}</h6>
                    <p>${h.text}</p>
                </div>
            </div>
        `).join('');
    }

    /* ─────────────── HELPER MAGIC ─────────────── */
    // This is like gathering all the jellybeans from our baskets!
    getTotals() {
        // Start with zero jellybeans!
        const totals = { V: 0, P: 0, K: 0 };
        // Look at every answer you picked!
        for (const ans of Object.values(this.answers)) {
            // Add the points to each color!
            totals.V += ans.scores.V;
            totals.P += ans.scores.P;
            totals.K += ans.scores.K;
        }
        // Give back the final count!
        return totals;
    }

    // This finds out which color you have the most of!
    dominantDosha(scores) {
        // Is it blue Air?
        if (scores.V >= scores.P && scores.V >= scores.K) return 'vata';
        // Is it red Fire?
        if (scores.P >= scores.V && scores.P >= scores.K) return 'pitta';
        // It must be green Earth!
        return 'kapha';
    }

    // This is like cleaning up all the toys and starting over!
    restart() {
        // Go back to page zero!
        this.currentIndex = 0;
        // Empty the secret basket!
        this.answers = {};
        // Make sure nothing is moving!
        this.isAnimating = false;

        // Clean every page in the book!
        this.slideContainer.querySelectorAll('.question-slide').forEach((s, i) => {
            // Only the first page is active!
            s.classList.toggle('active', i === 0);
            // reset all positions!
            s.style.transform = '';
            s.style.opacity = '';
            s.style.pointerEvents = '';
            // peel off the glowing stickers!
            s.querySelectorAll('.answer-card').forEach(c => {
                c.classList.remove('selected-vata', 'selected-pitta', 'selected-kapha');
            });
        });

        // Make the balloon bars empty!
        [this.meterV, this.meterP, this.meterK].forEach(b => b.style.width = '0%');
        [this.pctV, this.pctP, this.pctK].forEach(p => p.textContent = '0%');

        // Show the game again, hide the trophy!
        this.quizWrapper.classList.remove('hidden');
        this.resultsScreen.classList.remove('visible');
        this.resultsScreen.classList.add('hidden');
        document.getElementById('quiz-nav')?.classList.remove('hidden');
        document.getElementById('dosha-footer')?.classList.remove('hidden');
        document.getElementById('dosha-header')?.classList.remove('hidden');

        // Refresh the screen!
        this.updateUI();
        // Zoom back to the start!
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

/* ─────────────── THE STARTING LINE ─────────────── */
// When we press the big button to start!
function startQuiz() {
    // Hide the hello screen!
    document.getElementById('welcome-screen')?.classList.add('hidden');
    // Show the game box!
    document.getElementById('quiz-wrapper')?.classList.remove('hidden');
    // Show the balloon bars!
    document.getElementById('dosha-footer')?.classList.remove('hidden');
    // Show the top header!
    document.getElementById('dosha-header')?.classList.remove('hidden');
    // Create the magic robot brain!
    window.quiz = new DoshaQuiz();
}

// When we want to play again!
function retakeQuiz() {
    // Tell the robot to clean up and restart!
    if (window.quiz) window.quiz.restart();
}
