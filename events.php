<?php
// Include necessary files
include 'includes/header.php';
include 'includes/config.php';

// Function to safely truncate text
function truncateText($text, $length = 150, $ellipsis = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return rtrim(substr($text, 0, $length)) . $ellipsis;
}

// Function to safely load image
function getEventImage($image) {
    $imagePath = "/assets/images/events/" . htmlspecialchars($image);
    $defaultImage = "/assets/images/events/default.jpg";
    
    // Check if image exists, if not use default
    return file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath) ? $imagePath : $defaultImage;
}

// Establish database connection
$conn = get_db_connection();

if (!$conn) {
    die("Database connection failed");
}

// Fetch upcoming events
$upcoming_sql = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date";
$upcoming_result = $conn->query($upcoming_sql);

// Fetch past events
$past_sql = "SELECT * FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC LIMIT 6";
$past_result = $conn->query($past_sql);
?>

<section class="page-header">
    <div class="container">
        <h1>Events</h1>
    </div>
</section>

<section class="events-section section">
    <div class="container">
        <div class="events-tabs">
            <button class="tab-btn active" data-tab="upcoming">Upcoming Events</button>
            <button class="tab-btn" data-tab="past">Past Events</button>
        </div>

        <div class="tab-content" id="upcoming-events">
            <div class="events-list">
                <?php
                if ($upcoming_result->num_rows > 0) {
                    while($row = $upcoming_result->fetch_assoc()) {
                        ?>
                        <div class="event-card">
                            <div class="event-image">
                                <img src="<?php echo getEventImage($row['image']); ?>" alt="Event Image">
                            </div>
                            <div class="event-details">
                                <div class="event-date">
                                    <span class="date"><?php echo date('d', strtotime($row['event_date'])); ?></span>
                                    <span class="month"><?php echo date('M', strtotime($row['event_date'])); ?></span>
                                </div>
                                <div class="event-info">
                                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                    <p class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></p>
                                    <p class="event-description"><?php echo truncateText(htmlspecialchars($row['description'])); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="no-events">No upcoming events at the moment.</p>';
                }
                ?>
            </div>
        </div>

        <div class="tab-content hidden" id="past-events">
            <div class="past-events-grid">
                <?php
                if ($past_result->num_rows > 0) {
                    while($row = $past_result->fetch_assoc()) {
                        ?>
                        <div class="past-event-card">
                            <img src="<?php echo getEventImage($row['image']); ?>" alt="Past Event">
                            <div class="past-event-content">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p class="event-date"><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($row['event_date'])); ?></p>
                                <p class="event-description"><?php echo truncateText(htmlspecialchars($row['description'])); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="no-events">No past events to display.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php 
// Close database connection
$conn->close();

// Include footer
include 'includes/footer.php'; 
?>