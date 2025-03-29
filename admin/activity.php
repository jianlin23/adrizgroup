<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Load database configuration
$config = require_once('../cmp/config.php');

// Establish database connection
try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['username'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            switch ($_POST['action']) {
                case 'add':
                    try {
                        // Add activity
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $media = null;
                        $activity_date = $_POST['activity_date'];  // Get activity date from form
                        $language = $_POST['language'] ?? $_SESSION['preferredLanguage'] ?? 'en';  // Get language from POST or session (default to 'en')

                        // File Upload Handling
                        if (!empty($_FILES['media']['name'])) {
                            $uploadsDir = '../uploads/';

                            // Check if the directory exists, create it if it doesn't
                            if (!is_dir($uploadsDir)) {
                                mkdir($uploadsDir, 0755, true); // Creates the directory with proper permissions
                            }

                            $media = $uploadsDir . '/' . basename($_FILES['media']['name']);
                            move_uploaded_file($_FILES['media']['tmp_name'], $media);
                        }

                        // Insert into the database, including the language field
                        $stmt = $pdo->prepare("INSERT INTO activities (title, description, media, activity_date, language) 
                                               VALUES (:title, :description, :media, :activity_date, :language)");
                        $stmt->execute([
                            ':title' => $title,
                            ':description' => $description,
                            ':media' => $media,
                            ':activity_date' => $activity_date,
                            ':language' => $language,  // Include language in the insert statement
                        ]);

                        // After successful CRUD operation
                        $_SESSION['message'] = 'Activity added successfully'; // Change based on the operation
                        $_SESSION['message_type'] = 'success'; // Use 'success', 'error', 'warning', etc.
                    } catch (PDOException $e) {
                        $_SESSION['message'] = 'Error adding activity: ' . $e->getMessage();
                        $_SESSION['message_type'] = 'error';
                    }
                    header("Location: activity.php");
                    exit();

                case 'edit':
                    try {
                        // Edit activity
                        $id = $_POST['id'];
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $media = $_POST['existing_media'];
                        $activity_date = $_POST['activity_date'];  // Get updated activity date from form

                        // Handle file upload
                        if (!empty($_FILES['media']['name'])) {
                            $media = '../uploads/' . basename($_FILES['media']['name']);
                            move_uploaded_file($_FILES['media']['tmp_name'], $media);
                        }

                        $stmt = $pdo->prepare("UPDATE activities 
                        SET title = :title, description = :description, media = :media, 
                            activity_date = :activity_date, updated_at = NOW() 
                        WHERE id = :id");

                        $stmt->execute([
                            ':title' => $title,
                            ':description' => $description,
                            ':media' => $media,
                            ':activity_date' => $activity_date,
                            ':id' => $id,
                        ]);
                        // After successful CRUD operation
                        $_SESSION['message'] = 'Activity updated successfully'; // Change based on the operation
                        $_SESSION['message_type'] = 'success'; // Use 'success', 'error', 'warning', etc.
                    } catch (PDOException $e) {
                        $_SESSION['message'] = 'Error updating activity: ' . $e->getMessage();
                        $_SESSION['message_type'] = 'error';
                    }
                    header("Location: activity.php");
                    exit();

                case 'delete':
                    try {
                        $id = $_POST['id'];
                        $stmt = $pdo->prepare("DELETE FROM activities WHERE id = :id");
                        $stmt->execute([':id' => $id]);

                        $_SESSION['message'] = 'Activity deleted successfully';
                        $_SESSION['message_type'] = 'success';
                    } catch (PDOException $e) {
                        $_SESSION['message'] = 'Error deleting activity: ' . $e->getMessage();
                        $_SESSION['message_type'] = 'error';
                    }
                    header("Location: activity.php");
                    exit();
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

// Fetch activities for display
$activities = [];
try {
    $stmt = $pdo->query("SELECT * FROM activities ORDER BY created_at DESC");
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching activities: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Adriz World | Dashboard</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="jianlin">

    <link href="/assets/img/logo.png" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --accent-color: #ffc60a;
        }

        .bg-custom-dark {
            background-color: #212529;
        }

        .btn-custom {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: black;
        }

        .btn-custom:hover {
            background-color: #e6b009;
            border-color: #e6b009;
            color: black;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 198, 10, 0.1);
        }

        .sidebar {
            background-color: #212529;
            min-height: 100vh;
        }

        .nav-link {
            color: white;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--accent-color);
        }

        .activity-img {
            width: 450px;
            height: 450px;
            object-fit: cover;
        }

        .logo {
            height: 40px;
            margin-right: 10px;
        }

        .preview-image {
            max-width: 400px;
            max-height: 300px;
            margin-top: 10px;
            display: none;
        }

        .preview-video {
            max-width: 400px;
            max-height: 300px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-1 sidebar p-3">
                <a href="activity.php" style="text-decoration:none;">
                    <h5 class="text-white mb-4 d-flex align-items-center justify-content-center">
                        <img src="/assets/img/logo.png" alt="Logo" class="logo"> Adriz Admin
                    </h5>
                </a>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="activity.php">
                            <i class="fas fa-tasks me-2"></i>Activities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-11 bg-light p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Manage Activities</h2>
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        <i class="fas fa-plus me-2"></i>Add New Activity
                    </button>
                </div>

                <!-- Activities Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-custom-dark text-white">
                                    <tr>
                                        <th>Media</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Language</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($activities as $activity): ?>
                                        <tr>
                                            <td>
                                                <img src="<?= htmlspecialchars($activity['media']) ?>" alt="Activity Media" class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td><?= htmlspecialchars($activity['title']) ?></td>
                                            <td>
                                                <table>
                                                    <?php
                                                    $maxLength = 100; // Adjust as needed
                                                    $description = htmlspecialchars($activity['description']);

                                                    // Split description into chunks
                                                    $chunks = str_split($description, $maxLength);

                                                    // Display chunks in separate table rows
                                                    foreach ($chunks as $chunk) {
                                                        echo "<tr><td>{$chunk}</td></tr>";
                                                    }
                                                    ?>
                                                </table>
                                            </td>
                                            <td><?= htmlspecialchars($activity['language']) ?></td>
                                            <td>
                                                <button class="btn btn-custom btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editActivityModal<?= $activity['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" action="activity.php" class="d-inline">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $activity['id'] ?>">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $activity['id'] ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal for Each Activity -->
                                        <div class="modal fade" id="editActivityModal<?= $activity['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-custom-dark text-white">
                                                        <h5 class="modal-title">Edit Activity</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="activity.php" enctype="multipart/form-data">
                                                            <input type="hidden" name="action" value="edit">
                                                            <input type="hidden" name="id" value="<?= $activity['id'] ?>">
                                                            <input type="hidden" name="existing_media" value="<?= htmlspecialchars($activity['media']) ?>">

                                                            <div class="mb-3">
                                                                <label class="form-label">Media Preview</label>
                                                                <div class="d-flex justify-content-center align-items-center mb-5">
                                                                    <!-- Default Image Preview if there is an existing media -->
                                                                    <img id="image-preview<?= $activity['id'] ?>" src="<?= !empty($activity['media']) ? htmlspecialchars($activity['media']) : '' ?>" alt="Current Image" class="preview-image rounded" style="max-width: 100%; <?= empty($activity['media']) ? 'display: none;' : '' ?>">

                                                                    <!-- Default Video Preview if there is an existing media -->
                                                                    <video id="video-preview<?= $activity['id'] ?>" src="<?= !empty($activity['media']) ? htmlspecialchars($activity['media']) : '' ?>" controls class="preview-video rounded" style="max-width: 100%; <?= empty($activity['media']) ? 'display: none;' : '' ?>"></video>
                                                                </div>
                                                                <input type="file" class="form-control" name="media" id="media<?= $activity['id'] ?>" accept="image/*, video/*">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Language</label>
                                                                <select class="form-control" name="language" required>
                                                                    <option value="en" <?= $activity['language'] == 'en' ? 'selected' : '' ?>>English</option>
                                                                    <option value="bm" <?= $activity['language'] == 'bm' ? 'selected' : '' ?>>Bahasa Malaysia</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($activity['title']) ?>" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($activity['description']) ?></textarea>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="activity_date" class="form-label">Activity Date</label>
                                                                <input type="date" class="form-control" id="activity_date" name="activity_date" value="<?= date('Y-m-d', strtotime($activity['activity_date'])) ?>" required>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-custom">Update Activity</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Activity Modal -->
    <div class="modal fade" id="addActivityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-custom-dark text-white">
                    <h5 class="modal-title">Add New Activity</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="activity.php" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="media" class="form-label">Media</label>
                            <input type="file" class="form-control" id="media" name="media" accept="image/*, video/*" required>
                        </div>

                        <!-- Language Selection -->
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-control" id="language" name="language" required>
                                <option value="en">English</option>
                                <option value="bm">Bahasa Malaysia</option>
                            </select>
                        </div>

                        <!-- Title Input -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter activity title" required>
                        </div>

                        <!-- Description Input -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter activity description" required></textarea>
                        </div>

                        <!-- Activity Date Input -->
                        <div class="mb-3">
                            <label for="activity_date" class="form-label">Activity Date</label>
                            <input type="date" class="form-control" id="activity_date" name="activity_date" required>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-custom">Save Activity</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(activityId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form via POST
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'activity.php';

                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = 'delete';

                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    idInput.value = activityId;

                    form.appendChild(actionInput);
                    form.appendChild(idInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure you want to log out?',
                text: "You will need to log in again to access the system.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, log out',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to logout.php
                    window.location.href = 'logout.php';
                }
            });
        }

        // Image/Video Preview
        <?php foreach ($activities as $activity): ?>
            // Set the initial media preview based on the existing media URL
            document.addEventListener('DOMContentLoaded', function() {
                const mediaInput = document.getElementById('media<?= $activity['id'] ?>');
                const imagePreview = document.getElementById('image-preview<?= $activity['id'] ?>');
                const videoPreview = document.getElementById('video-preview<?= $activity['id'] ?>');

                // If there's an existing media, display the correct preview
                const existingMedia = "<?= !empty($activity['media']) ? htmlspecialchars($activity['media']) : '' ?>";

                if (existingMedia) {
                    if (existingMedia.match(/\.(jpg|jpeg|png|gif)$/i)) {
                        imagePreview.src = existingMedia;
                        imagePreview.style.display = 'block';
                        videoPreview.style.display = 'none';
                    } else if (existingMedia.match(/\.(mp4|webm|ogg)$/i)) {
                        videoPreview.src = existingMedia;
                        videoPreview.style.display = 'block';
                        imagePreview.style.display = 'none';
                    }
                }

                // Handle file change and update preview
                mediaInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const fileType = file.type;

                        imagePreview.style.display = 'none';
                        videoPreview.style.display = 'none';

                        // If it's an image, show the image preview
                        if (fileType.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                imagePreview.src = e.target.result;
                                imagePreview.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        }
                        // If it's a video, show the video preview
                        else if (fileType.startsWith('video/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                videoPreview.src = e.target.result;
                                videoPreview.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                });
            });
        <?php endforeach; ?>
    </script>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['message_type'] ?>', // success, error, warning, info
                title: '<?= $_SESSION['message'] ?>',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

</body>

</html>