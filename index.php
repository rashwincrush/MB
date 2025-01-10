<?php 
// Initialize the page
require_once 'includes/config.php';
?>

<?php include 'includes/header.php'; ?>

<!-- Hero Section with Image Slider -->
<section class="hero-slider">
    <div class="hero-slides">
        <div class="hero-slide active">
            <div class="hero-content">
                <h1>Welcome to Managalabhrathi Trust</h1>
                <p>Serving the deserving....</p>
                <a href="donate.php" class="btn btn-primary">Make a Difference</a>
            </div>
        </div>
    </div>
</section>

<!-- Mission Statement -->
<section class="mission-section section">
    <div class="container">
        <h2>Our Mission</h2>
        <p>To empower and uplift communities through sustainable initiatives in education, healthcare, nutrition, sports, and environmental conservation.</p>
    </div>
</section>

<!-- Impact Areas -->
<section class="impact-areas section">
    <div class="container">
        <h2>Our Impact Areas</h2>
        <div class="impact-grid">
            <div class="impact-item">
                <i class="fas fa-utensils"></i>
                <h3>Food Security</h3>
                <p>Ensuring nutritious meals reach those in need</p>
            </div>
            <div class="impact-item">
                <i class="fas fa-graduation-cap"></i>
                <h3>Education</h3>
                <p>Supporting students through resources and scholarships</p>
            </div>
            <div class="impact-item">
                <i class="fas fa-heartbeat"></i>
                <h3>Healthcare</h3>
                <p>Providing medical assistance and health awareness</p>
            </div>
            <div class="impact-item">
                <i class="fas fa-futbol"></i>
                <h3>Sports</h3>
                <p>Nurturing athletic talent and promoting fitness</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
