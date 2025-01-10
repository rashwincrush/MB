<?php 
// Initialize base URL and include necessary files
require_once 'includes/config.php';

// Get database connection
$conn = get_db_connection();

// Include header
include 'includes/header.php'; 

// Fetch upcoming events from the database
$current_date = date('Y-m-d');
$sql = "SELECT * FROM events WHERE event_date >= '$current_date' ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<section class="upcoming-events-section section">
    <div class="container">
        <h1 class="section-title text-center mb-4">Upcoming Events</h1>
        
        <div class="row">
            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Function to get event image (reusing from events.php)
                    function getEventImage($image) {
                        $default_image = get_base_url() . '/assets/images/events/default-event.jpg';
                        return !empty($image) && file_exists('assets/images/events/' . $image) 
                            ? get_base_url() . '/assets/images/events/' . $image 
                            : $default_image;
                    }

                    // Function to truncate text
                    function truncateText($text, $length = 150, $ellipsis = '...') {
                        return (strlen($text) > $length) 
                            ? substr($text, 0, $length) . $ellipsis 
                            : $text;
                    }

                    $event_image = getEventImage($row['event_image']);
                    $event_description = truncateText($row['event_description']);
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card event-card">
                        <img src="<?php echo $event_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['event_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['event_name']); ?></h5>
                            <p class="card-text"><?php echo $event_description; ?></p>
                            <p class="card-date">
                                <i class="fas fa-calendar-alt"></i> 
                                <?php echo date('F j, Y', strtotime($row['event_date'])); ?>
                            </p>
                            <a href="event-details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo '<div class="col-12 text-center"><p class="no-events">No upcoming events at the moment.</p></div>';
            }
            ?>
        </div>
    </div>
</section>

<?php 
// Close database connection
$conn->close();

// Include footer
include 'includes/footer.php'; 
?>
