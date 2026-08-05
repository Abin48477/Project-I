<?php
$homepage = file_get_contents('HomePage.php');

$headEndPos = strpos($homepage, '</head>');
$headerHtml1 = substr($homepage, 0, $headEndPos);
$headerHtml2 = substr($homepage, $headEndPos, strpos($homepage, '</div>', strpos($homepage, '</nav>')) + 6 - $headEndPos);

$profileCss = <<<CSS
    <style>
        .profile-container { max-width: 1200px; margin: 40px auto; display: flex; gap: 30px; padding: 20px; font-family: 'Poppins', sans-serif; }
        .profile-sidebar { flex: 1; min-width: 250px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); text-align: center; border: 1px solid rgba(255,255,255,0.8); }
        .profile-main { flex: 3; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid rgba(255,255,255,0.8); }
        .avatar { width: 130px; height: 130px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 4px solid #fff; box-shadow: 0 8px 24px rgba(90, 170, 128, 0.3); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .avatar:hover { transform: scale(1.05) rotate(5deg); }
        
        .tabs { display: flex; border-bottom: 2px solid rgba(0,0,0,0.05); margin-bottom: 25px; gap: 20px; overflow-x: auto; padding-bottom: 10px; }
        .tab { white-space: nowrap; padding: 10px 15px; cursor: pointer; border-radius: 12px; font-weight: 600; color: #666; transition: all 0.3s ease; background: transparent; }
        .tab:hover { color: #2d6a4f; background: rgba(45, 106, 79, 0.05); transform: translateY(-2px); }
        .tab.active { background: linear-gradient(135deg, #a8e6cf, #dcedc1); color: #1b4332; box-shadow: 0 4px 15px rgba(168, 230, 207, 0.4); }
        .tab-content { display: none; animation: slideUpFade 0.5s ease; }
        .tab-content.active { display: block; }
        
        @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .progress-bar-container { background: rgba(0,0,0,0.05); border-radius: 10px; height: 14px; width: 100%; margin: 8px 0 24px 0; overflow: hidden; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); }
        .progress-bar { height: 100%; border-radius: 10px; transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1); position: relative; }
        .progress-bar::after { content:''; position:absolute; top:0; left:0; right:0; bottom:0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); animation: shimmer 2s infinite linear; }
        .pb-vata { background: linear-gradient(90deg,#7baec4,#5b9bd5); box-shadow: 0 0 10px rgba(91, 155, 213, 0.4); }
        .pb-pitta { background: linear-gradient(90deg,#e8a07a,#e8735a); box-shadow: 0 0 10px rgba(232, 115, 90, 0.4); }
        .pb-kapha { background: linear-gradient(90deg,#7dc4a0,#5aaa80); box-shadow: 0 0 10px rgba(90, 170, 128, 0.4); }
        
        .dosha-label { display: flex; justify-content: space-between; font-size: 0.9em; font-weight: 700; color: #444; letter-spacing: 0.5px; }
        
        .history-card { background: white; border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; padding: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.02); cursor: default; }
        .history-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 12px 30px rgba(0,0,0,0.08); border-color: rgba(90, 170, 128, 0.2); }
        
        .badge { padding: 6px 14px; border-radius: 20px; font-size: 0.85em; font-weight: 700; color: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .badge-vata { background: linear-gradient(135deg, #7baec4, #5b9bd5); } 
        .badge-pitta { background: linear-gradient(135deg, #e8a07a, #e8735a); } 
        .badge-kapha { background: linear-gradient(135deg, #7dc4a0, #5aaa80); }

        .feature-card { transition: all 0.3s ease; cursor: default; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }

        .rec-card { transition: all 0.3s ease; }
        .rec-card:hover { transform: translateX(5px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); filter: brightness(0.98); }
        
        @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
        
        @media (max-width: 768px) {
            .profile-container { flex-direction: column; }
            .tabs { padding-bottom: 5px; }
        }
    </style>
CSS;

$headerHtml = $headerHtml1 . $profileCss . $headerHtml2;

$footerStartPos = strpos($homepage, '<footer class="main-footer">');
$footerHtml = substr($homepage, $footerStartPos);

// Define profile content with proper variable handling so PHP won't execute during file generation
$profileContent = <<<'HTML'
<?php
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href='login.php';</script>";
} else {
    $username = $_SESSION['user'];
    $user_res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = $user_res ? mysqli_fetch_assoc($user_res) : null;
    $user_id = $user['id'] ?? 0;
    $email = $user['email'] ?? 'No email provided';
    $db_dosha = $user['dosha'] ?? 'Unknown';

    $dosha_history_res = mysqli_query($conn, "SELECT * FROM dosha_results WHERE user_id=$user_id ORDER BY created_at DESC");
    $history = [];
    if ($dosha_history_res) {
        while($row = mysqli_fetch_assoc($dosha_history_res)) {
            $history[] = $row;
        }
    }
    $latest = $history[0] ?? null;

    $display_dosha = $latest ? $latest['dominant_dosha'] : ($db_dosha ?: 'Not Discovered');
?>

<div class="profile-container">
    <aside class="profile-sidebar">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($username); ?>&background=random" alt="Avatar" class="avatar">
        <h2 style="margin:0;"><?php echo htmlspecialchars($username); ?></h2>
        <p style="color:#666; font-size:0.9em; margin-top:5px;"><?php echo htmlspecialchars($email); ?></p>
        
        <div style="margin-top:20px; padding-top:20px; border-top:1px solid #eee; text-align:left;">
            <p style="text-transform:uppercase; font-size:0.8em; color:#999; letter-spacing:1px; margin-bottom:15px;">Your DOSHA</p>
            <h3 style="margin-top:0; color:#5aaa80; text-transform:capitalize;">
                <?php echo htmlspecialchars($display_dosha); ?>
            </h3>
            
            <?php if($latest): ?>
                <div class="dosha-label"><span>Vata</span> <span><?php echo $latest['vata_percentage']; ?>%</span></div>
                <div class="progress-bar-container"><div class="progress-bar pb-vata" style="width: <?php echo $latest['vata_percentage']; ?>%"></div></div>

                <div class="dosha-label"><span>Pitta</span> <span><?php echo $latest['pitta_percentage']; ?>%</span></div>
                <div class="progress-bar-container"><div class="progress-bar pb-pitta" style="width: <?php echo $latest['pitta_percentage']; ?>%"></div></div>

                <div class="dosha-label"><span>Kapha</span> <span><?php echo $latest['kapha_percentage']; ?>%</span></div>
                <div class="progress-bar-container"><div class="progress-bar pb-kapha" style="width: <?php echo $latest['kapha_percentage']; ?>%"></div></div>
            <?php else: ?>
                <p style="font-size:0.9em; color:#666;">Take the Dosha Quiz to see your breakdown.</p>
                <a href="dosha-quiz.php" style="display:inline-block; padding:8px 15px; background:#5aaa80; color:#fff; border-radius:5px; text-decoration:none; font-size:0.9em; margin-top:10px;">Take Quiz</a>
            <?php endif; ?>
        </div>
    </aside>

    <main class="profile-main">
        <div class="tabs">
            <div class="tab active" onclick="switchTab('overview')">Overview</div>
            <div class="tab" onclick="switchTab('quiz-results')">Quiz Results</div>
            <div class="tab" onclick="switchTab('health-rec')">Health Recommendations</div>
        </div>

        <div id="overview" class="tab-content active">
            <h3>Welcome back, <?php echo htmlspecialchars($username); ?>!</h3>
            <p>This is your personal Ayurvedic health dashboard. Discover your unique mind-body constitution, track your quiz results, and get recommendations tailored just for you.</p>
            <div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:30px;">
                <div style="flex:1; min-width:200px; padding:20px; background:#f9f9f9; border-radius:10px; border-left:4px solid #5b9bd5;">
                    <h4 style="margin-top:0;">Know Your Dosha</h4>
                    <p style="font-size:0.9em;">Take our comprehensive quiz to uncover your unique Ayurvedic profile.</p>
                </div>
                <div style="flex:1; min-width:200px; padding:20px; background:#f9f9f9; border-radius:10px; border-left:4px solid #e8735a;">
                    <h4 style="margin-top:0;">Personalized Diet</h4>
                    <p style="font-size:0.9em;">Get food recommendations that balance your specific dosha blend.</p>
                </div>
            </div>
        </div>

        <div id="quiz-results" class="tab-content">
            <h3>Quiz History</h3>
            <?php if(count($history) > 0): ?>
                <?php foreach($history as $result): 
                    $dom = strtolower($result['dominant_dosha']);
                    $badgeFormat = "badge-vata";
                    if($dom == 'pitta') $badgeFormat = 'badge-pitta';
                    if($dom == 'kapha') $badgeFormat = 'badge-kapha';
                ?>
                <div class="history-card">
                    <div>
                        <div style="font-weight:600; margin-bottom:5px;">Dominant: <span style="text-transform:capitalize;"><?php echo htmlspecialchars($result['dominant_dosha']); ?></span></div>
                        <div style="font-size:0.85em; color:#666;">
                            Vata: <?php echo $result['vata_percentage']; ?>% | 
                            Pitta: <?php echo $result['pitta_percentage']; ?>% | 
                            Kapha: <?php echo $result['kapha_percentage']; ?>%
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge <?php echo $badgeFormat; ?>"><?php echo ucfirst($dom); ?></span>
                        <div style="font-size:0.8em; color:#999; margin-top:8px;">
                            <?php echo date('M j, Y g:i A', strtotime($result['created_at'])); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You haven't taken any quizzes yet.</p>
            <?php endif; ?>
        </div>

        <div id="health-rec" class="tab-content">
            <h3>Ayurvedic Recommendations</h3>
            <?php if($latest): ?>
                <p>Based on your latest result (<strong><?php echo ucfirst($latest['dominant_dosha']); ?></strong> dominant), here are some tips:</p>
                
                <?php if(strtolower($latest['dominant_dosha']) == 'vata'): ?>
                    <div style="padding:15px; background:#eef6fc; border-radius:8px; margin-bottom:15px;">
                        <strong>🥑 Diet:</strong> Favor warm, moist, heavy foods like soups, stews, and root vegetables. Use warming spices like ginger and cinnamon.
                    </div>
                    <div style="padding:15px; background:#eef6fc; border-radius:8px;">
                        <strong>🧘 Lifestyle:</strong> Maintain a regular daily routine. Do gentle exercises like yoga and walking. Avoid cold wind and extreme stress.
                    </div>
                <?php elseif(strtolower($latest['dominant_dosha']) == 'pitta'): ?>
                    <div style="padding:15px; background:#fdf3f0; border-radius:8px; margin-bottom:15px;">
                        <strong>🥗 Diet:</strong> Favor cool, refreshing, and sweet foods like cucumbers, melons, and leafy greens. Avoid spicy, oily, and fried foods.
                    </div>
                    <div style="padding:15px; background:#fdf3f0; border-radius:8px;">
                        <strong>🧘 Lifestyle:</strong> Avoid overworking and heat exposure. Spend time in nature, near water if possible. Practice moderation.
                    </div>
                <?php else: ?>
                    <div style="padding:15px; background:#f0f9f4; border-radius:8px; margin-bottom:15px;">
                        <strong>🍏 Diet:</strong> Favor light, dry, and warm foods. Eat plenty of vegetables and bitter/astringent greens. Avoid excessive sweets and dairy.
                    </div>
                    <div style="padding:15px; background:#f0f9f4; border-radius:8px;">
                        <strong>🧘 Lifestyle:</strong> Seek regular vigorous exercise. Try new things to break routine. Wake up early and avoid daytime sleeping.
                    </div>
                <?php endif; ?>
                
                <div style="margin-top:20px;">
                    <a href="recommendations.php" style="color:#5aaa80; text-decoration:none; font-weight:600;">View Full Recommendations &rarr;</a>
                </div>
            <?php else: ?>
                <p>Discover your dosha first to get personalized recommendations.</p>
                <a href="dosha-quiz.php" class="badge badge-kapha" style="text-decoration:none;">Take Dosha Quiz</a>
            <?php endif; ?>
        </div>
    </main>
</div>

<script>
function switchTab(tabId) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    
    event.target.classList.add('active');
    document.getElementById(tabId).classList.add('active');
}
</script>
<?php } ?>
HTML;

$finalHtml = $headerHtml . "\n" . $profileContent . "\n" . $footerHtml;

file_put_contents('profile.php', $finalHtml);
echo "profile.php generated successfully.\n";
