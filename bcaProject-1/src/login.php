<?php
include 'connection.php';
session_start();

// When you press the "Login" button...
if (isset($_POST['login'])) {
    // We get your email and secret password!
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // If you forgot to type something, we say "Oops, fill it all!"
    if (empty($email) || empty($password)) {
        // If one of the boxes is empty, we can't open the door!
        $error = "Please fill all fields";
    } else {
        // We look in our treasure box for your name!
        $sql = "SELECT * FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if (password_verify($password, $row['password'])) {
                // If the key fits, we let you in!
                $_SESSION['user'] = $row['username'];

                // --- STREAK LOGIC START ---
                // We give you shiny points if you visit us every day!
                $u_id = $row['id'];
                $today = date('Y-m-d');
                $yesterday = date('Y-m-d', strtotime('-1 day'));
                $last_active = $row['last_active_date'] ?? null;

                if ($last_active != $today) {
                    if ($last_active == $yesterday) {
                        // If you came yesterday too, you get 10 trophy points!
                        // It's like being a star student who never misses a day!
                        $streak_update_sql = "UPDATE users SET streak_count = streak_count + 1, points = points + 10, last_active_date = '$today' WHERE id = '$u_id'";
                    } else {
                        // If you forgot or it's your first time, we start from 1!
                        $streak_update_sql = "UPDATE users SET streak_count = 1, points = points + 10, last_active_date = '$today' WHERE id = '$u_id'";
                    }
                    mysqli_query($conn, $streak_update_sql);
                }
                // --- STREAK LOGIC END ---

                // --- SYNC GUEST CART TO DB ---
                // If you picked toys before logging in, we move them to your big treasure box!
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $pid => $qty) {
                        $pid = mysqli_real_escape_string($conn, $pid);
                        $qty = (int) $qty;

                        // Check if you already have this toy in your box...
                        $check_cart = mysqli_query($conn, "SELECT id FROM cart WHERE user_id='$u_id' AND product_id='$pid'");
                        if (mysqli_num_rows($check_cart) > 0) {
                            // If yes, we just add more to the pile!
                            mysqli_query($conn, "UPDATE cart SET quantity = quantity + $qty WHERE user_id='$u_id' AND product_id='$pid'");
                        } else {
                            // If no, we put the new toy in!
                            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$u_id', '$pid', '$qty')");
                        }
                    }
                }

                // --- PERSISTENT CART RESTORE FROM DB ---
                // We look in your box and bring out all your favorite toys!
                $_SESSION['cart'] = []; // Clear and rebuild to ensure consistency
                $cart_res = mysqli_query($conn, "SELECT product_id, quantity FROM cart WHERE user_id='$u_id'");
                if ($cart_res) {
                    while ($c_row = mysqli_fetch_assoc($cart_res)) {
                        $pid = $c_row['product_id'];
                        $qty = $c_row['quantity'];
                        // We put each toy back into your session pocket!
                        $_SESSION['cart'][$pid] = $qty;
                    }
                }
                // --- PERSISTENT CART RESTORE END ---

                if (isset($_GET['redirect'])) {
                    $redirect_url = $_GET['redirect'];
                    // Simple validation to ensure it's a relative path on same domain
                    if (strpos($redirect_url, 'http') === false) {
                        header("Location: " . $redirect_url);
                        exit();
                    }
                }

                header("Location: HomePage.php");
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ayurvedic Health Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('C:/Users/ghimi/.gemini/antigravity/brain/3853c120-d35b-4eca-96e4-3f732151e6bd/ayurvedic_auth_bg_1766485085804.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            z-index: 1;
        }

        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 50px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-container h2 {
            text-align: center;
            color: #fff;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            letter-spacing: 1px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .auth-form .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .auth-form .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .auth-form input {
            width: 100%;
            padding: 15px 15px 15px 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            outline: none;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .auth-form input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .auth-form input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .auth-form button {
            width: 100%;
            padding: 15px;
            background: #2d6a4f;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 10px;
            box-shadow: 0 8px 25px rgba(27, 67, 50, 0.3);
        }

        .auth-form button:hover {
            background: #40916c;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(27, 67, 50, 0.4);
        }

        .error-msg {
            background: rgba(230, 57, 70, 0.2);
            color: #ffb3b3;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
            border: 1px solid rgba(230, 57, 70, 0.3);
            font-size: 0.9rem;
        }

        .auth-links {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .auth-links a {
            color: #95d5b2;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .auth-links a:hover {
            color: #d8f3dc;
            text-decoration: underline;
        }

        .home-link {
            position: absolute;
            top: 30px;
            left: 30px;
            color: #fff;
            text-decoration: none;
            z-index: 10;
            font-size: 1.1rem;
            font-weight: 500;
            transition: 0.3s;
        }

        .home-link:hover {
            opacity: 0.8;
            transform: translateX(-5px);
        }
    </style>
</head>

<body>
    <a href="HomePage.php" class="home-link"><i class="fas fa-arrow-left me-2"></i> Back to Home</a>

    <div class="auth-container">
        <h2>Welcome Back</h2>
        <?php if (isset($error))
            echo "<div class='error-msg'>$error</div>"; ?>

        <!-- This is our "Knock Knock" box (Form) to enter the clubhouse! -->
        <form class="auth-form" method="POST">
            <div class="input-group">
                <!-- Type your letter-box address (email) here! -->
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <!-- Type your secret secret password here! -->
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <!-- Press this button to walk through the door! -->
            <button type="submit" name="login">Login Now</button>
        </form>

        <div class="auth-links">
            <p>Don't have an account? <a href="register.php">Create Account</a></p>
        </div>
    </div>
</body>

</html>