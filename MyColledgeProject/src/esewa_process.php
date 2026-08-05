<?php
// We tell the computer to remember your name tag while you pay!
session_start();

if (!isset($_POST['proceed_payment'])) {
    header("Location: checkout.php");
    exit();
}

// we check how many coins we need to take from your piggy bank!
$amount = $_POST['total_amount'];
$tax_amount = 0;
// We add them up to get the final total!
$total_amount = $amount + $tax_amount;

// We make sure the number of coins is a plain word the piggy bank understands!
$total_amount_str = strval($total_amount);

// This is like a secret code for the transaction!
$transaction_uuid = uniqid() . "-" . time(); 
// This is the name of our special shop!
$product_code = "EPAYTEST";
// This is the secret key to open the piggy bank!
$secret = "8gBm/:&EnhH.1/q";

// Success and Failure URLs: These are the paths to the "Happy Room" or the "Oops Room"!
$success_url = "http://localhost/MyColledgeProject/payment_success.php";
$failure_url = "http://localhost/MyColledgeProject/payment_failure.php";

// This is our secret signature so the piggy bank knows it's really us!
$s_string = "total_amount=$total_amount_str,transaction_uuid=$transaction_uuid,product_code=$product_code";
$signature = base64_encode(hash_hmac('sha256', $s_string, $secret, true));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Redirecting to eSewa...</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            padding-top: 100px;
            background: #f0fdf4;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #2d6a4f;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<!-- This is the spinning wheel you see while the piggy bank opens! -->
<body onload="document.getElementById('esewa_form').submit();">
    <div class="loader"></div>
    <h3>Going to the eSewa Piggy Bank...</h3>
    <p>Please wait a tiny bit!</p>

    <!-- This is a secret form that sends all the coins and codes to eSewa! -->
    <form id="esewa_form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
        <input type="hidden" name="tax_amount" value="<?php echo $tax_amount; ?>">
        <input type="hidden" name="total_amount" value="<?php echo $total_amount_str; ?>">
        <input type="hidden" name="transaction_uuid" value="<?php echo $transaction_uuid; ?>">
        <input type="hidden" name="product_code" value="<?php echo $product_code; ?>">
        <input type="hidden" name="product_service_charge" value="0">
        <input type="hidden" name="product_delivery_charge" value="0">
        <input type="hidden" name="success_url" value="<?php echo $success_url; ?>">
        <input type="hidden" name="failure_url" value="<?php echo $failure_url; ?>">
        <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
        <input type="hidden" name="signature" value="<?php echo $signature; ?>">
    </form>
</body>

</html>