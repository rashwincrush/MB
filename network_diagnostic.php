<?php
// Disable error reporting for clean output
error_reporting(0);

// Network and Database Connection Diagnostic Script
$tests = [
    'Hostname Resolution' => function() {
        $hostname = 'auth-db1749.hstgr.io';
        $ip = gethostbyname($hostname);
        return $ip !== $hostname ? 
            ["status" => "success", "message" => "Hostname resolves to IP: $ip"] : 
            ["status" => "error", "message" => "Cannot resolve hostname"];
    },
    
    'Port Connectivity' => function() {
        $hostname = 'auth-db1749.hstgr.io';
        $port = 3306;
        $timeout = 5;
        
        $socket = @fsockopen($hostname, $port, $errno, $errstr, $timeout);
        if ($socket) {
            fclose($socket);
            return ["status" => "success", "message" => "Port $port is open"];
        } else {
            return ["status" => "error", "message" => "Cannot connect to port $port. Error: $errstr ($errno)"];
        }
    },
    
    'PHP MySQL Extension' => function() {
        return extension_loaded('mysqli') ? 
            ["status" => "success", "message" => "MySQLi extension is loaded"] : 
            ["status" => "error", "message" => "MySQLi extension not loaded"];
    },
    
    'Server Environment' => function() {
        return [
            "status" => "info",
            "message" => "PHP Version: " . PHP_VERSION,
            "additional" => [
                "OS" => PHP_OS,
                "Server API" => PHP_SAPI
            ]
        ];
    }
];

// Run tests
$results = [];
foreach ($tests as $name => $test) {
    $results[$name] = $test();
}

// Output results
header('Content-Type: application/json');
echo json_encode([
    'timestamp' => date('Y-m-d H:i:s'),
    'results' => $results
], JSON_PRETTY_PRINT);
?>
