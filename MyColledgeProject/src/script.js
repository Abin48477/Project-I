// This is a magic trick to show a pretty box with a message! 🌿
function showAyurvedicPopup(title, message, points) {
    // We create a new see-through curtain to cover the page!
    const overlay = document.createElement('div');
    overlay.className = 'quiz-modal-overlay';
    
    // We draw a pretty box on the curtain with a green leaf and our message!
    overlay.innerHTML = `
        <div class="quiz-modal">
            <div class="icon">🌿</div>
            <h2>${title}</h2>
            <p>${message}</p>
            ${points ? `<div class="points">+${points} Points! 🏆</div>` : ''}
            <br>
            <button class="quiz-modal-btn" onclick="this.closest('.quiz-modal-overlay').remove()">Excellent!</button>
        </div>
    `;
    
    // We put the curtain on the screen for everyone to see!
    document.body.appendChild(overlay);
}

// These are like "secret stickers" that the computer puts on your forehead so it remembers you!
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        // We decide how many days the sticker should stay before it falls off!
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    // We stick the sticker on!
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// This is how the computer looks for a specific "secret sticker" on your forehead!
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';'); // Look at all the stickers!
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length); // Found it!
    }
    return null; // Oops, no sticker found.
}

// This is our giant "Book of Everything"! It knows what helps for every "Ouchie"!
const remedies = {
    // These are some common things that might happen!
    "cough": "Warm honey-ginger drink, turmeric milk, steam inhalation.",
    "cold": "Ginger tea, tulsi tea, warm soups.",
    "fever": "Coriander seed water, light food, rest.",
    "headache": "Peppermint oil on temples, hydration, rest.",
    "stomach ache": "Ginger tea, ajwain water, light meals.",
    "gas": "Fennel seeds, warm water, walking.",
    "acidity": "Cold milk, banana, coconut water.",
    "stress": "Deep breathing, herbal tea, walk.",
    "acne": "Neem paste, turmeric, aloe vera.",

    // Digestive System
    "constipation": "Psyllium husk (Isabgol), warm water at night, soaked raisins.",
    "diarrhea": "Pomegranate juice, buttermilk with cumin, boiled apple.",
    "bloating": "Asafoetida (Hing) paste on navel, cumin tea, ginger.",
    "indigestion": "Lemon juice with ginger, chewing fennel seeds after meals.",
    "piles": "Buttermilk, figs soaked in water, aloe vera juice.",
    "food poisoning": "Cumin water, hydration with salt-sugar solution, ginger.",

    // Respiratory & Throat
    "sore throat": "Saltwater gargle, liquorice (Mulethi) tea, honey.",
    "sinusitis": "Steam inhalation with eucalyptus oil, warm compresses.",
    "asthma": "Ginger and garlic tea, honey with black pepper.",
    "bronchitis": "Turmeric milk, ginger juice with honey, steam inhalation.",
    "tonsillitis": "Turmeric and black pepper gargle, warm liquids.",

    // Skin & Hair
    "dandruff": "Lemon juice and coconut oil, neem water rinse.",
    "hair fall": "Amla juice, scalp massage with bhringraj oil.",
    "sunburn": "Aloe vera gel, cold cucumber juice, sandalwood paste.",
    "eczema": "Coconut oil, neem paste, oatmeal baths.",
    "dark circles": "Cucumber slices, almond oil massage, rose water.",
    "dry skin": "Honey mask, olive oil, milk cream (Malai).",

    // Bone, Joint & Muscle
    "back pain": "Warm oil massage, ginger tea, garlic oil.",
    "joint pain": "Turmeric latte, Fenugreek (Methi) seeds, warm sesame oil.",
    "muscle cramps": "Epsom salt soak, banana, hydration.",
    "arthritis": "Ginger and cinnamon tea, castor oil massage.",
    "sprain": "Turmeric and lime paste, cold compress, rest.",

    // General Wellness & Metabolic
    "insomnia": "Warm milk with nutmeg, foot massage with oil.",
    "anemia": "Beetroot juice, spinach, pomegranate, dates.",
    "fatigue": "Ashwagandha powder in milk, hydration, almonds.",
    "obesity": "Warm water with honey and lemon, Triphala powder.",
    "high blood pressure": "Garlic cloves, watermelon, hibiscus tea.",
    "diabetes": "Bitter gourd (Karela) juice, Jamun seed powder, Fenugreek.",

    // Common Ailments
    "mouth ulcers": "Coconut oil application, honey, chewing tulsi leaves.",
    "toothache": "Clove oil, salt water rinse, garlic clove.",
    "earache": "Warm garlic oil (2 drops), warm compress.",
    "eye strain": "Rose water drops, cold cucumber slices, palming.",
    "motion sickness": "Ginger candy, lemon juice, peppermint.",
    "menstrual cramps": "Fenugreek water, ginger tea, heating pad.",
    "urinary tract infection": "Cranberry juice, coriander seed water, coconut water.",
    "bad breath": "Chewing cloves, fennel seeds, cardamom.",
    "nosebleed": "Cold compress, stay upright, pomegranate juice.",
    "burns": "Aloe vera gel, honey, cold water (not ice).",
    "hiccups": "A teaspoon of sugar, holding breath, cold water.",
    "allergic rhinitis": "Turmeric, honey, avoiding cold foods."
};

// This is the magic button that looks in our "Book of Everything" to find help!
function findRemedy() {
    const input = document.getElementById('symptomInput'); // Find where we type the "Ouchie"!
    const resultBox = document.getElementById('result_Box'); // This is the secret box that shows the answer!
    const resultText = document.getElementById('result_Text'); // This is the paper inside the box for our writing!

    const symptom = input.value.toLowerCase().trim(); // Read what we typed!
    const userDosha = localStorage.getItem('userDosha'); // Look at our secret team badge!

    // If we didn't type anything, we say "Plese tell us what's wrong!"
    if (!symptom) {
        resultText.innerHTML = "⚠️ Please enter a symptom!";
        resultText.style.color = "#d62828"; // Red color because we forgot!
        resultBox.style.display = 'block'; // Show the box!
        return;
    }

    let htmlContent = "";

    // If our "Book" has the answer, we write it down!
    if (remedies[symptom]) {
        htmlContent = `✅ <strong>For "${symptom}":</strong><br>${remedies[symptom]}`;
        resultText.style.color = "#1b4332"; // Happy green color!
    } else {
        // If we don't know, we say "I'm not sure, try something else!"
        htmlContent = `❌ No direct remedy for "${symptom}".<br>Try: cough, headache, cold, fever, acne`;
        resultText.style.color = "#d62828"; // Sad red color.
    }

    // Add Dosha-based recommendations
    // If we know your team (Dosha), we give you extra special advice!
    if (userDosha) {
        const productRecs = {
            vata: "Patanjali Saundarya Aloe Vera Gel (Grounding), Patanjali Honey (Nourishing)",
            pitta: "Patanjali Saundarya Shower Gel (Cooling), Aloe Vera Gel (Soothing)",
            kapha: "Patanjali Honey (Heating/Scraping), Kesh Kanti Hair Cleaner (Stimulating)"
        };

        const imbalanceMsg = {
            vata: "Because of the VATA imbalance, these symptoms often occur due to excess dryness and air in your body.",
            pitta: "Because of the PITTA imbalance, these symptoms occur as a result of excess heat and fire.",
            kapha: "Because of the KAPHA imbalance, these symptoms happen because of excess congestion and water retention."
        };

        // We write the special advice in a pretty green box!
        htmlContent += `<hr><div class='dosha-rec' style='margin-top:15px; background: #f0fdf4; padding: 15px; border-radius: 12px; border: 1px solid #dcfce7;'>
            <p style='margin:0; font-weight:700; color: #166534;'>🌿 Personalized Analysis (${userDosha.toUpperCase()}):</p>
            <p style='margin:8px 0; font-size: 0.95rem; color: #374151;'>${imbalanceMsg[userDosha]}</p>
            <p style='margin:8px 0; font-size: 0.95rem; color: #374151;'>Use our <strong>${productRecs[userDosha]}</strong> to restore balance and be safe!</p>
        </div>`;
    } else {
        // If we don't know your team, we tell you to take the quiz!
        htmlContent += `<hr><p style='font-size: 0.9rem; color: #666;'>💡 <em>Take our Dosha Quiz (10 Qs) to see personalized product recommendations based on your body type!</em></p>`;
    }

    resultText.innerHTML = htmlContent;
    resultBox.style.display = 'block'; // Ta-da! Show the result!
    resultBox.scrollIntoView({ behavior: 'smooth' }); // Move the screen so we can see it!


}

// This helps us show a special message about your Dosha team!
function displayDoshaRecommendations() {
    // Check cookie first, then localStorage
    const userDosha = getCookie('userDosha') || localStorage.getItem('userDosha');
    const popup = document.getElementById('dosha-popup');
    const nameSpan = document.getElementById('popup-dosha-name');
    const adviceP = document.getElementById('user-dosha-advice');

    if (userDosha && popup) {
        // We only show the secret message if you haven't closed it yet!
        if (!sessionStorage.getItem('doshaPopupClosed')) {
            // We wait 2 seconds before popping out like a surprise!
            setTimeout(() => {
                popup.style.display = 'block';
                nameSpan.innerText = userDosha.toUpperCase(); // Show your team's name!

                const advice = {
                    vata: "Focus on grounding, warming, and nourishing habits.",
                    pitta: "Prioritize cooling, calming, and moderate activities.",
                    kapha: "Seek stimulating, warming, and energizing experiences."
                };
                adviceP.innerText = advice[userDosha];

                // Update Learn More link
                const learnMoreBtn = document.getElementById('popup-learn-more') || popup.querySelector('.btn-more');
                if (learnMoreBtn) {
                    const targetUrl = `recommendations.php?dosha=${userDosha.toLowerCase()}`;
                    learnMoreBtn.href = targetUrl;

                    // Direct navigation for reliability
                    learnMoreBtn.onclick = function (e) {
                        e.preventDefault();
                        window.location.href = targetUrl;
                    };
                }
            }, 2000); // Show after 2 seconds
        }
    }
}

// This is what happens when we press the "X" button to hide our message!
function closeDoshaPopup() {
    const popup = document.getElementById('dosha-popup');
    if (popup) {
        // The box slides away to the right like a sliding door!
        popup.style.animation = 'slideOutRight 0.5s forwards';
        setTimeout(() => {
            popup.style.display = 'none'; // Gone!
        }, 500);
        // We remember that you closed it so we don't bother you again!
        sessionStorage.setItem('doshaPopupClosed', 'true');
    }
}

// Payment Modal Logic
let currentPlanName = '';
let currentPlanPrice = 0;

// This is the piggy bank box that opens when you want to buy a plan!
function openPaymentModal(planName, price) {
    currentPlanName = planName;
    currentPlanPrice = price;

    // We write the name of the plan and how many pennies it costs!
    document.getElementById('selected-plan-name').innerText = planName;
    document.getElementById('selected-plan-price').innerText = '$' + price;

    const modal = document.getElementById('payment-modal');
    modal.style.display = 'flex'; // Put the box in the middle of the screen!
    void modal.offsetWidth;
    modal.classList.add('active'); // Make it pop out!
}

function closePaymentModal() {
    const modal = document.getElementById('payment-modal');
    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300); // Wait for transition
}

// This tells the piggy bank to send the money using "eSewa"!
function selectPayment(method) {
    if (method === 'esewa') {
        // We make a secret form and fill it with the plan details!
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'esewa_process.php';

        const amountInput = document.createElement('input');
        amountInput.type = 'hidden';
        amountInput.name = 'total_amount';
        amountInput.value = currentPlanPrice;
        form.appendChild(amountInput);

        // We press the "Pay Now" button automatically!
        const submitInput = document.createElement('input');
        submitInput.type = 'hidden';
        submitInput.name = 'proceed_payment';
        submitInput.value = 'true';
        form.appendChild(submitInput);

        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside (guarded if modal exists)
const paymentModalOverlay = document.getElementById('payment-modal');
if (paymentModalOverlay) {
    paymentModalOverlay.addEventListener('click', function (e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });
}



// Page Load
// This is where the computer wakes up and sets everything up!
document.addEventListener('DOMContentLoaded', function () {
    console.log("✅ Ayurvedic Portal Ready!");

    // Look for our "secret sticker" with your Dosha team!
    const savedDosha = getCookie('userDosha');
    if (savedDosha) {
        console.log(`🌿 Welcome back! Your ${savedDosha.toUpperCase()} profile is loaded.`);
    }

    // Show the Dosha message if we have one!
    displayDoshaRecommendations();

    // This is the special machine (Contact Form) that sends your letter to us!
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Don't let the page fly away!

            const formData = new FormData(this); // Pack up all the words you typed!
            const successMsg = document.getElementById('contactSuccess');
            const submitBtn = this.querySelector('button[type="submit"]');

            submitBtn.disabled = true; // Stop clicking for a second!
            submitBtn.innerText = 'Sending...'; // Tell you the postman is running!

            // We send the letter to our secret letterbox (save_message.php)!
            fetch('save_message.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // If the postman says "Delivered!", we show a green checkmark!
                    if (data.status === 'success') {
                        successMsg.style.display = 'block';
                        successMsg.classList.remove('alert-danger');
                        successMsg.classList.add('alert-success');
                        successMsg.innerHTML = '✅ Your message has been sent successfully! We\'ll get back to you soon.';
                        contactForm.reset(); // Empty the boxes for next time!
                    } else {
                        // If the postman trips, we show a red oops message!
                        successMsg.style.display = 'block';
                        successMsg.classList.remove('alert-success');
                        successMsg.classList.add('alert-danger');
                        successMsg.innerHTML = '❌ Error: ' + data.message;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    successMsg.style.display = 'block';
                    successMsg.classList.add('alert-danger');
                    successMsg.innerHTML = '❌ Something went wrong. Please try again.';
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Send Message';
                    setTimeout(() => {
                        successMsg.style.display = 'none';
                    }, 5000);
                });
        });
    }

    // This is the machine that slides the big pictures at the top!
    const slides = document.querySelectorAll('.hero-slide');
    let slideIndex = 0;
    if (slides.length > 0) {
        // Every 4 seconds, we change the picture! 1, 2, 3, 4... Change!
        setInterval(() => {
            slides[slideIndex].classList.remove('active'); // Hide the old picture!
            slideIndex = (slideIndex + 1) % slides.length; // Find the next picture!
            slides[slideIndex].classList.add('active'); // Show the new picture!
        }, 4000);
    }

    // Remedy Events
    document.getElementById('searchBtn').addEventListener('click', findRemedy);
    document.getElementById('symptomInput').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') findRemedy();
    });
    // Authentication check for product clicks
    document.querySelectorAll('.item-card, .product-card-wrapper').forEach(card => {
        card.addEventListener('click', function (e) {
            if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
                // If not logged in, prevent default action (e.g., navigating to product page)
                e.preventDefault();
                // Optionally, show a message or redirect to login
                alert('Please log in to view product details.');
                // You might want to redirect to a login page here
                // window.location.href = '/login.php';
            }
            // If logged in, allow the default action to proceed
        });
    });
    // This makes the top bar (header) hide when we walk down and show when we look back up!
    let lastScrollTop = 0;
    const header = document.querySelector('.header');

    if (header) {
        window.addEventListener('scroll', function () {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // If we are at the very top, always show our pretty bar!
            if (scrollTop < 50) {
                header.classList.remove('header-hidden');
                return;
            }

            if (scrollTop > lastScrollTop) {
                // Walking down - Hide the bar so we have more room to walk!
                header.classList.add('header-hidden');
            } else {
                // Looking up - Show the bar so we can find the magic doors!
                header.classList.remove('header-hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, false);
    }


    // This is the popup box that tells us about nature's toys (plants)!
    const plantModal = document.getElementById("plantModal");
    if (plantModal) {
        const closeBtn = plantModal.querySelector(".close-modal");
        const imgs = document.querySelectorAll('.carousel-img');

        // This hides the info box!
        const closeModal = () => {
            plantModal.style.display = "none";
            document.body.style.overflow = "auto";
        };

        // When you touch a plant picture, we show you the big secret box!
        imgs.forEach(img => {
            img.addEventListener('click', function () {
                const rawName = this.getAttribute('alt');
                let cleanName = rawName
                    .replace(/ Plant| Root| Fruit| image/gi, "")
                    .replace(/[0-9.]/g, "")
                    .replace(/\(.*\)/g, "")
                    .trim();

                if (cleanName.includes("howagandha")) cleanName = "Ashwagandha";

                const imgSrc = this.getAttribute('src');

                plantModal.style.display = "block"; // Show the big box!
                document.getElementById("modalPlantImage").src = imgSrc;
                document.getElementById("modalPlantName").innerText = cleanName;
                document.body.style.overflow = "hidden"; // Stop the page from moving!

                const setContent = (id, text) => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = text;
                };

                setContent("modalPlantUses", "Loading details...");
                setContent("modalPlantAdvantages", "");
                setContent("modalDosageVata", "...");
                setContent("modalDosagePitta", "...");
                setContent("modalDosageKapha", "...");

                fetch(`get_plant_details.php?name=${encodeURIComponent(cleanName)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const plant = data.data;
                            setContent("modalPlantName", plant.name);
                            setContent("modalPlantUses", plant.uses);
                            setContent("modalPlantAdvantages", plant.advantages);
                            setContent("modalDosageVata", plant.dosage_vata);
                            setContent("modalDosagePitta", plant.dosage_pitta);
                            setContent("modalDosageKapha", plant.dosage_kapha);
                        } else {
                            setContent("modalPlantUses", "Details not found in our Ayurvedic database.");
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        setContent("modalPlantUses", "Error loading details.");
                    });
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        window.addEventListener('click', (event) => {
            if (event.target == plantModal) closeModal();
        });
        window.addEventListener('keydown', (event) => {
            if (event.key === "Escape" && plantModal.style.display === "block") closeModal();
        });
    }
});
