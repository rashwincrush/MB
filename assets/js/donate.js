document.addEventListener('DOMContentLoaded', function() {
    // Donation Type Selection
    const typeButtons = document.querySelectorAll('.type-btn');
    const projectsSection = document.querySelector('.donation-projects');
    
    typeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            typeButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            if (btn.dataset.type === 'project') {
                projectsSection.classList.remove('hidden');
            } else {
                projectsSection.classList.add('hidden');
            }
        });
    });

    // Amount Selection
    const amountButtons = document.querySelectorAll('.amount-btn');
    const customAmount = document.getElementById('customAmount');
    
    amountButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            amountButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            customAmount.value = btn.dataset.amount;
        });
    });
    
    customAmount.addEventListener('input', () => {
        amountButtons.forEach(btn => btn.classList.remove('active'));
    });

    // Form Submission
    const donationForm = document.getElementById('donationForm');
    const successModal = document.getElementById('success-modal');
    const closeModal = successModal.querySelector('.close-modal');
    
    donationForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Get selected donation type
        const donationType = document.querySelector('.type-btn.active').dataset.type;
        
        // Get selected amount
        const amount = customAmount.value || document.querySelector('.amount-btn.active')?.dataset.amount;
        
        // Get selected payment method
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        // Get form data
        const formData = new FormData(donationForm);
        formData.append('donation_type', donationType);
        formData.append('amount', amount);
        formData.append('payment_method', paymentMethod);
        
        try {
            // In a real application, this would make an API call to process the payment
            // For demonstration, we'll just show the success modal
            successModal.style.display = 'block';
            donationForm.reset();
            
            // Reset UI state
            typeButtons[0].click();
            amountButtons.forEach(btn => btn.classList.remove('active'));
            customAmount.value = '';
            
        } catch (error) {
            alert('Sorry, there was an error processing your donation. Please try again later.');
        }
    });
    
    // Close modal
    closeModal.addEventListener('click', () => {
        successModal.style.display = 'none';
    });
    
    window.addEventListener('click', (e) => {
        if (e.target === successModal) {
            successModal.style.display = 'none';
        }
    });

    // Project Card Selection
    const projectCards = document.querySelectorAll('.project-card');
    
    projectCards.forEach(card => {
        card.addEventListener('click', () => {
            projectCards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
        });
    });

    // Payment Method Selection
    const paymentOptions = document.querySelectorAll('.payment-option');
    
    paymentOptions.forEach(option => {
        option.addEventListener('click', () => {
            const radio = option.querySelector('input[type="radio"]');
            radio.checked = true;
        });
    });
});
