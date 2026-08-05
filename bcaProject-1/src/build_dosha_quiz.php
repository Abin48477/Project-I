<?php
$homepage = file_get_contents('HomePage.php');
$quizpage = file_get_contents('../doshaQuiz/index.php');

// Extract Header (from start up to the end of <nav> div)
$headerEndPos = strpos($homepage, '</nav>') + 6;
$navDivEndPos = strpos($homepage, '</div>', $headerEndPos) + 6;
$headerHtml = substr($homepage, 0, $navDivEndPos);

// Inject dosha quiz CSS
$headerHtml = str_replace('</head>', "    <link rel='stylesheet' href='../doshaQuiz/style.css?v=5.0' />\n</head>", $headerHtml);

// Extract Footer (from <footer class="main-footer"> to the end)
$footerStartPos = strpos($homepage, '<footer class="main-footer">');
$footerHtml = substr($homepage, $footerStartPos);

// Extract Quiz content (Background Orbs + app div + scripts)
$quizStart = strpos($quizpage, '<!-- Background Orbs -->');
$quizEnd = strpos($quizpage, '</body>');
$quizContent = substr($quizpage, $quizStart, $quizEnd - $quizStart);

// Fix paths for JS
$quizContent = str_replace('<script src="questions.js"></script>', '<script src="../doshaQuiz/questions.js"></script>', $quizContent);
$quizContent = str_replace('<script src="quiz.js"></script>', '<script src="../doshaQuiz/quiz.js?v=5.0"></script>', $quizContent);

// Add custom logic to save result
$customJs = <<<JS

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Need to wait slightly for quiz object to be initialized if it's done upon starting
            // Actually, we can just patch DoshaQuiz prototype immediately since quiz.js is loaded
            if (typeof DoshaQuiz !== 'undefined' && DoshaQuiz.prototype.showResults) {
                const originalShowResults = DoshaQuiz.prototype.showResults;
                DoshaQuiz.prototype.showResults = function() {
                    // Call the original function to show results
                    originalShowResults.apply(this);
                    
                    // Only save if logged in
                    if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
                        return;
                    }

                    const totals = this.getTotals();
                    const total = totals.V + totals.P + totals.K;
                    if(total === 0) return;

                    const dominant = Object.entries(totals).sort((a, b) => b[1] - a[1])[0][0];
                    let dominantName = 'vata';
                    if(dominant === 'P') dominantName = 'pitta';
                    if(dominant === 'K') dominantName = 'kapha';

                    const pV = Math.round((totals.V / total) * 100);
                    const pP = Math.round((totals.P / total) * 100);
                    const pK = Math.round((totals.K / total) * 100);
                    
                    fetch('save_dosha_result.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            vata_percentage: pV,
                            pitta_percentage: pP,
                            kapha_percentage: pK,
                            dominant_dosha: dominantName
                        })
                    }).then(res => res.json()).then(data => {
                        console.log("Dosha result saved successfully", data);
                    }).catch(err => console.error("Failed to save dosha result", err));
                };
            }
        });
    </script>
JS;

$finalHtml = $headerHtml . "\n" . $quizContent . "\n" . $customJs . "\n" . $footerHtml;

file_put_contents('dosha-quiz.php', $finalHtml);
echo "dosha-quiz.php created successfully.\n";
?>