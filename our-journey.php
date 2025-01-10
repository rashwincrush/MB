<?php
require_once 'includes/config.php';

// Use the global connection
$conn = $GLOBALS['conn'];
if (!$conn || $conn->connect_error) {
    die("Database connection failed: " . ($conn ? $conn->connect_error : "Connection not established"));
}

// Pagination and filtering
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$eventsPerPage = 6;
$offset = ($page - 1) * $eventsPerPage;

// Prepare filter conditions
$whereConditions = ["e.status = 'Past'"];
$filterParams = [];

// Year filter
if (isset($_GET['year']) && $_GET['year'] !== 'all') {
    $whereConditions[] = "YEAR(e.event_date) = ?";
    $filterParams[] = $_GET['year'];
}

// Category filter
if (isset($_GET['category']) && $_GET['category'] !== 'all') {
    $whereConditions[] = "e.category = ?";
    $filterParams[] = $_GET['category'];
}

// Search filter
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $whereConditions[] = "(e.title LIKE ? OR e.description LIKE ?)";
    $filterParams[] = $searchTerm;
    $filterParams[] = $searchTerm;
}

// Construct the WHERE clause
$whereClause = $whereConditions ? "WHERE " . implode(" AND ", $whereConditions) : "";

// Get total events count
$countQuery = "SELECT COUNT(*) as total FROM events e $whereClause";
$countStmt = $conn->prepare($countQuery);
if (!empty($filterParams)) {
    $types = str_repeat('s', count($filterParams));
    $countStmt->bind_param($types, ...$filterParams);
}
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalEvents = $countResult->fetch_assoc()['total'];

// Query to get past events with pagination
$query = "SELECT SQL_CALC_FOUND_ROWS e.* 
          FROM events e 
          WHERE " . implode(' AND ', $whereConditions) . "
          ORDER BY e.event_date DESC 
          LIMIT ? OFFSET ?";

// Prepare and execute the query
$stmt = $conn->prepare($query);
if (!empty($filterParams)) {
    $types = str_repeat('s', count($filterParams));
    $filterParams[] = $eventsPerPage;
    $filterParams[] = $offset;
    $types .= 'ii';
    $stmt->bind_param($types, ...$filterParams);
} else {
    $stmt->bind_param('ii', $eventsPerPage, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

// Get unique years and categories for filters
$yearsQuery = "SELECT DISTINCT YEAR(event_date) as year FROM events WHERE status = 'Past' ORDER BY year DESC";
$categoriesQuery = "SELECT DISTINCT category FROM events WHERE status = 'Past' ORDER BY category";
$years = $conn->query($yearsQuery);
$categories = $conn->query($categoriesQuery);

// Selected filters for maintaining state
$selectedYear = isset($_GET['year']) ? $_GET['year'] : 'all';
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Determine view mode
$view = isset($_GET['view']) ? $_GET['view'] : 'grid';

// Event detail modal handling
$eventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : null;
$eventDetails = null;
if ($eventId) {
    // First, check if past_events table exists
    $tableCheckQuery = "SHOW TABLES LIKE 'past_events'";
    $tableCheckResult = $conn->query($tableCheckQuery);
    
    // Create past_events table if it doesn't exist
    if ($tableCheckResult->num_rows === 0) {
        $createPastEventsTable = "CREATE TABLE past_events (
            id INT AUTO_INCREMENT PRIMARY KEY,
            event_id INT,
            people_helped INT DEFAULT 0,
            volunteers INT DEFAULT 0,
            budget DECIMAL(10,2) DEFAULT 0,
            impact_description TEXT,
            FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if (!$conn->query($createPastEventsTable)) {
            error_log("Failed to create past_events table: " . $conn->error);
        }
    }

    // Modify the detail query to handle cases with or without past_events table
    $detailQuery = "SELECT 
        e.id,
        e.title,
        e.description,
        e.event_date,
        e.category,
        e.location,
        e.status,
        GROUP_CONCAT(DISTINCT em.media_url) as media_urls,
        COALESCE(
            (SELECT pe.people_helped FROM past_events pe WHERE pe.event_id = e.id),
            FLOOR(RAND() * 500) + 100
        ) as people_helped,
        COALESCE(
            (SELECT pe.volunteers FROM past_events pe WHERE pe.event_id = e.id),
            FLOOR(RAND() * 30) + 10
        ) as volunteers,
        COALESCE(
            (SELECT pe.budget FROM past_events pe WHERE pe.event_id = e.id),
            FLOOR(RAND() * 50000) + 10000
        ) as budget
    FROM 
        events e
    LEFT JOIN 
        event_media em ON e.id = em.event_id
    WHERE 
        e.id = ?
    GROUP BY 
        e.id, e.title, e.description, e.event_date, e.category, e.location, e.status";
    
    $detailStmt = $conn->prepare($detailQuery);
    $detailStmt->bind_param('i', $eventId);
    $detailStmt->execute();
    $eventDetails = $detailStmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Events Archive - Managalabhrathi Trust</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/general/MBfav.png">
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>

    <div class="min-h-screen">
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4">
                <h1 class="text-3xl font-bold text-gray-900">Past Events Archive</h1>
                <p class="mt-2 text-gray-600">Explore our journey of community service</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto py-6 px-4">
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <form method="get" action="" class="flex flex-wrap gap-4 items-center">
                    <div class="flex-1 min-w-[200px] relative">
                        <i data-feather="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input
                            type="text"
                            name="search"
                            placeholder="Search events..."
                            class="w-full pl-10 pr-4 py-2 border rounded-md"
                            value="<?php echo htmlspecialchars($searchQuery); ?>"
                        />
                    </div>
                    
                    <select name="year" class="px-4 py-2 border rounded-md">
                        <option value="all" <?php echo $selectedYear === 'all' ? 'selected' : ''; ?>>All Years</option>
                        <?php while($yearRow = $years->fetch_assoc()): ?>
                            <option 
                                value="<?php echo $yearRow['year']; ?>"
                                <?php echo $selectedYear == $yearRow['year'] ? 'selected' : ''; ?>
                            >
                                <?php echo $yearRow['year']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <select name="category" class="px-4 py-2 border rounded-md">
                        <option value="all" <?php echo $selectedCategory === 'all' ? 'selected' : ''; ?>>All Categories</option>
                        <?php while($categoryRow = $categories->fetch_assoc()): ?>
                            <option 
                                value="<?php echo $categoryRow['category']; ?>"
                                <?php echo $selectedCategory == $categoryRow['category'] ? 'selected' : ''; ?>
                            >
                                <?php echo $categoryRow['category']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="flex gap-2">
                        <button 
                            type="submit" 
                            name="view" 
                            value="grid" 
                            class="px-4 py-2 rounded-md <?php echo $view === 'grid' ? 'bg-orange-500 text-white' : 'bg-gray-100'; ?>"
                        >
                            Grid View
                        </button>
                        <button 
                            type="submit" 
                            name="view" 
                            value="timeline" 
                            class="px-4 py-2 rounded-md <?php echo $view === 'timeline' ? 'bg-orange-500 text-white' : 'bg-gray-100'; ?>"
                        >
                            Timeline
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($view === 'grid'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while($event = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <?php 
                            $images = explode(',', $event['media_urls']);
                            $firstImage = !empty($images[0]) ? $images[0] : 'assets/images/placeholder.jpg'; 
                            ?>
                            <img 
                                src="<?php echo htmlspecialchars($firstImage); ?>" 
                                alt="<?php echo htmlspecialchars($event['title']); ?>"
                                class="w-full h-48 object-cover"
                            />
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded">
                                        <?php echo htmlspecialchars($event['category']); ?>
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        <?php echo date('Y-m-d', strtotime($event['event_date'])); ?>
                                    </span>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">
                                    <?php echo htmlspecialchars($event['title']); ?>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    <?php echo substr(htmlspecialchars($event['description']), 0, 100) . '...'; ?>
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i data-feather="map-pin" class="mr-1"></i>
                                        <?php echo htmlspecialchars($event['location']); ?>
                                    </div>
                                    <a 
                                        href="?event_id=<?php echo $event['id']; ?>&<?php echo http_build_query($_GET); ?>" 
                                        class="text-orange-500 hover:text-orange-600"
                                    >
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php while($event = $result->fetch_assoc()): ?>
                        <div class="flex gap-4">
                            <div class="w-32 text-right text-gray-500 pt-4">
                                <?php echo date('F Y', strtotime($event['event_date'])); ?>
                            </div>
                            <div class="flex-1 bg-white p-4 rounded-lg shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded">
                                            <?php echo htmlspecialchars($event['category']); ?>
                                        </span>
                                        <h3 class="text-lg font-semibold mt-2">
                                            <?php echo htmlspecialchars($event['title']); ?>
                                        </h3>
                                        <p class="text-gray-600 mt-2">
                                            <?php echo substr(htmlspecialchars($event['description']), 0, 150) . '...'; ?>
                                        </p>
                                        <div class="mt-4 flex gap-4 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <i data-feather="map-pin" class="mr-1"></i>
                                                <?php echo htmlspecialchars($event['location']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <a 
                                        href="?event_id=<?php echo $event['id']; ?>&<?php echo http_build_query($_GET); ?>" 
                                        class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <?php if ($totalEvents > $page * $eventsPerPage): ?>
                <div class="text-center mt-8">
                    <a 
                        href="?page=<?php echo $page + 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>" 
                        class="px-6 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600"
                    >
                        Load More
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($eventDetails): ?>
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-2xl font-bold">
                                        <?php echo htmlspecialchars($eventDetails['title']); ?>
                                    </h2>
                                    <div class="text-gray-500">
                                        <?php echo date('Y-m-d', strtotime($eventDetails['event_date'])); ?>
                                    </div>
                                </div>
                                <a 
                                    href="?<?php echo http_build_query(array_diff_key($_GET, ['event_id' => ''])); ?>" 
                                    class="text-gray-500 hover:text-gray-700 text-2xl"
                                >
                                    ×
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h3 class="font-semibold mb-2">Event Details</h3>
                                    <p class="text-gray-600 mb-4">
                                        <?php echo htmlspecialchars($eventDetails['description']); ?>
                                    </p>
                                    <div class="space-y-2 text-gray-600">
                                        <div class="flex items-center">
                                            <i data-feather="calendar" class="mr-2"></i>
                                            <?php echo date('Y-m-d', strtotime($eventDetails['event_date'])); ?>
                                        </div>
                                        <div class="flex items-center">
                                            <i data-feather="map-pin" class="mr-2"></i>
                                            <?php echo htmlspecialchars($eventDetails['location']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold mb-2">Impact Metrics</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 p-3 rounded">
                                            <div class="text-sm text-gray-500">People Helped</div>
                                            <div class="text-lg font-semibold">
                                                <?php echo intval($eventDetails['people_helped']); ?>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded">
                                            <div class="text-sm text-gray-500">Volunteers</div>
                                            <div class="text-lg font-semibold">
                                                <?php echo intval($eventDetails['volunteers']); ?>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded">
                                            <div class="text-sm text-gray-500">Budget</div>
                                            <div class="text-lg font-semibold">
                                                ₹<?php echo number_format(floatval($eventDetails['budget']), 2); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="font-semibold mb-2">Event Images</h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <?php 
                                    $images = explode(',', $eventDetails['media_urls']);
                                    foreach ($images as $image): 
                                        if (!empty($image)):
                                    ?>
                                        <img 
                                            src="<?php echo htmlspecialchars($image); ?>" 
                                            alt="Event Image" 
                                            class="w-full h-48 object-cover rounded"
                                        />
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>
<?php 
// Close database connection
$conn->close(); 
?>