<?php
// We tell the computer to remember our shopping bag!
session_start();
// We open the secret pipe to the treasure box!
include 'connection.php';

// If we want to take a toy out or clean the whole bag!
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'remove' && isset($_GET['id'])) {
        // We take one specific toy out of the bag!
        $id_to_remove = $_GET['id'];
        unset($_SESSION['cart'][$id_to_remove]);

        // [PERSISTENT CART] We also tell the treasure box to forget about it!
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
            $u_res = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
            if ($u_row = mysqli_fetch_assoc($u_res)) {
                $uid = $u_row['id'];
                mysqli_query($conn, "DELETE FROM cart WHERE user_id='$uid' AND product_id='$id_to_remove'");
            }
        }
    } elseif ($_GET['action'] == 'clear') {
        // We empty the whole bag at once!
        unset($_SESSION['cart']);

        // [PERSISTENT CART] We tell the treasure box the bag is empty!
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
            $u_res = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
            if ($u_row = mysqli_fetch_assoc($u_res)) {
                $uid = $u_row['id'];
                mysqli_query($conn, "DELETE FROM cart WHERE user_id='$uid'");
            }
        }
    }
    header("Location: cart.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Ayurvedic Health Portal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .cart-table th {
            color: #1b4332;
            font-weight: 700;
        }

        .cart-total {
            text-align: right;
            font-size: 20px;
            font-weight: 700;
            color: #1b4332;
        }

        .checkout-btn {
            display: inline-block;
            background: #1b4332;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            float: right;
            margin-top: 20px;
            transition: 0.3s;
        }

        .checkout-btn:hover {
            background: #2d6a4f;
            transform: translateY(-2px);
        }

        .empty-cart {
            text-align: center;
            padding: 50px;
        }

        .empty-cart a {
            color: #2d6a4f;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <h1 data-i18n="cartTitle">Your Cart</h1>

        <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <p class="empty-cart" data-i18n="emptyCart">Your cart is empty.</p>
                <a href="HomePage.php">← Back to Shopping</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th data-i18n="cartProduct">Product</th>
                        <th data-i18n="cartPrice">Price</th>
                        <th data-i18n="cartQuantity">Quantity</th>
                        <th data-i18n="cartSubtotal">Subtotal</th>
                        <th data-i18n="cartAction">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // We look at every toy in our bag and count the gold coins!
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $quantity) {
                        // We find the toy's picture and name in the treasure box!
                        $res = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
                        $product = mysqli_fetch_assoc($res);
                        // We do magic math to find the price for all these toys!
                        $subtotal = $product['price'] * $quantity;
                        $total += $subtotal;
                        ?>
                        <tr>
                            <!-- We show the toy name! -->
                            <td><?php echo $product['name']; ?></td>
                            <!-- We show how many coins for one! -->
                            <td>Rs. <?php echo number_format($product['price'], 2); ?></td>
                            <!-- We show how many you picked! -->
                            <td><?php echo $quantity; ?></td>
                            <!-- We show the big total for this toy! -->
                            <td>Rs. <?php echo number_format($subtotal, 2); ?></td>
                            <!-- A button to say "I don't want this toy anymore!" -->
                            <td><a href="cart.php?action=remove&id=<?php echo $id; ?>" style="color: #e63946;">Remove</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="cart-total">
                <p><strong>Total: Rs. <?php echo number_format($total, 2); ?></strong></p>
            </div>

            <a href="cart.php?action=clear" style="color: #666; text-decoration: none;">Clear Cart</a>
            <a href="checkout.php" class="checkout-btn" data-i18n="btnCheckout">Proceed to Checkout</a>
            <div style="clear: both;"></div>
        <?php endif; ?>
    </div>
</body>

</html>