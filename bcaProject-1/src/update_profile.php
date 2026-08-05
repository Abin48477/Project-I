<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

function addColumnIfNeeded($conn, $table, $column, $definition)
{
    $safeTable = mysqli_real_escape_string($conn, $table);
    $safeColumn = mysqli_real_escape_string($conn, $column);
    $check = mysqli_query($conn, "SHOW COLUMNS FROM `$safeTable` LIKE '$safeColumn'");
    if ($check && mysqli_num_rows($check) === 0) {
        mysqli_query($conn, "ALTER TABLE `$safeTable` ADD COLUMN `$safeColumn` $definition");
    }
}

addColumnIfNeeded($conn, 'users', 'full_name', "VARCHAR(100) NULL");
addColumnIfNeeded($conn, 'users', 'age', "INT NULL");
addColumnIfNeeded($conn, 'users', 'gender', "VARCHAR(30) NULL");
addColumnIfNeeded($conn, 'users', 'height_cm', "DECIMAL(5,2) NULL");
addColumnIfNeeded($conn, 'users', 'weight_kg', "DECIMAL(5,2) NULL");
addColumnIfNeeded($conn, 'users', 'waist_cm', "DECIMAL(5,2) NULL");
addColumnIfNeeded($conn, 'users', 'profile_image', "VARCHAR(255) NULL");

$username = mysqli_real_escape_string($conn, $_SESSION['user']);
$userRes = mysqli_query($conn, "SELECT id, profile_image FROM users WHERE username='$username' LIMIT 1");
if (!$userRes || mysqli_num_rows($userRes) === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

$user = mysqli_fetch_assoc($userRes);
$userId = (int)$user['id'];
$existingProfileImage = $user['profile_image'] ?? '';

$fullName = trim((string)($_POST['full_name'] ?? ''));
$age = isset($_POST['age']) ? (int)$_POST['age'] : null;
$gender = trim((string)($_POST['gender'] ?? ''));
$heightCm = isset($_POST['height_cm']) ? (float)$_POST['height_cm'] : null;
$weightKg = isset($_POST['weight_kg']) ? (float)$_POST['weight_kg'] : null;
$waistCm = isset($_POST['waist_cm']) ? (float)$_POST['waist_cm'] : null;

if ($age !== null && ($age < 1 || $age > 120)) {
    echo json_encode(['success' => false, 'message' => 'Invalid age']);
    exit;
}

if ($heightCm !== null && ($heightCm < 50 || $heightCm > 250)) {
    echo json_encode(['success' => false, 'message' => 'Invalid height']);
    exit;
}

if ($weightKg !== null && ($weightKg < 20 || $weightKg > 300)) {
    echo json_encode(['success' => false, 'message' => 'Invalid weight']);
    exit;
}

if ($waistCm !== null && ($waistCm < 20 || $waistCm > 250)) {
    echo json_encode(['success' => false, 'message' => 'Invalid waist']);
    exit;
}

$profileImagePath = $existingProfileImage;
if (!empty($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Image upload failed']);
        exit;
    }

    if ($_FILES['profile_image']['size'] > 3 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Image must be <= 3MB']);
        exit;
    }

    $tmpPath = $_FILES['profile_image']['tmp_name'];
    $imageInfo = @getimagesize($tmpPath);
    if ($imageInfo === false) {
        echo json_encode(['success' => false, 'message' => 'Only image files are allowed']);
        exit;
    }

    $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed, true)) {
        echo json_encode(['success' => false, 'message' => 'Allowed formats: jpg, jpeg, png, webp']);
        exit;
    }

    $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'full_imageContainer' . DIRECTORY_SEPARATOR . 'profile_uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = 'user_' . $userId . '_' . time() . '.' . $ext;
    $destPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
    if (!move_uploaded_file($tmpPath, $destPath)) {
        echo json_encode(['success' => false, 'message' => 'Could not save image']);
        exit;
    }

    $profileImagePath = '../full_imageContainer/../profile_uploads/' . $fileName;
}

$fullNameEsc = mysqli_real_escape_string($conn, $fullName);
$genderEsc = mysqli_real_escape_string($conn, $gender);
$imageEsc = mysqli_real_escape_string($conn, $profileImagePath);
$ageSql = ($age !== null && $age > 0) ? (string)$age : "NULL";
$heightSql = ($heightCm !== null && $heightCm > 0) ? (string)$heightCm : "NULL";
$weightSql = ($weightKg !== null && $weightKg > 0) ? (string)$weightKg : "NULL";
$waistSql = ($waistCm !== null && $waistCm > 0) ? (string)$waistCm : "NULL";

$updateSql = "
    UPDATE users
    SET
        full_name = '$fullNameEsc',
        age = $ageSql,
        gender = '$genderEsc',
        height_cm = $heightSql,
        weight_kg = $weightSql,
        waist_cm = $waistSql,
        profile_image = '$imageEsc'
    WHERE id = $userId
";

if (!mysqli_query($conn, $updateSql)) {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile: ' . mysqli_error($conn)]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Profile saved',
    'profile' => [
        'full_name' => $fullName,
        'age' => $age,
        'gender' => $gender,
        'height_cm' => $heightCm,
        'weight_kg' => $weightKg,
        'waist_cm' => $waistCm,
        'profile_image' => $profileImagePath
    ]
]);

