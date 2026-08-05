<?php
// We open the secret pipe to the treasure box!
include("connection.php");
// We tell the computer to remember who is in charge!
session_start();

// We check if you are the big boss (admin)!
if (!isset($_SESSION['user'])) {
    // If you aren't signed in, go back to the start!
    header("Location: ../src/login.php");
    exit();
}
$username = $_SESSION['user'];
$user_check = mysqli_query($conn, "SELECT role FROM users WHERE username='$username'");
$user_role = mysqli_fetch_assoc($user_check)['role'];
if ($user_role !== 'admin') {
    // Only the big boss can add new products!
    header("Location: ../src/HomePage.php?error=access_denied");
    exit();
}

// If we send the "Add" letter...
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['add_students']) || isset($_POST['productName']))) {

    // We read the name, price, and picture of the new product!
    $productName = mysqli_real_escape_string($conn, trim($_POST['productName']));
    $price = mysqli_real_escape_string($conn, trim($_POST['price']));
    $image = mysqli_real_escape_string($conn, trim($_POST['image']));

    // --- We check if you forgot any details or made a mistake! ---
    $errors = [];

    if (empty($productName)) {
        $errors[] = "You forgot the product name!";
    }

    if (empty($price)) {
        $errors[] = "You forgot how many coins it costs!";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors[] = "The price must be a happy positive number!";
    }

    if (empty($image)) {
        $errors[] = "You forgot to add an image URL!";
    }

    // If there ARE mistakes, we go back and tell you!
    if (!empty($errors)) {
        // We join the errors together into one string
        $error_msg = implode(" ", $errors);
        header('Location:add_product.php?message=' . urlencode($error_msg));
        exit();
    } else {
        // We tell the treasure box to "Put this new product on the shelf!"
        $query = "INSERT INTO products (name, price, image) VALUES ('$productName', '$price', '$image')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            // If the shelf is full or broken, we show an error!
            die("Query Failed: " . mysqli_error($conn));
        } else {
            // We go back to the list and say "New product added!"
            header('Location:index.php?insert_msg=Product added successfully');
            exit();
        }
    }
}
?>