<!DOCTYPE html>
<html lang="en">

<?php
session_start(); // Start session at the very top
// Get the current page name (only the filename, without folders)
$page = basename($_SERVER['PHP_SELF']);
$isActivityPage = ($page === 'activity_details.php');

// Define meta tags for each page
$metaTags = [
  "index.php" => [
    "title" => "Adriz World | Home",
    "description" => "Welcome to Adriz World!",
    "robots" => "index, follow"
  ],
  "product_details.php" => [
    "title" => "Adriz World | Product",
    "description" => "View detailed information about adriz products.",
    "robots" => "index, follow"
  ],
];

// Set default meta tags if the page is not listed
$title = $metaTags[$page]['title'] ?? "Adriz World";
$description = $metaTags[$page]['description'] ?? "Welcome to Adriz World!";
$robots = $metaTags[$page]['robots'] ?? "index, follow";
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="robots" content="<?php echo $robots; ?>">
  <meta name="author" content="jianlin">

  <meta name="keywords" content="Adriz, Adriz-Group, Adriz-Herbal">

  <meta property="og:title" content="Adriz World">
  <meta property="og:description" content="Welcome to Adriz World!">
  <meta property="og:image" content="https://adrizgroup.com/assets/img/logo.png">
  <meta property="og:url" content="https://adrizgroup.com/">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/news.css" rel="stylesheet">

  <!-- JS File -->
  <script type="module" src="../language.js"></script>

  <!-- =======================================================
  * Template Name: Dewi
  * Template URL: https://bootstrapmade.com/dewi-free-multi-purpose-html-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/logo.png" alt="">
        <!-- <h1 class="sitename">Adriz</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#home" class="<?php echo (!$isActivityPage) ? 'active' : ''; ?>" data-i18n="home">Home</a></li>
          <li><a href="index.php#about" data-i18n="about_word">About US</a></li>
          <li><a href="index.php#vm" data-i18n="vm_word">Vision & Mission</a></li>
          <li><a href="index.php#team" data-i18n="team_word">Our Team</a></li>
          <li class="dropdown">
            <a href="index.php#product">
              <span data-i18n="product_word">Product</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
            </a>
            <ul>
              <!-- Product 1 -->
              <li class="dropdown">
                <a>
                  <span>VitC +Serum</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=1" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=1#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 2 -->
              <li class="dropdown">
                <a>
                  <span>Adriz Sunscreen</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=2" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=2#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 3 -->
              <li class="dropdown">
                <a>
                  <span>Rahsia Malam</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=3" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=3#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 4 -->
              <li class="dropdown">
                <a>
                  <span>Adriz Nano Cream</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=4" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=4#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 5 -->
              <li class="dropdown">
                <a>
                  <span>Nano Grow Organic</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=5" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=5#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 6 -->
              <li class="dropdown">
                <a>
                  <span>Andromeck</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=6" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=6#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 7 -->
              <li class="dropdown">
                <a>
                  <span>Stemcell</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=7" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=7#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

              <!-- Product 8 -->
              <li class="dropdown">
                <a>
                  <span>Laqqu Cafe</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <!-- List Item -->
                <ul>
                  <li><a href="/product_details.php?productID=8" data-i18n="info_word"><span>Info</span></a></li>
                  <li><a href="/product_details.php?productID=8#testimonials" data-i18n="testimonial_word"><span>Testimonial</span></a></li>
                </ul>
              </li>

            </ul>
          </li>
          <li><a href="index.php#activity" class="<?php echo ($isActivityPage) ? 'active' : ''; ?>" data-i18n="activity_word">Activity</a></li>
          <li>
            <div class="button-content">
              <a href="https://system.adrizworld.com/" class="btn-get-started p-2">Log In</a>
            </div>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="language-selector">
        <a href="#" class="lang-btn" data-lang="bm">BM</a>
        <span class="lang-separator">|</span>
        <a href="#" class="lang-btn active" data-lang="en">ENG</a>
      </div>

      <!-- <a class="cta-btn" href="index.html#about">Get Started</a> -->

    </div>
  </header>