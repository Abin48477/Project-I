<?php
// We tell the computer to remember our name tag!
session_start();
// We open the secret pipe to the treasure box!
include 'connection.php';

// We check if the piggy bank sent back a secret code!
if (!isset($_GET['data'])) {
    header("Location: HomePage.php");
    exit();
}

// We decode the secret message from the piggy bank!
$data = $_GET['data'];
$decoded_data = json_decode(base64_decode($data), true);

// If the piggy bank says "No", we show the "Oops" screen!
if (!$decoded_data || $decoded_data['status'] !== 'COMPLETE') {
    header("Location: payment_failure.php");
    exit();
}

// We send a secret whisper back to the piggy bank to make sure it's really real!
$product_code = "EPAYTEST";
$total_amount = $decoded_data['total_amount'];
$transaction_uuid = $decoded_data['transaction_uuid'];

// This is the secret path to the piggy bank's verification room!
$url = "https://rc-epay.esewa.com.np/api/epay/transaction/status/?product_code=$product_code&total_amount=$total_amount&transaction_uuid=$transaction_uuid";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$res_data = json_decode($response, true);

// If the piggy bank says "Yes, I have the coins!"...
if ($res_data && $res_data['status'] === 'COMPLETE') {
    // TRANSACTION VERIFIED! Now create the order.

    // We need the user identity first to rebuild cart if the session cart vanished during redirect
    if (!isset($_SESSION['user'])) {
        echo "<h2>Session Expired</h2><p>Your payment was successful (Ref: " . $decoded_data['transaction_code'] . "), but we couldn't identify your account. Please contact support.</p>";
        exit();
    }

    $username = $_SESSION['user'];
    $user_res = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    $user_data = mysqli_fetch_assoc($user_res);

    if (!$user_data) {
        echo "<h2>Session Expired</h2><p>Your payment was successful (Ref: " . $decoded_data['transaction_code'] . "), but we couldn't verify your account. Please contact support.</p>";
        exit();
    }

    $user_id = $user_data['id'];
    $transaction_code = $decoded_data['transaction_code'];

    // Try to recover cart from database if the session cart is missing
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $cart_res = mysqli_query($conn, "SELECT product_id, quantity FROM cart WHERE user_id='$user_id'");
        if ($cart_res && mysqli_num_rows($cart_res) > 0) {
            $_SESSION['cart'] = [];
            while ($c_row = mysqli_fetch_assoc($cart_res)) {
                $_SESSION['cart'][$c_row['product_id']] = (int) $c_row['quantity'];
            }
        } else {
            echo "<h2>Session Expired</h2><p>Your payment was successful (Ref: " . $decoded_data['transaction_code'] . "), but we couldn't retrieve your cart. Please contact support.</p>";
            exit();
        }
    }

    // We start a secret counting session in our treasure box!
    // It's like locking the door while we count the coins!
    mysqli_begin_transaction($conn);

    try {
        // We write down your big order in our "Hall of Fame" (orders table)!
        $insert_order = "INSERT INTO orders (user_id, total_amount, payment_method, payment_status, transaction_id) 
                        VALUES ('$user_id', '$total_amount', 'esewa', 'paid', '$transaction_code')";

        if (!mysqli_query($conn, $insert_order))
            throw new Exception(mysqli_error($conn));

        $order_id = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $p_id => $quantity) {
            $p_res = mysqli_query($conn, "SELECT price FROM products WHERE id='$p_id'");
            $product = mysqli_fetch_assoc($p_res);
            $price = $product['price'];

            $insert_item = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES ('$order_id', '$p_id', '$quantity', '$price')";
            if (!mysqli_query($conn, $insert_item))
                throw new Exception(mysqli_error($conn));
        }

        // We finish the transaction and wave our magic wand!
        mysqli_commit($conn);
        // We empty your shopping bag because you have the toys now!
        unset($_SESSION['cart']);
        mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

        // Show Success Page
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <title>Order Success - Ayurvedic Health Portal</title>
            <link rel="stylesheet" href="style.css?v=2.0">
            <style>
                .success-container {
                    max-width: 600px;
                    margin: 100px auto;
                    padding: 50px;
                    background: #fff;
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }

                .success-icon {
                    font-size: 60px;
                    color: #2d6a4f;
                    margin-bottom: 20px;
                }
            </style>
        </head>

        <body>
            <div class="success-container">
                <!-- A big green check mark sticker! -->
                <div class="success-icon">✅</div>
                <h2>Yay! Your toys are coming!</h2>
                <p>The piggy bank gave us the coins!</p>
                <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: left;">
                    <p><strong>Order ID:</strong> #
                        <?php echo $order_id; ?>
                    </p>
                    <p><strong>Transaction ID:</strong>
                        <?php echo $transaction_code; ?>
                    </p>
                    <p><strong>Amount Paid:</strong> Rs.
                        <?php echo number_format($total_amount, 2); ?>
                    </p>
                </div>
                <a href="HomePage.php" class="search-btn" style="text-decoration: none;">Return to Home</a>
            </div>
        </body>

        </html>
        <?php
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<h2>Error</h2><p>Failed to create order: " . $e->getMessage() . "</p>";
    }
} else {
    header("Location: payment_failure.php");
}
?>
