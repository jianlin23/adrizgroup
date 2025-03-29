<?php include 'cmp/head.php'; ?>
<?php include 'cmp/fetchActivity.php'; ?>

<?php

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get language from URL parameter or session
$preferredLanguage = isset($_GET['preferredLanguage']) ? $_GET['preferredLanguage'] : (isset($_SESSION['preferredLanguage']) ? $_SESSION['preferredLanguage'] : 'en');

// Validate language
$allowedLanguages = ['bm', 'en'];
$preferredLanguage = in_array($preferredLanguage, $allowedLanguages) ? $preferredLanguage : 'en';

// Store in session
$_SESSION['preferredLanguage'] = $preferredLanguage;

// Get the activityID from the query string (URL)
$activityID = isset($_GET['activityID']) ? (int)$_GET['activityID'] : null;

try {
    // Include database configuration
    $config = require('cmp/config.php');
    
    // Create PDO connection with error handling
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $config['username'], $config['password'], $options);

    $stmt = $pdo->prepare("SELECT * FROM activities WHERE id = :activityID AND language = :language");
    $stmt->bindParam(':activityID', $activityID, PDO::PARAM_INT);
    $stmt->bindParam(':language', $preferredLanguage, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the activity data
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch the latest 3 activities for the "Latest Activities" section
    $stmt = $pdo->prepare("SELECT id, title, description, media, activity_date FROM activities WHERE language = :language ORDER BY activity_date DESC LIMIT 3");
    $stmt->bindParam(':language', $preferredLanguage, PDO::PARAM_STR);
    $stmt->execute();
    $latestActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
    exit;
}

?>

<style>
    .fixed-size-img {
        width: 600px;
        height: 500px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>

<main class="main">

    <?php if ($activity): ?>

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
            <div class="container position-relative">
                <h1 class="theme-color"><?php echo htmlspecialchars($activity['title']); ?></h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current"><?php echo htmlspecialchars($activity['title']); ?></li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Service Details Section -->
        <section id="service-details" class="service-details section">

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                        <img src="<?php echo htmlspecialchars($activity['media']); ?>" alt="" class="img-fluid services-img fixed-size-img">
                    </div>

                    <div class="col-lg-5" data-aos="fade-up" data-aos-delay="200">
                        <h3><?php echo htmlspecialchars($activity['title']); ?></h3>

                        <!-- Activity Date -->
                        <div class="activity-date mt-2 mb-3 theme-color">
                            <i class="fas fa-calendar-alt"></i>
                            <span><?php echo date('F j, Y', strtotime($activity['activity_date'])); ?></span>
                        </div>

                        <p><?php echo htmlspecialchars($activity['description']); ?></p>

                        <!-- <ul>
                            <li><i class="bi bi-check-circle"></i> <span>Aut eum totam accusantium voluptatem.</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Assumenda et porro nisi nihil nesciunt voluptatibus.</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea</span></li>
                        </ul> -->
                    </div>

                </div>

            </div>

        </section><!-- /Service Details Section -->

    <?php else: // If product does not exist, show an error message 
    ?>
        <div class="d-flex flex-column justify-content-center align-items-center vh-100 text-center" style="background-color:#121e27;">
            <h1 class="theme-color">Activity Not Found</h1>
            <p class="text-white">Sorry, the activity you are looking for does not exist.</p>
            <a href="index" class="btn btn-primary">Go Back to Home</a>
        </div>
    <?php endif; ?>

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section services">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up" data-aos-delay="100">
            <h2>Latest Activities</h2>
            <p>Explore More<br></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <div class="row gy-5">

                <?php if (isset($latestActivities) && !empty($latestActivities)): ?>
                    <?php foreach ($latestActivities as $activity): ?>
                        <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <a class="service-item stretched-link" href="activity_details.php?activityID=<?php echo $activity['id']; ?>">
                                <div class="img">
                                    <img src="<?php echo $activity['media']; ?>" class="img-fluid" alt="<?php echo $activity['title']; ?>" style="width: 500px; height: 350px; object-fit: cover;">
                                </div>
                                <div class="details position-relative">
                                    <h3><?php echo $activity['title']; ?></h3>

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

    </section><!-- /Starter Section Section -->

</main>

<?php include 'cmp/foot.php'; ?>