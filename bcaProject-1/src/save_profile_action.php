<?php
// We open the secret pipe to the treasure box!
include 'connection.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

// Get user ID first
$user_res = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_res);
$user_id = $user['id'];

// Get data from the form
$full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
$age = (int)$_POST['age'];
$height = (float)$_POST['height'];
$weight = (float)$_POST['weight'];
$waist = (float)$_POST['waist'];

// --- MAGIC MATH STARTS HERE ---

// 1. BMI Calculation (Weight / Height^2 in meters)
$height_m = $height / 100;
$bmi = ($height_m > 0) ? round($weight / ($height_m * $height_m), 1) : 0;

// 2. WHTR Calculation (Waist / Height)
$whtr = ($height > 0) ? round($waist / $height, 2) : 0;

// 3. Health Score Logic (Simple Fun Game!)
$score = 80;
if ($bmi < 18.5 || $bmi > 24.9) $score -= 5;
if ($whtr > 0.5) $score -= 5;
if ($age > 45) $score -= 2;
if ($score < 0) $score = 0;

// --- SAVE TO THE TREASURE BOX ---

// Check if we already have a profile piece for this friend
$check_sql = "SELECT id FROM profiles WHERE user_id = '$user_id'";
$check_res = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_res) > 0) {
    // Update existing profile
    $sql = "UPDATE profiles SET 
            full_name = '$full_name',
            age = '$age',
            height = '$height',
            weight = '$weight',
            waist = '$waist',
            bmi = '$bmi',
            whtr = '$whtr',
            health_score = '$score'
            WHERE user_id = '$user_id'";
} else {
    // Insert new profile
    $sql = "INSERT INTO profiles (user_id, full_name, age, height, weight, waist, bmi, whtr, health_score) 
            VALUES ('$user_id', '$full_name', '$age', '$height', '$weight', '$waist', '$bmi', '$whtr', '$score')";
}

if (mysqli_query($conn, $sql)) {
    // Also update the main users table for name if needed
    mysqli_query($conn, "UPDATE users SET full_name = '$full_name' WHERE id = '$user_id'");
    
    // Success! Go back to the profile room!
    header("Location: profile.php?msg=saved");
} else {
    echo "Oops! The treasure box wouldn't open: " . mysqli_error($conn);
}
?>
