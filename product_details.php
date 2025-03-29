<?php
include 'cmp/head.php';
include 'const/product.php';

// Get the product ID from the URL query string
$productID = $_GET['productID'] ?? null;

// Check if the product exists in the array
$product = $products[$productID] ?? null;
?>

<style>
    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 700px;
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-item {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }

    .testimonial-item:hover {
        transform: scale(1.05);
    }

    /* Add a background image to the upper part of the testimonial */
    .testimonial-img {
        height: 300px;
        /* Adjust this based on how tall you want the image */
        background-size: cover;
        background-position: center;
        border-radius: 5px;
        /* Ensures the top corners are rounded */
    }

    /* Optional: Add some padding or margin to the testimonial text */
    .testimonial-item p {
        margin-top: 15px;
    }

    .testimonial-item strong {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    .testimonial-section {
        padding: 3%;
    }

    /* Add these new styles */
    .testimonial-media {
        height: 300px;
        border-radius: 5px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        background: transparent;
        /* Dark background for letterboxing */
    }

    .testimonial-media video {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        /* Changed from cover to contain */
    }
</style>

<main class="main">


    <?php if ($product): // If product exists, display its details 
            ?>
        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade">
            <div class="container position-relative">
                <h1 class="theme-color"><?php echo htmlspecialchars($product['name']); ?></h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current"><?php echo htmlspecialchars($product['name']); ?></li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Product Details Section -->
        <section id="product-details" class="portfolio-details section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="portfolio-details-slider swiper init-swiper">
                            <script type="application/json" class="swiper-config">
                                    {
                                        "loop": true,
                                        "speed": 600,
                                        "autoplay": {
                                            "delay": 5000
                                        },
                                        "slidesPerView": "auto",
                                        "pagination": {
                                            "el": ".swiper-pagination",
                                            "type": "bullets",
                                            "clickable": true
                                        }
                                    }
                                </script>

                            <div class="swiper-wrapper align-items-center">
                                <?php foreach ($product['images'] as $image): ?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo htmlspecialchars($image); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="swiper-pagination"></div>

                            <?php if (!empty($product['detailed_description'])): ?>
                                <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                                    <h2><?php echo htmlspecialchars($product['title']); ?></h2>
                                    <ul>
                                        <?php foreach ($product['detailed_description'] as $nutrient): ?>
                                            <li><?php echo htmlspecialchars($nutrient); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <p style="text-align: justify;">
                                        <?php echo htmlspecialchars($product['description']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-4">

                        <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                            <h3>Product Information</h3>
                            <ul>
                                <li><strong>Name</strong>: <?php echo htmlspecialchars($product['name']); ?></li>
                                <li><strong>Category</strong>: <?php echo htmlspecialchars($product['category']); ?></li>
                                <li><strong>Manufacturer</strong>: <?php echo htmlspecialchars($product['manufacturer']); ?>
                                </li>
                                <li><strong>URL</strong>: <a href="<?php echo htmlspecialchars($product['url']); ?>"
                                        target="_blank"><?php echo htmlspecialchars($product['url']); ?></a></li>
                            </ul>
                        </div>

                        <br />

                        <?php if (!empty($product['key_ingredients'])): ?>
                            <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                                <h3>Key Ingredients</h3>
                                <ul class="list-unstyled">
                                    <?php foreach ($product['key_ingredients'] as $ingredient): ?>
                                        <li>🌿 <?php echo htmlspecialchars($ingredient); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <br />

                        <?php if (!empty($product['key_benefits'])): ?>
                            <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                                <h3>Key Benefits</h3>
                                <ul class="list-unstyled">
                                    <?php foreach ($product['key_benefits'] as $benefit): ?>
                                        <li>✔️ <?php echo htmlspecialchars($benefit); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </section><!-- /Product Details Section -->


    <?php else: // If product does not exist, show an error message 
            ?>
        <div class="d-flex flex-column justify-content-center align-items-center vh-100 text-center"
            style="background-color:#121e27;">
            <h1 class="theme-color">Product Not Found</h1>
            <p class="text-white">Sorry, the product you are looking for does not exist.</p>
            <a href="index" class="btn btn-primary">Go Back to Home</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($product['testimonials'])): ?>
        <section id="testimonials">
            <div class="container testimonial-section" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-center mb-5 title">Customer Testimonials</h2>
                <div class="row gy-4">
                    <?php foreach ($product['testimonials'] as $testimonial): ?>
                        <div class="col-lg-4">
                            <div class="testimonial-item text-center p-4 shadow rounded">
                                <?php
                                $mediaUrl = htmlspecialchars($testimonial['image']);
                                $fileExtension = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));
                                $videoExtensions = ['mp4', 'webm', 'ogg'];

                                if (in_array($fileExtension, $videoExtensions)): ?>
                                    <div class="testimonial-media">
                                        <video controls style="height: auto;">
                                            <source src="<?php echo $mediaUrl; ?>" type="video/<?php echo $fileExtension; ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                <?php else: ?>
                                    <div class="testimonial-img" style="background-image: url('<?php echo $mediaUrl; ?>');"></div>
                                <?php endif; ?>

                                <p class="mb-3">"<?php echo htmlspecialchars($testimonial['review']); ?>"</p>
                                <strong><?php echo htmlspecialchars($testimonial['name']); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php include 'cmp/foot.php'; ?>