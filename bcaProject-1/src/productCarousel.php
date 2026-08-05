<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<style>
  /* This is the big box that holds all the sliding toys! */
  .carousel-wrapper {
    font-family: "Poppins", sans-serif;
    max-width: 1200px;
    margin: 80px auto;
    padding: 60px 20px;
    background: #ffffff;
    /* Cleaner background */
    border-radius: 40px;
    box-shadow: 0 20px 70px rgba(0, 0, 0, 0.05);
  }

  .section-title {
    text-align: center;
    color: #1b4332;
    font-size: 3rem;
    font-family: 'Playfair Display', serif;
    margin-bottom: 10px;
    font-weight: 900;
  }

  .section-sub {
    text-align: center;
    color: #4a7c59;
    margin-bottom: 45px;
    font-size: 1.1rem;
  }

  .owl-item {
    perspective: 1200px;
  }

  /* This is the secret card for each toy! */
  .owl-carousel .item-card {
    border-radius: 30px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    margin: 30px 10px;
    display: flex;
    flex-direction: column;
    height: 500px;
    /* Consistent height */
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    transform: scale(0.9);
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.03);
  }

  /* Full Width and Height Image Container */
  .product-image-container {
    width: 100%;
    height: 100%;
    /* Image takes full height of background */
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
  }

  .owl-carousel .item-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Immersive crop */
    transition: transform 0.8s ease;
  }

  /* Gradient Overlay for Text Visibility */
  .item-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 100%);
    z-index: 2;
  }

  /* Product Info Overlay */
  .product-info-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 30px;
    z-index: 3;
    text-align: left;
    color: white;
  }

  .product-name {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 8px;
    font-family: 'Playfair Display', serif;
  }

  .product-price {
    font-size: 1.2rem;
    color: #95d5b2;
    font-weight: 600;
    margin-bottom: 15px;
  }

  /* TILT CLASSES */
  /* TILT CLASSES: This makes the side toys look like they are dancing! */
  .owl-item.center .item-card {
    transform: rotateY(0deg) scale(1.08);
    z-index: 10;
    box-shadow: 0 30px 60px rgba(27, 67, 50, 0.25);
  }

  .owl-item.center .item-card img {
    transform: scale(1.1);
  }

  .owl-item.left-tilt .item-card {
    transform: rotateY(20deg) scale(0.9);
    opacity: 0.8;
  }

  .owl-item.right-tilt .item-card {
    transform: rotateY(-20deg) scale(0.9);
    opacity: 0.8;
  }

  /* Add to Cart Premium Button */
  .btn-add-cart {
    background: #ffffff;
    color: #1b4332;
    text-decoration: none;
    padding: 12px 25px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    transition: all 0.3s ease;
    display: inline-block;
    border: none;
    letter-spacing: 1px;
  }

  .btn-add-cart:hover {
    background: #2d6a4f;
    color: white;
    transform: scale(1.05);
  }

  /* Dot Styling */
  .owl-dots {
    margin-top: 40px !important;
  }

  .owl-dot span {
    width: 12px !important;
    height: 12px !important;
    background: #dcfce7 !important;
    margin: 5px 8px !important;
  }

  .owl-dot.active span {
    background: #1b4332 !important;
    width: 30px !important;
  }

  @media (max-width: 700px) {
    .item-card {
      height: 400px;
    }

    .section-title {
      font-size: 2rem;
    }
  }
</style>

<div class="carousel-wrapper">
  <h2 class="section-title">Our Products</h2>
  <p class="section-sub">We have the latest products, it must be exciting for you.</p>

  <div class="owl-carousel owl-theme">
    <?php
    // We ask the treasure box for ALL the toys!
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="item-card" data-id="<?php echo $row['id']; ?>">
        <div class="product-image-container">
          <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" loading="lazy" decoding="async">
        </div>
        <div class="product-info-overlay">
          <div class="product-name"><?php echo $row['name']; ?></div>
          <div class="product-price">Rs. <?php echo number_format($row['price'], 2); ?></div>
          <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn-add-cart" data-i18n="addToCart">Add to
            Cart</a>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
</div>

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
  // Initialize Owl Carousel
  var $owl = $(".owl-carousel");

  $owl.owlCarousel({
    center: true,
    loop: true,
    margin: 20, /* Increased margin slightly for tilt space */
    nav: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 3000,
    smartSpeed: 800,
    responsive: {
      0: { items: 1 },
      700: { items: 3 }
    },
    onTranslate: updateClasses,
    onTranslated: updateClasses,
    onInitialized: updateClasses
  });

  $(".owl-nav button.owl-prev").attr("aria-label", "Previous Slide");
  $(".owl-nav button.owl-next").attr("aria-label", "Next Slide");

  /* This function is like a dancing teacher, telling toys how to tilt! */
  function updateClasses(event) {
    // Clear custom classes from all items first
    var $items = $(".owl-item");
    $items.removeClass("left-tilt right-tilt");

    var centerIndex;

    if (event.type === 'translate') {
      // During transition, event.item.index points to the target center index
      centerIndex = event.item.index;
    } else {
      // When initialized or finished, we can rely on the .center class
      // Use the index of the element with class .center
      centerIndex = $items.index($items.filter(".center"));
    }

    // Apply classes to neighbors based on the calculated center index
    if (centerIndex !== -1 && centerIndex !== undefined) {
      $items.eq(centerIndex - 1).addClass("left-tilt");
      $items.eq(centerIndex + 1).addClass("right-tilt");
    }
  }
</script>