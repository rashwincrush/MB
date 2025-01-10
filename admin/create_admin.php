<?php
require_once '../includes/config.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$email = 'mangalabharathitrust@gmail.com';
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $password, $email, $role);

if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Error creating admin user: " . $conn->error;
}
?>
