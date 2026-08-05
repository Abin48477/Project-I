// This is our big toy chest full of 15 question boxes!
const QUESTIONS = [
  {
    // This is Question Box Number 1!
    id: 1,
    // This toy belongs to the "How my body is built" group!
    category: "Body Structure",
    // This is what the Game Master asks us!
    question: "Which best describes your natural body structure, especially around your shoulders, chest, and hips?",
    // Here are three choices we can pick!
    answers: [
      {
        // Choice A: Very thin!
        text: "Narrow frame",
        // This gives us 2 Air jellybeans!
        scores: { V: 2, P: 0, K: 0 },
        // Here is a pretty picture sticker!
        icon: `<svg viewBox="0 0 80 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="18" rx="11" ry="11" fill="#a8c4d4" opacity="0.9"/>
          <rect x="31" y="29" width="18" height="38" rx="6" fill="#7baec4" opacity="0.8"/>
          <rect x="22" y="31" width="9" height="28" rx="4" fill="#a8c4d4" opacity="0.7"/>
          <rect x="49" y="31" width="9" height="28" rx="4" fill="#a8c4d4" opacity="0.7"/>
          <rect x="30" y="64" width="8" height="36" rx="4" fill="#7baec4" opacity="0.8"/>
          <rect x="42" y="64" width="8" height="36" rx="4" fill="#7baec4" opacity="0.8"/>
        </svg>`,
        label: "Narrow & Light"
      },
      {
        text: "Medium frame",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="18" rx="13" ry="13" fill="#e8957a" opacity="0.9"/>
          <rect x="26" y="31" width="28" height="40" rx="7" fill="#d4745a" opacity="0.8"/>
          <rect x="13" y="33" width="13" height="30" rx="5" fill="#e8957a" opacity="0.7"/>
          <rect x="54" y="33" width="13" height="30" rx="5" fill="#e8957a" opacity="0.7"/>
          <rect x="27" y="68" width="10" height="34" rx="5" fill="#d4745a" opacity="0.8"/>
          <rect x="43" y="68" width="10" height="34" rx="5" fill="#d4745a" opacity="0.8"/>
        </svg>`,
        label: "Medium & Balanced"
      },
      {
        text: "Wide frame",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="18" rx="15" ry="15" fill="#7dc4a0" opacity="0.9"/>
          <rect x="20" y="33" width="40" height="42" rx="8" fill="#5aaa80" opacity="0.8"/>
          <rect x="5" y="35" width="15" height="32" rx="6" fill="#7dc4a0" opacity="0.7"/>
          <rect x="60" y="35" width="15" height="32" rx="6" fill="#7dc4a0" opacity="0.7"/>
          <rect x="22" y="72" width="14" height="32" rx="6" fill="#5aaa80" opacity="0.8"/>
          <rect x="44" y="72" width="14" height="32" rx="6" fill="#5aaa80" opacity="0.8"/>
        </svg>`,
        label: "Wide & Solid"
      }
    ]
  },
  {
    // Question Box Number 2!
    id: 2,
    // This toy is about how heavy or light we are!
    category: "Weight",
    question: "Which of these best describes your weight in general throughout your life?",
    answers: [
      {
        text: "Thin. It's difficult for me to gain weight.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="32" fill="#e8f4fb" stroke="#a8c4d4" stroke-width="2"/>
          <path d="M28 40 L52 40" stroke="#7baec4" stroke-width="3" stroke-linecap="round"/>
          <circle cx="40" cy="40" r="5" fill="#7baec4"/>
          <path d="M40 22 L40 30" stroke="#a8c4d4" stroke-width="2.5" stroke-linecap="round"/>
          <text x="40" y="62" text-anchor="middle" fill="#5a90b0" font-size="9" font-family="sans-serif">↕ Thin</text>
        </svg>`,
        label: "Hard to gain"
      },
      {
        text: "Medium. I gain and lose weight easily.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="32" fill="#fdf0ec" stroke="#e8957a" stroke-width="2"/>
          <path d="M24 44 Q40 28 56 44" stroke="#d4745a" stroke-width="3" stroke-linecap="round" fill="none"/>
          <circle cx="40" cy="38" r="5" fill="#d4745a"/>
          <text x="40" y="62" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">⇅ Flexible</text>
        </svg>`,
        label: "Easy fluctuation"
      },
      {
        text: "Heavy. I tend to gain weight easily.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="32" fill="#eef8f2" stroke="#7dc4a0" stroke-width="2"/>
          <ellipse cx="40" cy="42" rx="18" ry="22" fill="#7dc4a0" opacity="0.6"/>
          <ellipse cx="40" cy="40" rx="12" ry="12" fill="#5aaa80" opacity="0.8"/>
          <text x="40" y="70" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">↑ Gains easily</text>
        </svg>`,
        label: "Gains easily"
      }
    ]
  },
  {
    // Question Box Number 3!
    id: 3,
    // This toy is about how our skin feels!
    category: "Skin Type",
    question: "Which of these best describes your skin?",
    answers: [
      {
        text: "Always dry. My body just drinks moisturizer.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="38" rx="26" ry="30" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <path d="M30 28 Q40 22 50 28" stroke="#7baec4" stroke-width="2" fill="none" stroke-dasharray="3,2"/>
          <path d="M26 38 Q40 32 54 38" stroke="#a8c4d4" stroke-width="1.5" fill="none" stroke-dasharray="3,2"/>
          <path d="M30 48 Q40 42 50 48" stroke="#7baec4" stroke-width="2" fill="none" stroke-dasharray="3,2"/>
          <text x="40" y="76" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Dry & Rough</text>
        </svg>`,
        label: "Dry & Rough"
      },
      {
        text: "Oily. Easy for me to get pimples or redness.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="38" rx="26" ry="30" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <circle cx="32" cy="30" r="3.5" fill="#e05050" opacity="0.8"/>
          <circle cx="50" cy="34" r="2.5" fill="#e05050" opacity="0.6"/>
          <circle cx="38" cy="46" r="3" fill="#e05050" opacity="0.7"/>
          <ellipse cx="40" cy="36" rx="14" ry="16" fill="#e8957a" opacity="0.25"/>
          <text x="40" y="76" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Oily & Prone</text>
        </svg>`,
        label: "Oily & Prone"
      },
      {
        text: "Thick and smooth. Comfortable even without much moisturizer.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="38" rx="26" ry="30" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <ellipse cx="40" cy="36" rx="20" ry="22" fill="#7dc4a0" opacity="0.3"/>
          <path d="M28 36 Q40 28 52 36 Q52 50 40 56 Q28 50 28 36Z" fill="#5aaa80" opacity="0.4"/>
          <text x="40" y="76" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Smooth & Thick</text>
        </svg>`,
        label: "Smooth & Thick"
      }
    ]
  },
  {
    // Question Box Number 4!
    id: 4,
    // This toy is about how much "Water" comes out when we play!
    category: "Sweating",
    question: "After 30 minutes of a good workout, what would your shirt look like?",
    answers: [
      {
        text: "Barely wet — I don't sweat too much.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 30 L40 18 L60 30 L60 65 Q40 72 20 65Z" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <circle cx="38" cy="40" r="2" fill="#7baec4" opacity="0.5"/>
          <text x="40" y="76" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Barely Damp</text>
        </svg>`,
        label: "Barely damp"
      },
      {
        text: "Drenched. I sweat a lot with strong odor.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 30 L40 18 L60 30 L60 65 Q40 72 20 65Z" fill="#fde0d0" stroke="#e8957a" stroke-width="1.5"/>
          <ellipse cx="40" cy="44" rx="15" ry="14" fill="#e8957a" opacity="0.4"/>
          <path d="M32 28 Q30 22 34 18" stroke="#7baec4" stroke-width="2" stroke-linecap="round" fill="none"/>
          <path d="M40 25 Q38 18 42 13" stroke="#7baec4" stroke-width="2" stroke-linecap="round" fill="none"/>
          <path d="M48 28 Q50 22 46 18" stroke="#7baec4" stroke-width="2" stroke-linecap="round" fill="none"/>
          <text x="40" y="76" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Drenched</text>
        </svg>`,
        label: "Drenched"
      },
      {
        text: "Moderate — but fully wet in humid weather.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 30 L40 18 L60 30 L60 65 Q40 72 20 65Z" fill="#e0f0ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <ellipse cx="40" cy="44" rx="10" ry="10" fill="#7dc4a0" opacity="0.3"/>
          <path d="M36 28 Q34 23 37 19" stroke="#7baec4" stroke-width="1.5" stroke-linecap="round" fill="none"/>
          <path d="M44 28 Q46 23 43 19" stroke="#7baec4" stroke-width="1.5" stroke-linecap="round" fill="none"/>
          <text x="40" y="76" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Moderate</text>
        </svg>`,
        label: "Moderate"
      }
    ]
  },
  {
    // Question Box Number 5!
    // This toy is about if you feel like an ice cube or a warm cookie!
    id: 5,
    category: "Body Temperature",
    question: "How is your body's temperature?",
    answers: [
      {
        text: "Generally feel cold — love the warmth of the sun.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="28" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <path d="M40 20 L40 60 M20 40 L60 40 M26 26 L54 54 M54 26 L26 54" stroke="#a8c4d4" stroke-width="1.5" stroke-linecap="round"/>
          <circle cx="40" cy="40" r="8" fill="#7baec4" opacity="0.6"/>
          <text x="40" y="75" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">❄ Feels Cold</text>
        </svg>`,
        label: "Feels Cold"
      },
      {
        text: "My body feels hot easily — prefer winter.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="18" fill="#f4a070" opacity="0.9"/>
          <circle cx="40" cy="40" r="28" fill="none" stroke="#e8957a" stroke-width="1.5" stroke-dasharray="4,3"/>
          <path d="M40 10 L40 18 M40 62 L40 70 M10 40 L18 40 M62 40 L70 40" stroke="#e8957a" stroke-width="2.5" stroke-linecap="round"/>
          <path d="M18 18 L24 24 M56 56 L62 62 M56 24 L62 18 M18 62 L24 56" stroke="#e8957a" stroke-width="2" stroke-linecap="round"/>
          <text x="40" y="78" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">☀ Runs Hot</text>
        </svg>`,
        label: "Runs Hot"
      },
      {
        text: "Generally comfortable — prefer summer slightly.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="28" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <path d="M40 20 C50 30 50 50 40 60 C30 50 30 30 40 20Z" fill="#7dc4a0" opacity="0.6"/>
          <text x="40" y="75" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">✓ Comfortable</text>
        </svg>`,
        label: "Comfortable"
      }
    ]
  },
  {
    id: 6,
    category: "Hair",
    question: "What is your hair like?",
    answers: [
      {
        text: "Dry, thin, frizzy. Tends to be scanty, loses easily.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="35" rx="20" ry="22" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <path d="M25 20 Q22 10 28 8" stroke="#7baec4" stroke-width="1.5" stroke-dasharray="2,2" fill="none" stroke-linecap="round"/>
          <path d="M32 16 Q31 6 36 5" stroke="#7baec4" stroke-width="1.5" stroke-dasharray="2,2" fill="none" stroke-linecap="round"/>
          <path d="M40 15 Q40 4 43 4" stroke="#7baec4" stroke-width="1.5" stroke-dasharray="2,2" fill="none" stroke-linecap="round"/>
          <path d="M48 16 Q52 6 55 9" stroke="#7baec4" stroke-width="1.5" stroke-dasharray="2,2" fill="none" stroke-linecap="round"/>
          <text x="40" y="70" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Dry & Frizzy</text>
        </svg>`,
        label: "Dry & Frizzy"
      },
      {
        text: "Straight, thin — tendency to premature graying.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="35" rx="20" ry="22" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <path d="M28 16 L24 4" stroke="#aaaaaa" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M33 14 L31 2" stroke="#aaaaaa" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M40 13 L40 1" stroke="#e8957a" stroke-width="2" stroke-linecap="round"/>
          <path d="M47 14 L49 2" stroke="#aaaaaa" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M52 16 L56 4" stroke="#aaaaaa" stroke-width="1.5" stroke-linecap="round"/>
          <text x="40" y="70" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Fine & Straight</text>
        </svg>`,
        label: "Fine & Straight"
      },
      {
        text: "Thick, dense, abundant, naturally shiny.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="40" cy="35" rx="20" ry="22" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <path d="M22 25 Q18 12 25 8 Q28 20 28 28" fill="#5aaa80" opacity="0.7"/>
          <path d="M30 18 Q28 5 35 3 Q36 16 36 26" fill="#5aaa80" opacity="0.6"/>
          <path d="M40 16 Q40 3 45 3 Q44 16 44 26" fill="#7dc4a0" opacity="0.7"/>
          <path d="M48 18 Q52 5 57 9 Q52 20 52 28" fill="#5aaa80" opacity="0.6"/>
          <text x="40" y="70" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Thick & Lustrous</text>
        </svg>`,
        label: "Thick & Lustrous"
      }
    ]
  },
  {
    id: 7,
    category: "Eyes",
    question: "Which best describes your eyes?",
    answers: [
      {
        text: "Small, and they often get dry.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 40 Q40 22 60 40 Q40 58 20 40Z" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <circle cx="40" cy="40" r="9" fill="#7baec4" opacity="0.8"/>
          <circle cx="40" cy="40" r="5" fill="#3a6080"/>
          <circle cx="44" cy="36" r="1.5" fill="white"/>
          <text x="40" y="68" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Small & Dry</text>
        </svg>`,
        label: "Small & Dry"
      },
      {
        text: "Medium size with sharp, intense gaze.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 40 Q40 18 65 40 Q40 62 15 40Z" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <circle cx="40" cy="40" r="13" fill="#d4745a" opacity="0.8"/>
          <circle cx="40" cy="40" r="7" fill="#5a2010"/>
          <circle cx="45" cy="35" r="2" fill="white"/>
          <text x="40" y="68" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Sharp & Intense</text>
        </svg>`,
        label: "Sharp & Intense"
      },
      {
        text: "Large size with thick eyelashes.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M10 40 Q40 14 70 40 Q40 66 10 40Z" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <circle cx="40" cy="40" r="16" fill="#5aaa80" opacity="0.8"/>
          <circle cx="40" cy="40" r="9" fill="#1a4030"/>
          <circle cx="46" cy="33" r="2.5" fill="white"/>
          <path d="M24 30 Q28 24 32 28" stroke="#2d2d2d" stroke-width="2" stroke-linecap="round" fill="none"/>
          <path d="M48 28 Q54 22 58 27" stroke="#2d2d2d" stroke-width="2" stroke-linecap="round" fill="none"/>
          <text x="40" y="68" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Large & Lush</text>
        </svg>`,
        label: "Large & Lush"
      }
    ]
  },
  {
    id: 8,
    category: "Hunger",
    question: "What's your hunger like?",
    answers: [
      {
        text: "Irregular — sometimes not hungry, sometimes starving.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 50 Q25 30 35 45 Q45 60 55 35 Q65 15 70 40" stroke="#a8c4d4" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <circle cx="15" cy="50" r="3" fill="#7baec4"/>
          <circle cx="70" cy="40" r="3" fill="#7baec4"/>
          <text x="40" y="70" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Irregular</text>
        </svg>`,
        label: "Irregular"
      },
      {
        text: "Strong. I have a good appetite and feel hungry frequently.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M30 55 L30 25 Q30 15 40 15 Q50 15 50 25 L50 55Z" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <path d="M35 24 Q40 18 45 24" stroke="#e8957a" stroke-width="1.5" fill="none" stroke-linecap="round"/>
          <path d="M22 55 L58 55 Q60 65 40 68 Q20 65 22 55Z" fill="#d4745a" opacity="0.8"/>
          <text x="40" y="78" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Strong Appetite</text>
        </svg>`,
        label: "Strong"
      },
      {
        text: "Calm. I'm not physically hungry often. Fasting is fine.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="35" r="22" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <path d="M30 35 Q40 42 50 35" stroke="#5aaa80" stroke-width="2" fill="none" stroke-linecap="round"/>
          <circle cx="32" cy="30" r="2" fill="#5aaa80"/>
          <circle cx="48" cy="30" r="2" fill="#5aaa80"/>
          <text x="40" y="68" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Calm Appetite</text>
        </svg>`,
        label: "Calm"
      }
    ]
  },
  {
    id: 9,
    category: "Digestion",
    question: "What's your digestive health like?",
    answers: [
      {
        text: "Irregular — sometimes great, often bloated or constipated.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="38" r="22" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <path d="M30 38 Q35 32 40 38 Q45 44 50 38" stroke="#7baec4" stroke-width="2" fill="none" stroke-linecap="round"/>
          <path d="M28 45 Q40 50 52 45" stroke="#a8c4d4" stroke-width="1.5" fill="none" stroke-dasharray="3,2"/>
          <text x="40" y="72" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Irregular</text>
        </svg>`,
        label: "Irregular"
      },
      {
        text: "Very quick — hungry again 2–3 hours after eating.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="38" r="22" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <path d="M25 38 L55 38" stroke="#d4745a" stroke-width="3" stroke-linecap="round"/>
          <path d="M48 30 L55 38 L48 46" stroke="#d4745a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <text x="40" y="72" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Fast & Strong</text>
        </svg>`,
        label: "Quick & Strong"
      },
      {
        text: "Slow — takes long to feel hungry again, feel sluggish after heavy meals.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="38" r="22" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <path d="M30 35 Q40 28 50 35 Q50 48 40 52 Q30 48 30 35Z" fill="#7dc4a0" opacity="0.5"/>
          <path d="M34 38 Q40 42 46 38" stroke="#3a8060" stroke-width="1.5" fill="none" stroke-linecap="round"/>
          <text x="40" y="72" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Slow & Steady</text>
        </svg>`,
        label: "Slow & Steady"
      }
    ]
  },
  {
    id: 10,
    category: "Sleep",
    question: "What's your sleep like?",
    answers: [
      {
        text: "Light sleep. Wake up easily with sounds. Trouble sleeping.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 50 Q30 34 40 42 Q50 50 60 34" stroke="#a8c4d4" stroke-width="2" fill="none" stroke-linecap="round"/>
          <circle cx="60" cy="34" r="3" fill="#7baec4"/>
          <path d="M50 22 L54 26 M58 18 L58 24 M62 22 L58 26" stroke="#7baec4" stroke-width="1.5" stroke-linecap="round"/>
          <text x="40" y="38" text-anchor="middle" fill="#7baec4" font-size="16">💤</text>
          <text x="40" y="70" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Light & Restless</text>
        </svg>`,
        label: "Light & Restless"
      },
      {
        text: "Moderate, wake up promptly and ready to go.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="36" r="20" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <path d="M40 20 L40 36 L52 36" stroke="#d4745a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <circle cx="40" cy="36" r="2.5" fill="#d4745a"/>
          <path d="M26 56 L32 62 M54 56 L48 62" stroke="#e8957a" stroke-width="2" stroke-linecap="round"/>
          <text x="40" y="74" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Moderate & Alert</text>
        </svg>`,
        label: "Moderate & Alert"
      },
      {
        text: "Very deep — takes a while to wake up in the morning.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 44 Q40 20 65 44 Q65 62 40 66 Q15 62 15 44Z" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <path d="M28 36 Q40 30 52 36" stroke="#5aaa80" stroke-width="2" fill="none" stroke-linecap="round"/>
          <path d="M30 46 Q40 52 50 46" stroke="#5aaa80" stroke-width="2" fill="none" stroke-linecap="round"/>
          <text x="40" y="78" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Deep & Long</text>
        </svg>`,
        label: "Deep & Long"
      }
    ]
  },
  {
    id: 11,
    category: "Concentration",
    question: "When deep into a project or focusing on something important, what describes your style?",
    answers: [
      {
        text: "My mind flutters — constantly between thoughts and new ideas.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 40 Q22 25 30 38 Q38 50 46 28 Q54 10 65 35" stroke="#a8c4d4" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <circle cx="15" cy="40" r="3" fill="#7baec4" opacity="0.8"/>
          <circle cx="46" cy="28" r="3" fill="#7baec4" opacity="0.8"/>
          <circle cx="65" cy="35" r="3" fill="#7baec4"/>
          <text x="40" y="68" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Hummingbird Mind</text>
        </svg>`,
        label: "Scattered & Quick"
      },
      {
        text: "Laser-focused when engaged — but impatient with interruptions.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 40 L62 40" stroke="#d4745a" stroke-width="3" stroke-linecap="round"/>
          <path d="M55 30 L65 40 L55 50" stroke="#d4745a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <circle cx="15" cy="40" r="6" fill="#e8957a" opacity="0.7"/>
          <circle cx="40" cy="40" r="4" fill="#d4745a" opacity="0.5"/>
          <text x="40" y="62" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Laser Focus</text>
        </svg>`,
        label: "Laser Focused"
      },
      {
        text: "Slow to start but incredibly deep once in — hard to pull away.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="38" r="25" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <circle cx="40" cy="38" r="17" fill="#b0dfc0" opacity="0.7"/>
          <circle cx="40" cy="38" r="9" fill="#5aaa80" opacity="0.9"/>
          <circle cx="40" cy="38" r="3" fill="#1a5030"/>
          <text x="40" y="73" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Deep & Sustained</text>
        </svg>`,
        label: "Deep & Sustained"
      }
    ]
  },
  {
    id: 12,
    category: "Work Style",
    question: "Which of these describes you most closely when it comes to your work?",
    answers: [
      {
        text: "Many projects at once, excited by new ideas, often juggling.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="25" cy="30" r="10" fill="#a8c4d4" opacity="0.7"/>
          <circle cx="55" cy="28" r="10" fill="#7baec4" opacity="0.6"/>
          <circle cx="40" cy="52" r="10" fill="#5a90b0" opacity="0.7"/>
          <path d="M25 30 Q40 40 55 28" stroke="#7baec4" stroke-width="1.5" stroke-dasharray="3,2" fill="none"/>
          <path d="M55 28 Q50 42 40 52" stroke="#a8c4d4" stroke-width="1.5" stroke-dasharray="3,2" fill="none"/>
          <text x="40" y="75" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Multi-Tasker</text>
        </svg>`,
        label: "Multi-Tasker"
      },
      {
        text: "Intensely goal-oriented, perfectionist, loves to lead and compete.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <polygon points="40,10 50,35 75,35 55,52 63,77 40,60 17,77 25,52 5,35 30,35" fill="#e8957a" opacity="0.7" stroke="#d4745a" stroke-width="1.5"/>
          <text x="40" y="75" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Goal-Oriented</text>
        </svg>`,
        label: "Goal-Oriented"
      },
      {
        text: "Prefer stable, long-term roles. Struggle with constant change.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="20" y="22" width="40" height="36" rx="6" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <rect x="28" y="30" width="24" height="5" rx="2" fill="#7dc4a0" opacity="0.8"/>
          <rect x="28" y="40" width="16" height="5" rx="2" fill="#5aaa80" opacity="0.7"/>
          <rect x="36" y="60" width="8" height="12" rx="2" fill="#5aaa80" opacity="0.7"/>
          <text x="40" y="78" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Stable & Loyal</text>
        </svg>`,
        label: "Stable & Loyal"
      }
    ]
  },
  {
    id: 13,
    category: "Communication",
    question: "You're in a group discussion. What happens?",
    answers: [
      {
        text: "I talk fast, switching quickly between ideas and topics.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 45 Q12 28 28 28 L52 28 Q68 28 68 45 Q68 55 58 58 L48 72 L44 58 L28 58 Q12 58 12 45Z" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <path d="M22 40 L58 40 M22 48 L46 48" stroke="#7baec4" stroke-width="2" stroke-linecap="round"/>
          <path d="M54 44 L60 40 L54 36" stroke="#7baec4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <text x="40" y="78" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Fast Talker</text>
        </svg>`,
        label: "Fast & Flowing"
      },
      {
        text: "I speak up assertively to guide towards a clear decision.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 45 Q12 28 28 28 L52 28 Q68 28 68 45 Q68 55 58 58 L68 72 L52 58 L28 58 Q12 58 12 45Z" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <path d="M28 42 L52 42" stroke="#d4745a" stroke-width="3" stroke-linecap="round"/>
          <path d="M45 34 L52 42 L45 50" stroke="#d4745a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <text x="40" y="78" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Clear & Direct</text>
        </svg>`,
        label: "Clear & Direct"
      },
      {
        text: "I listen more — when I speak, my words are well-considered.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M32 20 Q32 10 40 10 Q52 10 52 22 Q52 30 44 34 L44 42 L36 42 L36 34 Q28 30 32 20Z" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <circle cx="40" cy="38" r="3" fill="#5aaa80"/>
          <path d="M26 55 Q40 48 54 55" stroke="#7dc4a0" stroke-width="2" stroke-linecap="round" fill="none"/>
          <text x="40" y="72" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Deep Listener</text>
        </svg>`,
        label: "Thoughtful Listener"
      }
    ]
  },
  {
    id: 14,
    category: "Emotions",
    question: "What negative emotion do you feel most frequently in your life?",
    answers: [
      {
        text: "Anxious, fearful, nervous.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="36" r="22" fill="#dde8f0" stroke="#a8c4d4" stroke-width="1.5"/>
          <path d="M30 34 Q35 28 40 34 Q45 28 50 34" stroke="#7baec4" stroke-width="2" fill="none" stroke-linecap="round"/>
          <circle cx="32" cy="42" r="2" fill="#5a80a0"/>
          <circle cx="48" cy="42" r="2" fill="#5a80a0"/>
          <path d="M30 48 Q40 44 50 48" stroke="#a8c4d4" stroke-width="1.5" fill="none" stroke-linecap="round"/>
          <text x="40" y="70" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Anxiety & Fear</text>
        </svg>`,
        label: "Anxiety & Fear"
      },
      {
        text: "Angry, impatient, and frustrated.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="36" r="22" fill="#fde8df" stroke="#e8957a" stroke-width="1.5"/>
          <path d="M30 32 Q35 26 40 32 Q45 26 50 32" stroke="#d4745a" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <circle cx="32" cy="42" r="2.5" fill="#b03030"/>
          <circle cx="48" cy="42" r="2.5" fill="#b03030"/>
          <path d="M30 50 Q35 56 40 48 Q45 56 50 50" stroke="#d4745a" stroke-width="2" fill="none" stroke-linecap="round"/>
          <text x="40" y="70" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Anger & Impatience</text>
        </svg>`,
        label: "Anger & Impatience"
      },
      {
        text: "Depressed, low, and demotivated.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="36" r="22" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <circle cx="32" cy="34" r="2" fill="#3a8060"/>
          <circle cx="48" cy="34" r="2" fill="#3a8060"/>
          <path d="M30 48 Q40 54 50 48" stroke="#5aaa80" stroke-width="2" fill="none" stroke-linecap="round"/>
          <path d="M28 28 L32 24 M48 24 L52 28" stroke="#7dc4a0" stroke-width="2" stroke-linecap="round"/>
          <text x="40" y="70" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Low & Withdrawn</text>
        </svg>`,
        label: "Low & Withdrawn"
      }
    ]
  },
  {
    id: 15,
    category: "Learning",
    question: "When learning something new, which best describes your experience?",
    answers: [
      {
        text: "Learn quickly but also forget quickly.",
        scores: { V: 2, P: 0, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 55 L25 25 L40 48 L55 20 L65 50" stroke="#a8c4d4" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="65" cy="50" r="4" fill="#7baec4"/>
          <path d="M55 58 L65 62" stroke="#a8c4d4" stroke-width="1.5" stroke-dasharray="2,2" stroke-linecap="round"/>
          <text x="40" y="74" text-anchor="middle" fill="#5a80a0" font-size="9" font-family="sans-serif">Quick — Then Fades</text>
        </svg>`,
        label: "Quick but Fades"
      },
      {
        text: "Learn quickly and recall when practically useful.",
        scores: { V: 0, P: 2, K: 0 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 55 L35 25 L50 45 L65 20" stroke="#e8957a" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="65" cy="20" r="4" fill="#d4745a"/>
          <path d="M50 62 L65 62" stroke="#e8957a" stroke-width="2" stroke-linecap="round"/>
          <text x="40" y="76" text-anchor="middle" fill="#b05030" font-size="9" font-family="sans-serif">Quick & Practical</text>
        </svg>`,
        label: "Quick & Practical"
      },
      {
        text: "Slower to grasp, but once learned — never forgotten.",
        scores: { V: 0, P: 0, K: 2 },
        icon: `<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="35" r="22" fill="#e0f4ea" stroke="#7dc4a0" stroke-width="1.5"/>
          <path d="M32 36 L38 42 L52 28" stroke="#3a8060" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <path d="M28 56 Q40 62 52 56" stroke="#7dc4a0" stroke-width="1.5" fill="none" stroke-linecap="round"/>
          <text x="40" y="72" text-anchor="middle" fill="#3a8060" font-size="9" font-family="sans-serif">Slow but Permanent</text>
        </svg>`,
        label: "Deep & Lasting"
      }
    ]
  }
];

// Dosha result descriptions
const DOSHA_RESULTS = {
  V: {
    // Team Vata (The Wind energy!)
    name: "Vata",
    sanskrit: "वात",
    element: "Air & Space",
    emoji: "🌬️",
    color: "#5b9bd5",
    gradient: "linear-gradient(135deg, #667eea 0%, #5b9bd5 100%)",
    traits: ["Creative", "Quick-thinking", "Enthusiastic", "Flexible", "Imaginative"],
    challenges: ["Anxiety", "Irregular digestion", "Restlessness", "Dryness"],
    diet: "Warm, nourishing, oily foods. Avoid cold and raw foods.",
    lifestyle: "Regular routines, adequate rest, grounding practices like yoga and meditation.",
    description: "Vata is the energy of movement — air and space. You are creative, quick, and full of ideas. Staying grounded and warm is your path to balance."
  },
  P: {
    // Team Pitta (The Fire energy!)
    name: "Pitta",
    sanskrit: "पित्त",
    element: "Fire & Water",
    emoji: "🔥",
    color: "#e8735a",
    gradient: "linear-gradient(135deg, #f093fb 0%, #e8735a 100%)",
    traits: ["Determined", "Intelligent", "Sharp", "Ambitious", "Focused"],
    challenges: ["Anger", "Inflammation", "Perfectionism", "Overheating"],
    diet: "Cool, sweet, and bitter foods. Limit spicy, salty, and sour foods.",
    lifestyle: "Time in nature, avoid overworking, cooling activities like swimming.",
    description: "Pitta is the energy of transformation — fire and water. You are driven, sharp, and goal-oriented. Cooling down and cultivating patience is your path to balance."
  },
  K: {
    // Team Kapha (The Earth energy!)
    name: "Kapha",
    sanskrit: "कफ",
    element: "Earth & Water",
    emoji: "🌿",
    color: "#5aaa80",
    gradient: "linear-gradient(135deg, #43e97b 0%, #5aaa80 100%)",
    traits: ["Calm", "Loyal", "Patient", "Strong", "Nurturing"],
    challenges: ["Lethargy", "Attachment", "Weight gain", "Slow metabolism"],
    diet: "Light, dry, and warm foods. Avoid heavy, oily, and sweet foods.",
    lifestyle: "Regular vigorous exercise, new challenges, stimulating activities.",
    description: "Kapha is the energy of structure — earth and water. You are grounded, stable, and deeply loyal. Staying active and embracing change is your path to balance."
  }
};
