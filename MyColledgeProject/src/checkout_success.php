<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Ayurvedic Health Portal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-page {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="success-page">
        <!-- A big celebration sticker! -->
        <div style="font-size: 80px;">🎨</div>
        <!-- This is our "Yippee!" sign because the coin counter worked! -->
        <h1 style="color: #1b4332;">We Got the Coins!</h1>
        <!-- Every order has its own special number, like a name! -->
        <p>Thank you for your order <strong>#<?php echo $_GET['order_id']; ?></strong>.</p>
        <!-- We are busy making your magic toys and potions right now! -->
        <p>We are preparing your herbal remedies. You will receive an update soon.</p>
        <br>
        <!-- This takes you back to the front porch of our shop! -->
        <a href="HomePage.php" class="search-btn" style="text-decoration: none;">Go Home and Play</a>
    </div>
</body>

</html>