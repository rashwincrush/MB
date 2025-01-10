<?php include 'includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Get in touch with us for any queries or support</p>
    </div>
</section>

<section class="contact-section section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Our Location</h3>
                    <p>123 NGO Street, Anna Nagar<br>Chennai, Tamil Nadu 600040<br>India</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-phone-alt"></i>
                    <h3>Phone Numbers</h3>
                    <p>
                        Main Office: +91 XXXXXXXXXX<br>
                        Support: +91 XXXXXXXXXX<br>
                        Emergency: +91 XXXXXXXXXX
                    </p>
                </div>
                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Email Addresses</h3>
                    <p>
                        General Inquiries: info@managalabhrathi.org<br>
                        Support: support@managalabhrathi.org<br>
                        Donations: donate@managalabhrathi.org
                    </p>
                </div>
                <div class="info-card">
                    <i class="fas fa-clock"></i>
                    <h3>Working Hours</h3>
                    <p>
                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 1:00 PM<br>
                        Sunday: Closed
                    </p>
                </div>
            </div>

            <div class="contact-form-container">
                <h2>Send us a Message</h2>
                <form id="contactForm" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>
        </div>

        <div class="map-section">
            <h2>Find Us on Map</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.0080749362133!2d80.20901631482583!3d13.086249990773457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5265ea4f7d3361%3A0x6e61a70b6863d433!2sAnna%20Nagar%2C%20Chennai%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How can I volunteer with Managalabhrathi Trust?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>You can volunteer by filling out our volunteer form or contacting our office. We have various volunteering opportunities available throughout the year.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How are donations utilized?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>100% of donations go directly to our programs. We maintain complete transparency in fund utilization and provide regular updates to our donors.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can I get a tax exemption certificate?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we provide 80G tax exemption certificates for all donations. The certificate will be sent to your registered email address.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal" id="success-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <h2>Message Sent Successfully!</h2>
            <p>Thank you for contacting us. We will get back to you shortly.</p>
            <button class="btn" onclick="window.location.reload()">Close</button>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
