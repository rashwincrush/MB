<?php include 'includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Make a Donation</h1>
        <p>Your contribution can make a real difference in someone's life</p>
    </div>
</section>

<section class="donation-section section">
    <div class="container">
        <div class="donation-options-container">
            <div class="donation-type">
                <h2>Choose Your Donation Type</h2>
                <div class="donation-type-buttons">
                    <button class="type-btn active" data-type="one-time">One-time Donation</button>
                    <button class="type-btn" data-type="monthly">Monthly Giving</button>
                    <button class="type-btn" data-type="project">Support a Project</button>
                </div>
            </div>

            <div class="donation-amount">
                <h3>Select Amount</h3>
                <div class="amount-buttons">
                    <button class="amount-btn" data-amount="1000">₹1,000</button>
                    <button class="amount-btn" data-amount="2000">₹2,000</button>
                    <button class="amount-btn" data-amount="5000">₹5,000</button>
                    <button class="amount-btn" data-amount="10000">₹10,000</button>
                    <div class="custom-amount">
                        <input type="number" id="customAmount" placeholder="Enter custom amount">
                    </div>
                </div>
            </div>

            <div class="donation-projects hidden">
                <h3>Select Project</h3>
                <div class="project-cards">
                    <div class="project-card">
                        <img src="/assets/images/projects/education.jpg" alt="Education Project">
                        <h4>Education Support</h4>
                        <p>Help underprivileged children access quality education</p>
                        <div class="progress-bar">
                            <div class="progress" style="width: 75%"></div>
                        </div>
                        <div class="project-stats">
                            <span>₹75,000 raised</span>
                            <span>Goal: ₹100,000</span>
                        </div>
                    </div>
                    <div class="project-card">
                        <img src="/assets/images/projects/healthcare.jpg" alt="Healthcare Project">
                        <h4>Healthcare Initiative</h4>
                        <p>Support our medical camps and healthcare programs</p>
                        <div class="progress-bar">
                            <div class="progress" style="width: 60%"></div>
                        </div>
                        <div class="project-stats">
                            <span>₹60,000 raised</span>
                            <span>Goal: ₹100,000</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-methods">
                <h3>Payment Method</h3>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="card">
                        <span class="option-label">
                            <i class="fas fa-credit-card"></i>
                            Credit/Debit Card
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="upi">
                        <span class="option-label">
                            <i class="fas fa-mobile-alt"></i>
                            UPI
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="netbanking">
                        <span class="option-label">
                            <i class="fas fa-university"></i>
                            Net Banking
                        </span>
                    </label>
                </div>
            </div>

            <div class="donor-details">
                <h3>Your Details</h3>
                <form id="donationForm">
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
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="pan">PAN Number (Optional)</label>
                            <input type="text" id="pan" name="pan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="tax_certificate" checked>
                            I would like to receive an 80G tax exemption certificate
                        </label>
                    </div>
                    <button type="submit" class="btn donate-submit-btn">Proceed to Pay</button>
                </form>
            </div>
        </div>

        <div class="donation-info">
            <div class="info-card">
                <h3>Why Donate?</h3>
                <ul>
                    <li>100% of your donation goes directly to the cause</li>
                    <li>Tax benefits under 80G</li>
                    <li>Regular updates on project progress</li>
                    <li>Transparent utilization of funds</li>
                </ul>
            </div>
            <div class="info-card">
                <h3>Recent Donors</h3>
                <div class="recent-donors">
                    <div class="donor">
                        <span class="donor-name">Rajesh K.</span>
                        <span class="donation-amount">₹5,000</span>
                    </div>
                    <div class="donor">
                        <span class="donor-name">Priya S.</span>
                        <span class="donation-amount">₹2,000</span>
                    </div>
                    <div class="donor">
                        <span class="donor-name">Anonymous</span>
                        <span class="donation-amount">₹10,000</span>
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
            <h2>Thank You for Your Donation!</h2>
            <p>Your contribution will help make a difference in someone's life.</p>
            <p>A confirmation email has been sent to your registered email address.</p>
            <button class="btn" onclick="window.location.href='/'">Back to Home</button>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
