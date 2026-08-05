<style>
    .plants-carousel-section {
        padding: 40px 0;
        overflow: hidden;
        /* Hide overflow from the body to prevent scrollbars */
        background: rgba(255, 255, 255, 0.4);
        margin: 40px 0;
        border-radius: 20px;
    }

    /* This is the big sign for our Garden of Photos! */
    .medicinal-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 0 20px;
    }

    .medicinal-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #1b4332;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .medicinal-header p {
        color: #4a7c59;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .carousel-container {
        display: inline-block;
        white-space: nowrap;
        width: 100%;
        /* Retained from original, as instruction only showed partial change */
        overflow: hidden;
        /* Retained from original */
        position: relative;
        /* Retained from original */
        margin-bottom: 20px;
        /* Retained from original */
    }

    .carousel-track {
        display: inline-block;
        white-space: nowrap;
    }

    .carousel-img {
        height: 200px;
        /* Medium height */
        width: 300px;
        /* Rectangle width */
        object-fit: cover;
        margin: 0 10px;
        border-radius: 10px;
        vertical-align: middle;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .carousel-img:hover {
        transform: scale(1.05);
        z-index: 10;
    }

    /* Animation Definitions */
    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes scroll-right {
        0% {
            transform: translateX(-50%);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* This makes the photos move left and right like a train! */
    .move-left {
        animation: scroll-left 40s linear infinite;
    }

    .move-right {
        animation: scroll-right 40s linear infinite;
    }

    /* If you touch the photo, the train stops so you can look! */
    .carousel-container:hover .carousel-track {
        animation-play-state: paused;
    }
</style>

<div class="medicinal-header">
    <h2>Ayurvedic Medicinal Plants</h2>
    <p>Explore the healing power of nature's pharmacy through our curated collection of traditional herbs.</p>
</div>
<div class="plants-carousel-section">
    <!-- Row 1: The photos go this way --->
    <div class="carousel-container">
        <!-- The photos follow each other twice so they never end! -->
        <div class="carousel-track move-right">
            <!-- Set 1 -->
            <img src="../PlantsImages/2.%20Kutki%20(Neopicrorhiza%20scrophulariiflora).jpg" alt="Kutki"
                class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/amala.jpg" alt="Amala" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/ashowagandha%20plant.webp" alt="Ashwagandha Plant" class="carousel-img"
                loading="lazy" decoding="async">
            <img src="../PlantsImages/ashowagandha.webp" alt="Ashwagandha" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/barro%20medicinal%20plant.jpg" alt="Barro Plant" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/barro.webp" alt="Barro" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/bojho%20plant.jpg" alt="Bojho" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/chiraito%20plant.jpg" alt="Chiraito" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/harro%20fruit.jpg" alt="Harro Fruit" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/harro%20plant.jpg" alt="Harro Plant" class="carousel-img" loading="lazy"
                decoding="async">

            <!-- Set 1 Duplicate (Clone) -->
            <img src="../PlantsImages/2.%20Kutki%20(Neopicrorhiza%20scrophulariiflora).jpg" alt="Kutki"
                class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/amala.jpg" alt="Amala" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/ashowagandha%20plant.webp" alt="Ashwagandha Plant" class="carousel-img"
                loading="lazy" decoding="async">
            <img src="../PlantsImages/ashowagandha.webp" alt="Ashwagandha" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/barro%20medicinal%20plant.jpg" alt="Barro Plant" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/barro.webp" alt="Barro" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/bojho%20plant.jpg" alt="Bojho" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/chiraito%20plant.jpg" alt="Chiraito" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/harro%20fruit.jpg" alt="Harro Fruit" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/harro%20plant.jpg" alt="Harro Plant" class="carousel-img" loading="lazy"
                decoding="async">
        </div>
    </div>

    <!-- Row 2: The photos go that way <--- -->
    <div class="carousel-container">
        <div class="carousel-track move-left">
            <!-- Set 2 -->
            <img src="../PlantsImages/pachaula%20plant.jpg" alt="Pachaula" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/sarpaganda%20plant.avif" alt="Sarpaganda Plant" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/sarpaganda%20root.webp" alt="Sarpaganda Root" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/sarpaganda2.jpg" alt="Sarpaganda" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/satuwa%20plant.jpg" alt="Satuwa Plant" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/satuwa.jpg" alt="Satuwa" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/silajit%20image.jpg" alt="Silajit" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/timur%20plant.webp" alt="Timur" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/tulsi.webp" alt="Tulsi" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/yarsagumbapackage.jpg" alt="Yarsagumba" class="carousel-img" loading="lazy"
                decoding="async">

            <!-- Set 2 Duplicate (Clone) -->
            <img src="../PlantsImages/pachaula%20plant.jpg" alt="Pachaula" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/sarpaganda%20plant.avif" alt="Sarpaganda Plant" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/sarpaganda%20root.webp" alt="Sarpaganda Root" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/sarpaganda2.jpg" alt="Sarpaganda" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/satuwa%20plant.jpg" alt="Satuwa Plant" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/satuwa.jpg" alt="Satuwa" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/silajit%20image.jpg" alt="Silajit" class="carousel-img" loading="lazy"
                decoding="async">
            <img src="../PlantsImages/timur%20plant.webp" alt="Timur" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/tulsi.webp" alt="Tulsi" class="carousel-img" loading="lazy" decoding="async">
            <img src="../PlantsImages/yarsagumbapackage.jpg" alt="Yarsagumba" class="carousel-img" loading="lazy"
                decoding="async">
        </div>
    </div>
</div>