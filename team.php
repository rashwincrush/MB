<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="page-header" style="background: linear-gradient(135deg, rgb(243, 124, 33) 0%, rgb(255, 160, 80) 100%) !important;">
    <div class="container text-center py-5">
        <h1 class="display-4 mb-3 text-white">Our Leadership Team</h1>
        <p class="lead text-white">The dedicated individuals driving our mission of community transformation</p>
    </div>
</section>

<!-- Team Section -->
<section class="team-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- President -->
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-image-container">
                        <img src="<?php echo get_base_url(); ?>/assets/images/team/president.jpg" alt="Trust President" class="img-fluid team-image">
                        <div class="team-social">
                            <a href="https://www.linkedin.com/in/ashwin-kumar-612021124/" target="_blank" class="social-icon"><i class="fab fa-linkedin"></i></a>
                            <a href="https://www.facebook.com/rashwincrush" target="_blank" class="social-icon"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3>R Ashwin Kumar Pushanam</h3>
                        <p class="designation text-orange">President</p>
                        <p class="description">A visionary leader with over 25 years of experience in social development and community welfare.</p>
                    </div>
                </div>
            </div>

            <!-- Secretary -->
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-image-container">
                        <img src="<?php echo get_base_url(); ?>/assets/images/team/secretary.jpg" alt="Trust Secretary" class="img-fluid team-image">
                        <div class="team-social">
                            <a href="https://www.facebook.com/anithaammu" target="_blank" class="social-icon"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3>Ms. Anitha Paulrajun</h3>
                        <p class="designation text-orange">Secretary</p>
                        <p class="description">Instrumental in strategic planning and operational management of the trust's initiatives.</p>
                    </div>
                </div>
            </div>

            <!-- Project Coordinator -->
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-image-container">
                        <img src="<?php echo get_base_url(); ?>/assets/images/team/project_coordinator.jpg" alt="Project Coordinator" class="img-fluid team-image">
                        <div class="team-social">
                            <a href="https://www.linkedin.com/in/dr-manimegalai-manoharan-4b7772104/" target="_blank" class="social-icon"><i class="fab fa-linkedin"></i></a>
                            <a href="https://www.instagram.com/dr_manimegalai/" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3>Dr. Manimegalai Manoharan</h3>
                        <p class="designation text-orange">Project Coordinator</p>
                        <p class="description">Manages project implementation, tracking progress, and ensuring effective resource allocation.</p>
                    </div>
                </div>
            </div>

            <!-- Volunteer Program Advisor -->
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-image-container">
                        <img src="<?php echo get_base_url(); ?>/assets/images/team/volunteer_advisor.jpg" alt="Volunteer Program Advisor" class="img-fluid team-image">
                        <div class="team-social">
                            <a href="https://www.facebook.com/jeevanphotoart" target="_blank" class="social-icon"><i class="fab fa-facebook"></i></a>
                            <a href="https://www.instagram.com/jeevan_hummins/" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3>Mr. Jeevan Venkatesh</h3>
                        <p class="designation text-orange">Volunteer Program Advisor</p>
                        <p class="description">Develops and nurtures volunteer engagement strategies to maximize community impact.</p>
                    </div>
                </div>
            </div>

            <!-- Project Development Advisor -->
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-image-container">
                        <img src="<?php echo get_base_url(); ?>/assets/images/team/project_advisor.jpg" alt="Project Development Advisor" class="img-fluid team-image">
                        <div class="team-social">
                            <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3>Mr. Dhanraj Neelakandan</h3>
                        <p class="designation text-orange">Project Development Advisor</p>
                        <p class="description">Strategizes long-term project development and identifies innovative solutions for community challenges.</p>
                    </div>
                </div>
            </div>

            <!-- Community Outreach Advisor -->
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-image-container">
                        <img src="<?php echo get_base_url(); ?>/assets/images/team/outreach_advisor.jpg" alt="Community Outreach Advisor" class="img-fluid team-image">
                        <div class="team-social">
                            <a href="https://www.instagram.com/socialactivistabiramibalaji/" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.facebook.com/abirami.balaji.77" target="_blank" class="social-icon"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3>Mrs. Abirami Balaji</h3>
                        <p class="designation text-orange">Community Outreach Advisor</p>
                        <p class="description">Builds and maintains strong community relationships, ensuring our initiatives resonate with local needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.team-section {
    background-color: var(--gray-light);
}

.team-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.team-image-container {
    position: relative;
    overflow: hidden;
}

.team-image {
    width: 100%;
    height: 350px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-card:hover .team-image {
    transform: scale(1);
}

.team-social {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(242, 124, 37, 0.8);
    display: flex;
    justify-content: center;
    padding: 10px 0;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.team-card:hover .team-social {
    opacity: 1;
}

.social-icon {
    color: white;
    margin: 0 10px;
    font-size: 1.5rem;
    transition: color 0.3s ease;
}

.social-icon:hover {
    color: var(--white);
    transform: scale(1.2);
}

.team-content {
    padding: 20px;
    text-align: center;
}

.team-content h3 {
    margin-bottom: 10px;
    color: #333;
}

.team-content .designation {
    margin-bottom: 15px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.team-content .description {
    color: var(--gray);
    font-size: 0.9rem;
}

/* Specific positioning for each team member */
.team-card:nth-child(1) .team-image { /* President */
    object-position: center 19%;
}

.team-card:nth-child(2) .team-image { /* Secretary */
    object-position: center 25%;
}

.team-card:nth-child(3) .team-image { /* Project Coordinator */
    object-position: center 30%;
}

.team-card:nth-child(4) .team-image { /* Volunteer Program Advisor */
    object-position: center 40%;
}

.team-card:nth-child(5) .team-image { /* Project Development Advisor */
    object-position: left 35%;
    transform-origin: left center;
}

.team-card:nth-child(5):hover .team-image { /* Project Development Advisor hover effect */
    transform: translateY(50px) scale(1.8);
}

.team-card:nth-child(6) .team-image { /* Community Outreach Advisor */
    object-position: center 45%;
}

@media (max-width: 768px) {
    .team-image {
        height: 250px;
    }
}
</style>

<?php include 'includes/footer.php'; ?>