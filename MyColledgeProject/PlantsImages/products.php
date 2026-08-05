<?php
// We tell the computer to remember us!
session_start();
// We open the secret pipe to our treasure box!
include '../src/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - Ayurvedic Health Portal</title>
    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Using same CSS as Home for consistency + Bootstrap for Grid -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/style.css?v=2.0">
    <script src="../src/script.js?v=2.0" defer></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.3/dist/dotlottie-wc.js" type="module"></script>
    <script>
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
    </script>

    <style>
        /* This is how the floor and walls of our shop look! */
        body {
            background-color: #fcfdfc; /* Clean and bright background! */
        }

        /* Navbar Tweaks for this page */
        .header {
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, 0.95);
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Page Title */
        /* This is the big sign at the top of the store! */
        .page-header {
            text-align: center; /* Put words in the middle! */
            padding: 40px 20px; /* Lots of space! */
            background: linear-gradient(to bottom, #f0fdf4, #ffffff); /* Soft green sky! */
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif; /* Fancy curly letters! */
            color: #1b4332; /* Deep forest green! */
            font-size: 3rem;
            font-weight: 800; /* Extra thick letters! */
        }

        .page-header p {
            color: #4a7c59;
            font-size: 1.2rem;
            max-width: 600px;
            margin: 10px auto;
        }

        /* Search Section */
        .search-section {
            background: #fff;
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 15px 25px;
            border-radius: 50px;
            border: 2px solid #e0e0e0;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #2d6a4f;
            box-shadow: 0 0 15px rgba(45, 106, 79, 0.1);
        }

        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            display: none;
            margin-top: 5px;
            overflow: hidden;
        }

        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: 0.2s;
        }

        .suggestion-item:hover {
            background: #f0fdf4;
            color: #1b4332;
        }



        /* This is the pretty box for each individual product! */
        .product-card-wrapper {
            background: #fff;
            border-radius: 20px; /* Round like a pillow! */
            overflow: hidden; /* Keep the products inside the box! */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); /* Floating a little! */
            transition: all 0.3s ease; /* Lift up slowly! */
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
        }

        .product-card-wrapper:hover {
            /* When you touch it, it lifts up and glows! */
            box-shadow: 0 15px 40px rgba(27, 67, 50, 0.15);
            transform: translateY(-5px);
        }

        .img-box {
            height: 200px;
            overflow: hidden;
            /* IMPORTANT: Keeps zoom inside */
            position: relative;
            background: #fafafa;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease; /* The picture grows slowly! */
        }

        /* THE HOVER EFFECT: The product gets bigger when you look at it! */
        .img-box:hover img {
            transform: scale(1.1);
        }

        .details-box {
            padding: 15px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .p-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: #1b4332;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .p-price {
            color: #2d6a4f;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .badge-cat {
            background: #f0fdf4;
            color: #2d6a4f;
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .btn-add-cart {
            background-color: #f0fdf4;
            color: #1b4332;
            border: 1px solid #1b4332;
            padding: 8px 15px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: block;
            font-size: 0.9rem;
        }

        .btn-add-cart:hover {
            background-color: #1b4332;
            color: #ffffff;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 0 2px;
            border-radius: 2px;
            font-weight: bold;
        }

        #loading-spinner {
            display: none;
            text-align: center;
            padding: 50px;
        }
    </style>
</head>

<body>

    <!-- REUSED NAVBAR Structure -->
    <!-- This is the "Magic Hat" (Header) that stays at the top of the shop! -->
    <div class="header">
        <div class="logo">
            <!-- This is our special house picture! -->
            <a href="../src/HomePage.php" class="logo-link" style="display: flex; align-items: center;">
                <dotlottie-wc src="https://lottie.host/187983ba-42e5-4a30-8b7f-8859d8b84932/7CtK2QviJK.lottie" style="height: 65px; width: auto; filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.18));" autoplay loop></dotlottie-wc>
            </a>
        </div>
        <nav>
            <!-- These are the "Magic Doors" to other rooms! -->
            <a href="../src/HomePage.php" data-i18n="navHome">Home</a>
            <a href="../src/HomePage.php#quiz" data-i18n="navQuiz">Dosha Quiz</a>
            <a href="../src/HomePage.php#remedy" data-i18n="navRemedy">Remedy Finder</a>
            <a href="products.php" class="active" style="color:#2d6a4f; font-weight:bold;"
                data-i18n="navProducts">Products</a>
            <a href="../src/HomePage.php#contact" data-i18n="navContact">Contact</a>

            <!-- This is your "Shopping Bag" to carry your products! -->
            <a href="../src/cart.php" class="cart-link">
                <span data-i18n="navCart">🛒 Cart</span>
                <span id="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
            </a>

            <?php if (isset($_SESSION['user'])): ?>
                <!-- If the computer knows you, it says goodbye here! -->
                <a href="../src/logout.php" data-i18n="navLogout">Logout (<?php echo $_SESSION['user']; ?>)</a>
            <?php else: ?>
                <!-- If you're new, come in through this door! -->
                <a href="../src/login.php" data-i18n="navLogin">Login</a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Page Title -->
    <!-- This is the big sign for our "Magic Shop"! -->
    <section class="page-header">
        <h1>Health Store</h1>
        <p>Find the best Ayurvedic solutions for your health problems.</p>
    </section>

    <!-- Search Section -->
    <!-- This is the box where you can ask for a specific product! (Search) -->
    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <input type="text" id="live-search" class="search-input"
                    placeholder="Search by name, disease (e.g. hair fall), or ingredients..." autocomplete="off">
                <!-- This is a secret list that pops up to help you choose! -->
                <div id="suggestions" class="suggestions-dropdown"></div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row">
            <!-- This is the "Product Display" where everything appears! -->
            <div class="col-12">
                <div id="loading-spinner">
                    <!-- A spinning wheel while the computer looks for products! -->
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="row g-4" id="product-grid">
                    <!-- Your magic products will be put here by the computer! -->
                </div>
                <!-- If the shop is empty for what you asked... -->
                <div id="no-results" class="text-center py-5 d-none">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>No products found</h4>
                    <p class="text-muted">Try adjusting your search or filters to find what you're looking for.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="text-center py-4" style="border-top: 1px solid #eee; margin-top: 50px; color: #666;">
        &copy; 2026 Ayurvedic Health Portal
    </footer>

    <!-- AJAX Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to load products
            function loadProducts() {
                const query = $('#live-search').val();
                const sort = 'newest';
                const maxPrice = 2000;
                const minRating = 0;
                const category = '';

                $('#product-grid').hide();
                $('#loading-spinner').show();
                $('#no-results').addClass('d-none');                // This is the "Magic Delivery" part (AJAX) that gets products from the Treasure Box!
                $.ajax({
                    url: '../src/search_api.php',
                    method: 'GET',
                    data: {
                        q: query,
                        sort: sort,
                        max_price: maxPrice,
                        category: category,
                        min_rating: minRating
                    },
                    success: function (response) {
                        $('#loading-spinner').hide();
                        $('#product-grid').empty().show();

                        if (response.length === 0) {
                            $('#no-results').removeClass('d-none');
                        } else {
                            // We go through each product and make it a pretty card!
                            response.forEach(product => {
                                const highlightedName = highlightText(product.name, query);
                                const ratingStars = getRatingStars(product.rating);

                                const card = `
                                    <div class="col-sm-6 col-md-4">
                                        <div class="product-card-wrapper" style="border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-radius: 20px; overflow: hidden; height: 350px;">
                                            <div class="img-box" style="height: 100%; border-radius: 20px;">
                                                <!-- A pretty photo of the product! -->
                                                <img src="${product.image.startsWith('http') ? product.image : (product.image.startsWith('../') ? product.image : '../' + product.image)}" alt="${product.name}" style="height: 100%; object-fit: cover; border-radius: 20px;">
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#product-grid').append(card);
                            });
                        }
                    }
                });});
            }

            function highlightText(text, keyword) {
                if (!keyword) return text;
                const re = new RegExp(`(${keyword})`, 'gi');
                return text.replace(re, '<span class="highlight">$1</span>');
            }

            function getRatingStars(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) stars += '<i class="fas fa-star"></i>';
                    else if (i - 0.5 <= rating) stars += '<i class="fas fa-star-half-alt"></i>';
                    else stars += '<i class="far fa-star"></i>';
                }
                return stars;
            }

            // Live Search Suggestions
            $('#live-search').on('input', function () {
                const query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: '../src/suggestions_api.php',
                        method: 'GET',
                        data: { q: query },
                        success: function (response) {
                            if (response.length > 0) {
                                $('#suggestions').empty().show();
                                response.forEach(item => {
                                    $('#suggestions').append(`<div class="suggestion-item">${item}</div>`);
                                });
                            } else {
                                $('#suggestions').hide();
                            }
                        }
                    });
                } else {
                    $('#suggestions').hide();
                }
                loadProducts();
            });

            $(document).on('click', '.suggestion-item', function () {
                $('#live-search').val($(this).text());
                $('#suggestions').hide();
                loadProducts();
            });


            // Initial Load
            loadProducts();
        });
    </script>
</body>

</html>