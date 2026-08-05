<?php
// We tell the computer to remember who we are!
session_start();
// We open the secret pipe to the treasure box!
include 'connection.php';

// If the computer doesn't know you, it sends you to the "Who are you?" door!
if (!isset($_SESSION['user'])) {
    // If we don't know you, we can't let you buy toys!
    header("Location: login.php?msg=Please login to checkout");
    exit();
}

// If your shopping bag is empty, we go back to the toy shop!
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    // We can't buy nothing! Let's go pick a toy!
    header("Location: HomePage.php");
    exit();
}

// 1. Let's do the "Magic Math" to see how many rupees we need!
$total = 0;
foreach ($_SESSION['cart'] as $id => $quantity) {
    // We look at the price tag for each toy in our bag!
    $res = mysqli_query($conn, "SELECT price FROM products WHERE id='$id'");
    $product = mysqli_fetch_assoc($res);
    // Add up all the coins!
    $total += ($product['price'] ?? 0) * $quantity;
}

// Note: Order is now inserted in payment_success.php ONLY after verification.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Ayurvedic Health Portal</title>
    <link rel="stylesheet" href="style.css?v=2.0">
    <style>
        .checkout-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 50px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .payment-option-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border: 2px solid #2d6a4f;
            border-radius: 12px;
            cursor: pointer;
            background: #f0fdf4;
            transition: 0.3s;
        }

        .payment-logo {
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <h2>Finalize Your Order</h2>
        <!-- This is the "Final Order Paper" (Summary)! -->
        <div style="text-align: left; margin: 20px 0; padding: 20px; background: #f8faf9; border-radius: 10px;">
            <h3 style="color: #1b4332;">Order Summary</h3>
            <!-- How many toys are we taking home? -->
            <p>Total Items: <?php echo array_sum($_SESSION['cart']); ?></p>
            <!-- The total amount of money we need! -->
            <p><strong>Grand Total: Rs. <?php echo number_format($total, 2); ?></strong></p>
        </div>

        <!-- This is the "Piggy Bank" form (eSewa) to pay your coins! -->
        <form action="esewa_process.php" method="POST">
            <h3 style="text-align: left; color: #1b4332; margin-bottom: 15px;">Payment Method:</h3>

            <div style="margin-bottom: 30px;">
                <label class="payment-option-card">
                    <!-- We pick the "Magic Wallet" (eSewa) to pay! -->
                    <input type="radio" name="payment_method" value="esewa" checked required style="display: none;">
                    <img src="https://esewa.com.np/common/images/esewa_logo.png" alt="eSewa" class="payment-logo">
                    <div>
                        <strong>Pay via eSewa Secure API</strong>
                        <p style="font-size: 0.8rem; color: #666; margin: 0;">Instant & Secure Mobile Wallet</p>
                    </div>
                </label>
            </div>

            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
            <!-- Press this big button to send your coins! -->
            <button type="submit" name="proceed_payment" class="search-btn" style="width: 100%;">Proceed to eSewa
                Payment</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="cart.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">← Back to Cart</a>
        </div>
    </div>
</body>

</html>