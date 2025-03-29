<?php include 'cmp/head.php'; ?>
<?php include 'cmp/fetchActivity.php'; ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    openPopup();
  });

  function openPopup() {
    document.getElementById("newsPopup").style.visibility = "visible";
    document.getElementById("newsPopup").style.opacity = "1";
    document.body.style.overflow = "hidden"; // Disable background scrolling
  }

  function closePopup() {
    document.getElementById("newsPopup").style.opacity = "0";
    setTimeout(() => {
      document.getElementById("newsPopup").style.visibility = "hidden";
      document.body.style.overflow = "auto"; // Re-enable scrolling
    }, 300);
  }
</script>

<main class="main">

  <!-- News Popup with Carousel -->
  <!-- <div id="newsPopup" class="news-popup">
    <div class="news-content">
      <button class="close-btn" onclick="closePopup()">×</button>

      <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <?php foreach ($topActivities as $key => $activity): ?>
            <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="<?= $key; ?>"
              class="<?= $key === 0 ? 'active' : ''; ?>"
              aria-current="<?= $key === 0 ? 'true' : 'false'; ?>"
              aria-label="Slide <?= $key + 1; ?>">
            </button>
          <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
          <?php foreach ($topActivities as $key => $activity): ?>
            <div class="carousel-item <?= $key === 0 ? 'active' : ''; ?>">
              <img src="<?= $activity['media']; ?>" class="d-block w-100" alt="<?= $activity['title']; ?>">
              <div class="carousel-caption">
                <h3 style="color:white;"><?= $activity['title']; ?></h3>
                <p>
                  <?php
                  $newsMaxLength = 100;
                  $newsDescription = $activity['description'];
                  echo (strlen($newsDescription) > $newsMaxLength) ? substr($newsDescription, 0, $newsMaxLength) . "..." : $newsDescription;
                  ?>
                </p>
                <a href="activity_details.php?activityID=<?= $activity['id']; ?>" class="btn-read-more">Read More</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>

    </div>
  </div> -->

  <!-- Activity Carousel Section Start -->
  <section id="home" class="hero section dark-background">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php if (!empty($topActivities)): ?>
          <?php foreach ($topActivities as $key => $activity): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $key; ?>" class="<?= $key === 0 ? 'active' : ''; ?>" aria-current="<?= $key === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?= $key + 1; ?>"></button>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div class="carousel-inner">
        <?php foreach ($topActivities as $key => $activity): ?>
          <div class="carousel-item <?= $key === 0 ? 'active' : ''; ?>">
            <img src="<?= $activity['media']; ?>" class="d-block w-100" alt="<?= $activity['title']; ?>">
            <div class="carousel-caption">
              <div class="container">
                <div class="text-content">
                  <h2><?= $activity['title']; ?></h2>
                  <p>
                    <?php
                    $maxLength = 70; // Adjust as needed
                    $description = $activity['description'];
                    if (strlen($description) > $maxLength) {
                      $description = substr($description, 0, $maxLength) . "...";
                    }
                    echo $description;
                    ?>
                  </p>
                </div>
                <div class="button-content">
                  <a href="activity_details.php?activityID=<?php echo $activity['id']; ?>" class="btn-get-started">Learn More</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  <!-- Activity Carousel Section End -->

  <!-- About US Section Start-->
  <section id="about" class="about features section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2 data-i18n="about_word">About</h2>
      <p data-i18n="about">About Us</p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <h3><span class="theme-color">Adriz World</span> Sdn Bhd</h3>
          <img src="assets/img/about.jpg" class="img-fluid rounded-4 mb-4" alt="">
          <p data-i18n="about_us_point_1"></p>
          <p data-i18n="about_us_point_2"></p>
          <div class="content">
            <p class="fst-italic" data-i18n="core_title"></p>
            <ul>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="core_point_1"></span>
              </li>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="core_point_2"></span>
              </li>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="core_point_3"></span>
              </li>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="core_point_4"></span>
              </li>
            </ul>
          </div>
        </div>

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
          <div class="content ps-0 ps-lg-5">
            <p class="fst-italic" data-i18n="unique_title"></p>
            <ul>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="unique_point_1"></span>
              </li>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="unique_point_2"></span>
              </li>
              <li><i class="bi bi-check-circle-fill"></i>
                <span data-i18n="unique_point_3"></span>
              </li>
            </ul>

            <p data-i18n="about_us_point_3"></p>
            <p data-i18n="about_us_point_4"></p>
            <p data-i18n="about_us_point_5"></p>

            <div class="position-relative mt-4">
              <video class="img-fluid rounded-4" autoplay muted loop controls>
                <source src="assets/video/company_video.mp4" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>

          </div>
        </div>
      </div>

    </div>

  </section>
  <!-- About Us Section End-->

  <!-- Vision and Mission Section Start-->
  <section id="vm" class="about features section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2 data-i18n="vm_word">Vision & Mission</h2>
      <p data-i18n="vm">Our Vision & Mission</p>
    </div><!-- End Section Title -->

    <div class="container">

      <ul class="nav nav-tabs row  d-flex" data-aos="fade-up" data-aos-delay="100">
        <li class="nav-item col-4">
          <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
            <i class="bi bi-chat-dots"></i>
            <h4 class="d-none d-lg-block" data-i18n="chairman_message">Chairman's Message</h4>
          </a>
        </li>
        <li class="nav-item col-4">
          <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
            <i class="bi bi-eye"></i>
            <h4 class="d-none d-lg-block" data-i18n="our_vision">Our Vision</h4>
          </a>
        </li>
        <li class="nav-item col-4">
          <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
            <i class="bi bi-bullseye"></i>
            <h4 class="d-none d-lg-block" data-i18n="our_mission">Our Mission</h4>
          </a>
        </li>
      </ul><!-- End Tab Nav -->

      <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

        <div class="tab-pane fade active show" id="features-tab-1">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3 data-i18n="chairman_message"></h3>
              <p class="fst-italic" data-i18n="message" style="text-align: justify;"></p>
              <p class="mb-0 text-start">
                <span data-i18n="chairman_note"></span><br>
              </p>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/working-1.jpg" alt="" class="img-fluid">
            </div>
          </div>
        </div><!-- End Tab Content Item -->

        <div class="tab-pane fade" id="features-tab-2">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3 data-i18n="our_vision">Vision</h3>
              <ul>
                <li style="text-align: justify;">
                  <!-- <i class="bi bi-check-lg"></i> -->
                  <span data-i18n="vision_point"></span>
                </li>
              </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/working-2.jpg" alt="" class="img-fluid">
            </div>
          </div>
        </div><!-- End Tab Content Item -->

        <div class="tab-pane fade" id="features-tab-3">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3 data-i18n="our_mission">Mission</h3>
              <ul>
                <li>
                  <span data-i18n="mission_point" style="font-size: large;">
                  </span>
                </li>
              </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/working-3.jpg" alt="" class="img-fluid">
            </div>
          </div>
        </div><!-- End Tab Content Item -->

      </div>

    </div>

  </section>
  <!-- Vision and Mission Section End-->

  <!-- Team Section Start -->
  <section id="team" class="team section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2 data-i18n="team_word">Team</h2>
      <p data-i18n="team">OUR TEAM</p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-5">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Zul Md Nor</h4>
              <span data-i18n="chairman_position"></span>
              <!-- <div class="social">
                <a href="mailto:"><i class="bi bi-envelope"></i></a>
              </div> -->
            </div>
          </div>
        </div>
        <!-- End Team Member -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Puan Ainna Fadhilla Binti Zurkarnain</h4>
              <span data-i18n="cfo_position"></span>
            </div>
          </div>
        </div>
        <!-- End Team Member -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Juliza Tee</h4>
              <span data-i18n="hocc_position"></span>
            </div>
          </div>
        </div>
        <!-- End Team Member -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Remy and Isteri</h4>
              <span data-i18n="roc_position"></span>
            </div>
          </div>
        </div>
        <!-- End Team Member -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Abian</h4>
              <span data-i18n="hos_position"></span>
            </div>
          </div>
        </div>
        <!-- End Team Member -->

        <!-- <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>En Noraimy Kamalruddin</h4>
              <span data-i18n="hobd_position"></span>
              <div class="social">
                <a href="mailto:Noraimy@adrizgroup.com"><i class="bi bi-envelope"></i></a>
                
              </div>
            </div>
          </div>
        </div> -->
        <!-- End Team Member -->


      </div>

    </div>

  </section>
  <!-- /Team Section End -->

  <!-- Clients Section Start -->
  <!-- <section id="clients" class="clients section light-background">

    <div class="container" data-aos="fade-up">

      <div class="row gy-4">

        <div class="col-xl-2 col-md-3 col-6 client-logo">
          <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
        </div>

        <div class="col-xl-2 col-md-3 col-6 client-logo">
          <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
        </div>

        <div class="col-xl-2 col-md-3 col-6 client-logo">
          <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
        </div>
        
        <div class="col-xl-2 col-md-3 col-6 client-logo">
          <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
        </div>
        
        <div class="col-xl-2 col-md-3 col-6 client-logo">
          <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
        </div>
        
        <div class="col-xl-2 col-md-3 col-6 client-logo">
          <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
        </div>
        
      </div>

    </div>

  </section> -->
  <!-- /Clients Section End -->

  <!-- Product Section Start -->
  <section id="product" class="product section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2 data-i18n="product_word">Product</h2>
      <p data-i18n="product">Our Product</p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <ul class="product-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
          <li data-filter="*" class="filter-active">All</li>
          <li data-filter=".filter-app">App</li>
          <li data-filter=".filter-product">Product</li>
          <li data-filter=".filter-branding">Branding</li>
          <li data-filter=".filter-books">Books</li>
        </ul>
        <!-- End Product Filters -->

        <!-- Start Product Container -->
        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-app">
            <div class="product-content h-100">
              <a href="product_details.php?productID=1">
                <img src="assets/img/product/VitC_+Serum/VitC_+Serum_1.jpg" class="img-fluid" alt="VitC +Serum">
                <div class="product-info">
                  <p class="theme-color">VitC +Serum</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=2">
                <img src="assets/img/product/Adriz_Sunscreen/Adriz_Sunscreen_1.jpg" class="img-fluid" alt="Adriz_Sunscreen">
                <div class="product-info">
                  <p class="theme-color">Adriz Sunscreen</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=3">
                <img src="assets/img/product/Adriz_Rahsia_Malam/Adriz_Rahsia_Malam_1.jpg" class="img-fluid" alt="Adriz Rahsia Malam">
                <div class="product-info">
                  <p class="theme-color">Adriz Rahsia Malam</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=4">
                <img src="assets/img/product/Adriz_Nano_Cream/Adriz_Nano_Cream_1.jpg" class="img-fluid" alt="Adriz Nano Cream">
                <div class="product-info">
                  <p class="theme-color">Adriz Nano Cream</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=5">
                <img src="assets/img/product/Nano_Grow_Organic/Nano_Grow_Organic_1.jpg" class="img-fluid" alt="Nano Grow Organic">
                <div class="product-info">
                  <p class="theme-color">Nano Grow Organic</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=6">
                <img src="assets/img/product/Andromeck/Andromeck.jpg" class="img-fluid" alt="Andromeck">
                <div class="product-info">
                  <p class="theme-color">Andromeck</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=7">
                <img src="assets/img/product/Stemcell/Stemcell.jpg" class="img-fluid" alt="Stemcell">
                <div class="product-info">
                  <p class="theme-color">Stemcell</p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 product-item isotope-item filter-product">
            <div class="product-content h-100">
              <a href="product_details.php?productID=6">
                <img src="assets/img/product/Laqqu_Cafe/Laqqu_Cafe.jpg" class="img-fluid" alt="Laqqu_Cafe">
                <div class="product-info">
                  <p class="theme-color">Laqqu Cafe</p>
                </div>
              </a>
            </div>
          </div>

        </div>
        <!-- End Product Container -->

      </div>

    </div>

  </section>
  <!-- /Product Section End -->

  <!-- Activity Section Start -->
  <section id="activity" class="services section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2 data-i18n="activity_word">Activity</h2>
      <p data-i18n="activity">Our Activity</p>
    </div>
    <!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-5">

        <?php if (isset($activities) && !empty($activities)): ?>
          <?php foreach ($activities as $activity): ?>
            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
              <a class="service-item stretched-link" href="activity_details.php?activityID=<?php echo $activity['id']; ?>">
                <div class="img">
                  <img src="<?php echo $activity['media']; ?>" class="img-fluid" alt="<?php echo $activity['title']; ?>" style="width: 500px; height: 350px; object-fit: cover;">
                </div>
                <div class="details position-relative">
                  <h3><?php echo $activity['title']; ?></h3>
                  <!-- <p><?php
                      // Truncate description if it's too long
                      $maxLength = 30; // Adjust as needed
                      $description = $activity['description'];
                      if (strlen($description) > $maxLength) {
                        $description = substr($description, 0, $maxLength) . "...";
                      }
                      echo $description;
                      ?></p> -->

                  <!-- Date Row -->
                  <div class="position-relative mt-3 text-dark">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?php echo date('F j, Y', strtotime($activity['activity_date'])); ?></span>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No activities found.</p>
        <?php endif; ?>

      </div>

    </div>

  </section>
  <!-- /Activity Section End -->

</main>

<?php include 'cmp/foot.php'; ?>