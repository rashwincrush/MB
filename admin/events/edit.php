<?php
require_once '../../includes/config.php';
require_once '../includes/auth.php';
checkLogin();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$event_id = (int)$_GET['id'];
$event = $conn->query("SELECT * FROM events WHERE id = $event_id")->fetch_assoc();
$media = $conn->query("SELECT * FROM event_media WHERE event_id = $event_id");

if (!$event) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $category = $conn->real_escape_string($_POST['category']);
    $location = $conn->real_escape_string($_POST['location']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update event
    $sql = "UPDATE events SET 
            title = '$title',
            description = '$description',
            event_date = '$event_date',
            category = '$category',
            location = '$location',
            status = '$status'
            WHERE id = $event_id";
    
    if ($conn->query($sql)) {
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = '../../uploads/events/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['images']['name'][$key];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_file_name = uniqid() . '.' . $file_ext;
                
                if (move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
                    $media_url = 'uploads/events/' . $new_file_name;
                    $conn->query("INSERT INTO event_media (event_id, media_type, media_url) 
                                VALUES ($event_id, 'image', '$media_url')");
                }
            }
        }

        // Handle image deletions
        if (isset($_POST['delete_media'])) {
            foreach ($_POST['delete_media'] as $media_id) {
                $media_info = $conn->query("SELECT media_url FROM event_media WHERE id = $media_id")->fetch_assoc();
                if ($media_info) {
                    $file_path = '../../' . $media_info['media_url'];
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    $conn->query("DELETE FROM event_media WHERE id = $media_id");
                }
            }
        }

        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #f59824;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
        }
        .sidebar .nav-link:hover {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        .main-content {
            padding: 20px;
        }
        .media-preview {
            position: relative;
            display: inline-block;
            margin: 10px;
        }
        .media-preview img {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
        }
        .delete-media {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255,255,255,0.8);
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <h3 class="text-center mb-4">Admin Panel</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-calendar-alt me-2"></i>Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../donations">
                            <i class="fas fa-hand-holding-heart me-2"></i>Donations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../team">
                            <i class="fas fa-users me-2"></i>Team
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../partners">
                            <i class="fas fa-handshake me-2"></i>Partners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../blog">
                            <i class="fas fa-blog me-2"></i>Blog
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-danger" href="../logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Edit Event</h2>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Events
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Event Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Date</label>
                                    <input type="date" name="event_date" class="form-control" value="<?php echo $event['event_date']; ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="Food Distribution" <?php echo $event['category'] == 'Food Distribution' ? 'selected' : ''; ?>>Food Distribution</option>
                                        <option value="Medical Camp" <?php echo $event['category'] == 'Medical Camp' ? 'selected' : ''; ?>>Medical Camp</option>
                                        <option value="Education" <?php echo $event['category'] == 'Education' ? 'selected' : ''; ?>>Education</option>
                                        <option value="Community Outreach" <?php echo $event['category'] == 'Community Outreach' ? 'selected' : ''; ?>>Community Outreach</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="Upcoming" <?php echo $event['status'] == 'Upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                                        <option value="Past" <?php echo $event['status'] == 'Past' ? 'selected' : ''; ?>>Past</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div class="media-container">
                                    <?php while ($item = $media->fetch_assoc()): ?>
                                        <div class="media-preview">
                                            <img src="../../<?php echo htmlspecialchars($item['media_url']); ?>" alt="Event Image">
                                            <button type="button" class="delete-media" onclick="toggleMediaDeletion(<?php echo $item['id']; ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="checkbox" name="delete_media[]" value="<?php echo $item['id']; ?>" style="display: none;">
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Add New Images</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">You can select multiple images</small>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMediaDeletion(mediaId) {
            const checkbox = document.querySelector(`input[value="${mediaId}"]`);
            const button = checkbox.parentElement.querySelector('.delete-media');
            checkbox.checked = !checkbox.checked;
            button.style.background = checkbox.checked ? '#dc3545' : 'rgba(255,255,255,0.8)';
            button.style.color = checkbox.checked ? 'white' : 'black';
        }
    </script>
</body>
</html>
