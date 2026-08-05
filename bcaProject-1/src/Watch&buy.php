<?php
// We open the secret pipe to the treasure box!
include_once 'connection.php';

// We write down the names of the toys we want to show on our mini-TVs!
$productNames = ['Liver Restore Tablets', 'Apple Cider Vinegar', 'Herboslim Tablets', 'Liver Care Tablets'];
$productMap = [];

$namesEscaped = array_map(function ($name) use ($conn) {
    return "'" . mysqli_real_escape_string($conn, $name) . "'";
}, $productNames);

if (!empty($namesEscaped)) {
    $namesList = implode(',', $namesEscaped);
    // We ask the computer to find the special ID number for each toy name!
    $res = mysqli_query($conn, "SELECT id, name FROM products WHERE name IN ($namesList)");
    while ($row = mysqli_fetch_assoc($res)) {
        $productMap[$row['name']] = $row['id'];
    }
}

// This little magic trick helps us find the toy's ID in our map!
function getMappedId($map, $name)
{
    return $map[$name] ?? 0;
}
?>
<style>
    /* Watch & Shop Section Styles */
    .watch-shop-section {
        padding: 40px 20px;
        text-align: center;
        font-family: 'Poppins', sans-serif;
    }

    .watch-shop-title {
        color: #006400;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .video-cards-wrapper {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        gap: 20px;
        padding-bottom: 25px;
        scrollbar-width: thin;
        scrollbar-color: #006400 #f1f1f1;
        justify-content: flex-start;
        align-items: stretch;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .video-cards-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .video-cards-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .video-cards-wrapper::-webkit-scrollbar-thumb {
        background: #006400;
        border-radius: 4px;
    }

    .video-card {
        flex: 0 0 300px;
        width: 300px;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        position: relative;
        border: 1px solid #eee;
        transition: transform 0.3s ease;
    }

    .video-card:hover {
        transform: translateY(-5px);
    }

    .card-video {
        position: relative;
        width: 100%;
        height: 450px;
        background: #000;
    }

    .card-video iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-product-details {
        padding: 15px;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 12px;
        border-top: 1px solid #f1f1f1;
        flex-grow: 1;
    }

    .product-info-row {
        display: flex;
        gap: 12px;
        align-items: center;
        text-align: left;
    }

    .product-thumb {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f0f0f0;
    }

    .product-text {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
    }

    .watch-shop-section .product-name {
        font-size: 15px;
        font-weight: 700;
        color: #1b4332;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
        margin-top: 0;
    }

    .watch-shop-section .price-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .watch-shop-section .product-price {
        font-size: 15px;
        font-weight: 800;
        color: #2d6a4f;
    }

    .watch-shop-section .original-price {
        font-size: 13px;
        color: #999;
        text-decoration: line-through;
    }

    .discount-text {
        font-size: 12px;
        color: #28a745;
        font-weight: 700;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #2d6a4f, #1b4332);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        text-transform: uppercase;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 10px rgba(27, 67, 50, 0.2);
    }

    .add-to-cart-btn:hover {
        background: linear-gradient(135deg, #1b4332, #1b4332);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(27, 67, 50, 0.3);
        color: white;
    }
</style>

<div class="watch-shop-section">
    <!-- This is the title for our "Watch & Shop" play area! -->
    <h2 class="watch-shop-title" data-i18n="watchShopTitle">Watch and Buy!</h2>

    <div class="video-cards-wrapper">
        <!-- Card 1 -->
        <div class="video-card">
            <div class="card-video">
                <iframe src="https://www.youtube.com/embed/o9zsQvQ-KlY?enablejsapi=1&rel=0&controls=0&modestbranding=1"
                    title="Liver Restore" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="card-product-details">
                <div class="product-info-row">
                    <!-- A photo of the toy from the TV show! -->
                    <img src="https://images.pexels.com/photos/3738439/pexels-photo-3738439.jpeg?auto=compress&cs=tinysrgb&w=300"
                        alt="Liver Restore" class="product-thumb" loading="lazy">
                    <div class="product-text">
                        <!-- What the toy is called! -->
                        <div class="product-name">Liver Restore Tablets</div>
                        <div class="price-row">
                            <!-- How many coins it costs! -->
                            <span class="product-price">Rs. 566.00</span>
                            <span class="original-price">Rs. 666.00</span>
                        </div>
                        <div class="discount-text">15% Off</div>
                    </div>
                </div>
                <!-- Put the toy into your shopping bag! -->
                <a href="add_to_cart.php?id=<?php echo getMappedId($productMap, 'Liver Restore Tablets'); ?>"
                    class="add-to-cart-btn">Put in Bag!</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="video-card">
            <div class="card-video">
                <iframe src="https://www.youtube.com/embed/nAvLa14tgKc?enablejsapi=1&rel=0&controls=0&modestbranding=1"
                    title="Apple Cider" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="card-product-details">
                <div class="product-info-row">
                    <img src="https://images.pexels.com/photos/3738374/pexels-photo-3738374.jpeg?auto=compress&cs=tinysrgb&w=300"
                        alt="Apple Cider" class="product-thumb" loading="lazy">
                    <div class="product-text">
                        <div class="product-name">Apple Cider Vinegar</div>
                        <div class="price-row">
                            <span class="product-price">Rs. 264.00</span>
                            <span class="original-price">Rs. 311.00</span>
                        </div>
                        <div class="discount-text">15% Off</div>
                    </div>
                </div>
                <a href="add_to_cart.php?id=<?php echo getMappedId($productMap, 'Apple Cider Vinegar'); ?>"
                    class="add-to-cart-btn">Add To Cart</a>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="video-card">
            <div class="card-video">
                <iframe src="https://www.youtube.com/embed/805NF-S-xD4?enablejsapi=1&rel=0&controls=0&modestbranding=1"
                    title="Herboslim" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="card-product-details">
                <div class="product-info-row">
                    <img src="https://images.pexels.com/photos/3738365/pexels-photo-3738365.jpeg?auto=compress&cs=tinysrgb&w=300"
                        alt="Herboslim" class="product-thumb" loading="lazy">
                    <div class="product-text">
                        <div class="product-name">Herboslim Tablets</div>
                        <div class="price-row">
                            <span class="product-price">Rs. 279.00</span>
                            <span class="original-price">Rs. 328.00</span>
                        </div>
                        <div class="discount-text">15% Off</div>
                    </div>
                </div>
                <a href="add_to_cart.php?id=<?php echo getMappedId($productMap, 'Herboslim Tablets'); ?>"
                    class="add-to-cart-btn">Add To Cart</a>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="video-card">
            <div class="card-video">
                <iframe src="https://www.youtube.com/embed/ebL5zLQGDtM?enablejsapi=1&rel=0&controls=0&modestbranding=1"
                    title="Liver Care" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="card-product-details">
                <div class="product-info-row">
                    <img src="https://images.pexels.com/photos/3738341/pexels-photo-3738341.jpeg?auto=compress&cs=tinysrgb&w=300"
                        alt="Liver Care" class="product-thumb" loading="lazy">
                    <div class="product-text">
                        <div class="product-name">Liver Care Tablets</div>
                        <div class="price-row">
                            <span class="product-price">Rs. 478.00</span>
                            <span class="original-price">Rs. 562.00</span>
                        </div>
                        <div class="discount-text">15% Off</div>
                    </div>
                </div>
                <a href="add_to_cart.php?id=<?php echo getMappedId($productMap, 'Liver Care Tablets'); ?>"
                    class="add-to-cart-btn">Add To Cart</a>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="video-card">
            <div class="card-video">
                <iframe src="https://youtube.com/embed/HRpea-yMnco?enablejsapi=1&rel=0&controls=0&modestbranding=1"
                    title="Liver Restore" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="card-product-details">
                <div class="product-info-row">
                    <img src="https://images.pexels.com/photos/3738439/pexels-photo-3738439.jpeg?auto=compress&cs=tinysrgb&w=300"
                        alt="Liver Restore" class="product-thumb" loading="lazy">
                    <div class="product-text">
                        <div class="product-name">Liver Restore Tablets</div>
                        <div class="price-row">
                            <span class="product-price">Rs. 566.00</span>
                            <span class="original-price">Rs. 666.00</span>
                        </div>
                        <div class="discount-text">15% Off</div>
                    </div>
                </div>
                <a href="add_to_cart.php?id=<?php echo getMappedId($productMap, 'Liver Restore Tablets'); ?>"
                    class="add-to-cart-btn">Add To Cart</a>
            </div>
        </div>

    </div>
</div>