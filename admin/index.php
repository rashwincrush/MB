<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

// Ensure user is logged in
require_admin();

// Get dashboard statistics
$stats = [
    'total_events' => 0,
    'upcoming_events' => 0,
    'total_donations' => 0,
    'total_amount' => 0
];

// Get events statistics
$events_query = "SELECT 
    COUNT(*) as total_events,
    SUM(CASE WHEN status = 'Upcoming' THEN 1 ELSE 0 END) as upcoming_events
FROM events";
$events_result = $conn->query($events_query);
if ($events_result) {
    $events_stats = $events_result->fetch_assoc();
    $stats['total_events'] = $events_stats['total_events'];
    $stats['upcoming_events'] = $events_stats['upcoming_events'];
}

// Get donations statistics
$donations_query = "SELECT 
    COUNT(*) as total_donations,
    SUM(amount) as total_amount
FROM donations";
$donations_result = $conn->query($donations_query);
if ($donations_result) {
    $donations_stats = $donations_result->fetch_assoc();
    $stats['total_donations'] = $donations_stats['total_donations'];
    $stats['total_amount'] = $donations_stats['total_amount'] ?? 0;
}

// Get recent events
$recent_events_query = "SELECT * FROM events ORDER BY created_at DESC LIMIT 5";
$recent_events = $conn->query($recent_events_query);

// Get recent donations
$recent_donations_query = "SELECT * FROM donations ORDER BY created_at DESC LIMIT 5";
$recent_donations = $conn->query($recent_donations_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold">Admin Dashboard</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="logout.php" class="text-gray-500 hover:text-gray-700">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Events</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $stats['total_events']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Upcoming Events</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $stats['upcoming_events']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Donations</dt>
                                        <dd class="text-lg font-medium text-gray-900"><?php echo $stats['total_donations']; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Amount</dt>
                                        <dd class="text-lg font-medium text-gray-900">₹<?php echo number_format($stats['total_amount'], 2); ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Events -->
                <div class="mt-8">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Events</h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <ul class="divide-y divide-gray-200">
                                <?php if ($recent_events && $recent_events->num_rows > 0): ?>
                                    <?php while ($event = $recent_events->fetch_assoc()): ?>
                                        <li class="px-4 py-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($event['title']); ?></h4>
                                                    <p class="text-sm text-gray-500"><?php echo date('F j, Y', strtotime($event['event_date'])); ?></p>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo ucfirst(strtolower($event['status'])); ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <li class="px-4 py-4">No events found</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Recent Donations -->
                <div class="mt-8">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Donations</h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <ul class="divide-y divide-gray-200">
                                <?php if ($recent_donations && $recent_donations->num_rows > 0): ?>
                                    <?php while ($donation = $recent_donations->fetch_assoc()): ?>
                                        <li class="px-4 py-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($donation['donor_name']); ?></h4>
                                                    <p class="text-sm text-gray-500">₹<?php echo number_format($donation['amount'], 2); ?></p>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo ucfirst(strtolower($donation['status'] ?? 'Pending')); ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <li class="px-4 py-4">No donations found</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
