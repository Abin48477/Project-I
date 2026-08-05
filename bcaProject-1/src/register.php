<?php
include 'connection.php';
session_start();

// When you press the "Register" button to join our team...
if (isset($_POST['register'])) {
    // We get your nickname, email, and a secret password!
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // We check if you typed the same secret code twice!
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // If you forgot a box, we say "Oops, fill it all!"
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If your email looks funny, we say it's not a real one!
        $error = "Invalid email format";
    } elseif ($password !== $confirm_password) {
        // If your passwords don't match, we say they are not twins!
        $error = "Passwords do not match";
    } else {
        // We scramble your password to keep it super secret!
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // We check if someone else already has your name or email!
        $check_user = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $res = mysqli_query($conn, $check_user);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            // If someone already has your name, we say "Pick another one!"
            if ($row['username'] === $username) {
                $error = "Username already exists";
            } else {
                // If someone already uses that mail-box, we say "Try a different one!"
                $error = "Email already registered";
            }
        } else {
            $today = date('Y-m-d');
            // We put your info into the treasure box and give you 10 starter points!
            // It's like a "Hello Friend" gift from the clubhouse!
            $sql = "INSERT INTO users (username, email, password, role, points, streak_count, last_active_date) 
                    VALUES ('$username', '$email', '$hashed_password', 'user', 10, 1, '$today')";
            if (mysqli_query($conn, $sql)) {
                // We find out your unique friend-number (ID)!
                $u_id = mysqli_insert_id($conn);
                $_SESSION['user'] = $username;

                // If you picked toys (products) before joining, we put them in your box!
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $pid => $qty) {
                        $pid = mysqli_real_escape_string($conn, $pid);
                        $qty = (int) $qty;
                        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$u_id', '$pid', '$qty')");
                    }
                }

                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ayurvedic Health Portal</title>
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
            padding: 40px 50px;
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
            margin-bottom: 25px;
            letter-spacing: 1px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .auth-form .input-group {
            position: relative;
            margin-bottom: 20px;
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
            padding: 14px 15px 14px 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            outline: none;
            transition: all 0.3s;
            font-size: 0.95rem;
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
            margin-top: 5px;
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
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            border: 1px solid rgba(230, 57, 70, 0.3);
            font-size: 0.85rem;
        }

        .auth-links {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
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
        <h2>Create Account</h2>
        <?php if (isset($error))
            echo "<div class='error-msg'>$error</div>"; ?>

        <!-- This is the "Join the Secret Clubhouse" form! -->
        <form class="auth-form" method="POST">
            <div class="input-group">
                <!-- Pick a cool nickname for yourself! -->
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Choose Username" required>
            </div>
            <div class="input-group">
                <!-- Tell us your secret mail-box address! -->
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <!-- Create a secret code only you know! -->
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Create Password" required>
            </div>
            <div class="input-group">
                <!-- Type the secret code again to make sure they are twins! -->
                <i class="fas fa-check-circle"></i>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <!-- Press this button to get your new badge! -->
            <button type="submit" name="register">Register Now</button>
        </form>

        <div class="auth-links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>

</html>