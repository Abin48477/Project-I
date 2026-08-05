<?php
// We tell the computer to remember our shopping bag today!
session_start();
// We open the secret pipe to the treasure box!
include 'connection.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // We check if we already have a shopping bag. If not, we make a new one!
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // If this toy is already in our bag, we add one more!
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        // If it's a new toy, we put the first one in!
        $_SESSION['cart'][$product_id] = 1;
    }

    // [AUTHENTICATION CHECK] Redirect if not logged in
    if (!isset($_SESSION['user'])) {
        // If you don't have a name tag, we go to the "Who are you?" door (Login)!
        $redirect_to = "add_to_cart.php?id=$product_id&checkout=1";
        header("Location: login.php?redirect=" . urlencode($redirect_to));
        exit();
    }

    // If you have a name tag (are logged in), we save your bag in the clubhouse!
    if (isset($_SESSION['user'])) {
        $username = mysqli_real_escape_string($conn, $_SESSION['user']);

        // We find your secret name tag in the big book of members!
        $u_res = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
        if ($u_res && $u_row = mysqli_fetch_assoc($u_res)) {
            $user_id = $u_row['id'];
            $qty = (int) $_SESSION['cart'][$product_id];
            $safe_product_id = mysqli_real_escape_string($conn, $product_id);

            // We check if this toy is already on your shelf in the clubhouse!
            $chk_sql = "SELECT id FROM cart WHERE user_id='$user_id' AND product_id='$safe_product_id'";
            $chk = mysqli_query($conn, $chk_sql);

            if ($chk) {
                if (mysqli_num_rows($chk) > 0) {
                    // Update: Put more of the same toy on the shelf!
                    mysqli_query($conn, "UPDATE cart SET quantity='$qty' WHERE user_id='$user_id' AND product_id='$safe_product_id'");
                } else {
                    // Insert: Put a brand new toy on the shelf!
                    mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$safe_product_id', '$qty')");
                }
            } else {
                // Oops! The shelf is broken!
                error_log("Cart query failed: " . mysqli_error($conn));
                header("Location: HomePage.php?error=Database error. Please run migrate_cart.php");
                exit();
            }
        }
    }

    if (isset($_GET['checkout']) && $_GET['checkout'] == '1') {
        // We go straight to the coin-counting desk (Checkout)!
        header("Location: checkout.php");
    } else {
        // We go back to the toy shop and say "Yippee, toy added!"
        header("Location: HomePage.php?msg=Product added to cart");
    }
    exit();
} else {
    header("Location: HomePage.php");
    exit();
}
?>