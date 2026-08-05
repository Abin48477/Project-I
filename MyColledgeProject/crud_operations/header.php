<?php
// We tell the computer to remember who we are!
session_start();
// We open the secret pipe to the treasure box!
include("../src/connection.php");

// We check if you are the big boss (admin) allowed in this secret room!
if (!isset($_SESSION['user'])) {
    // If you aren't signed in, go back to the front door!
    header("Location: ../src/login.php");
    exit();
}

$username = $_SESSION['user'];
$user_check = mysqli_query($conn, "SELECT role FROM users WHERE username='$username'");
$user_role = mysqli_fetch_assoc($user_check)['role'];

if ($user_role !== 'admin') {
    // If you aren't the boss, you can't come in here!
    header("Location: ../src/HomePage.php?error=access_denied");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <div class="d-flex justify-content-between align-items-center mt-3 px-3">
        <!-- The big sign for the grown-up's room! -->
        <h1 id="main-title" class="mb-0">BOSS'S DESK</h1>
        <div class="nav-links d-flex gap-2">
            <!-- Button to see the "Control Center" -->
            <a href="dashboard.php" class="btn btn-outline-primary">Dashboard</a>
            <!-- Button to see all the "Products on Shelf" -->
            <a href="index.php" class="btn btn-outline-primary">Products</a>
            <!-- Button to add a brand new product! -->
            <a href="add_product.php" class="btn btn-success"><i class="fas fa-plus-circle me-1"></i> Add Product</a>
            <!-- Button to see the "Big Sell Book" -->
            <a href="orders.php" class="btn btn-outline-primary">Orders</a>
            <!-- Button to see "Secret Whispers" -->
            <a href="messages.php" class="btn btn-outline-primary">Whispers</a>
            <!-- Button to make a backup copy of the treasure book! -->
            <a href="../src/backup_db.php" class="btn btn-warning"><i class="fas fa-database me-1"></i> Backup Book</a>
            <!-- Button to walk back to the front of the house! -->
            <a href="../src/HomePage.php" class="btn btn-secondary">Go Home</a>
        </div>
    </div>
    <div class="container mt-3">