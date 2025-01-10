// News Ticker
function initNewsTicker() {
    const news = [
        "Join our upcoming charity event this weekend!",
        "Help us make a difference in the community",
        "New volunteer opportunities available",
        "Thank you to all our donors and supporters"
    ];
    
    let currentIndex = 0;
    const ticker = document.querySelector('.news-ticker');
    
    setInterval(() => {
        ticker.style.opacity = '0';
        setTimeout(() => {
            ticker.textContent = news[currentIndex];
            ticker.style.opacity = '1';
            currentIndex = (currentIndex + 1) % news.length;
        }, 500);
    }, 5000);
}

// Mobile Menu Toggle
function initMobileMenu() {
    const mobileMenu = document.querySelector('.mobile-menu');
    const navLinks = document.querySelector('.nav-links');
    
    mobileMenu.addEventListener('click', () => {
        navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
    });
}

// Newsletter Form
function initNewsletterForm() {
    const form = document.getElementById('newsletterForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = form.querySelector('input[type="email"]').value;
            
            try {
                const response = await fetch('/subscribe.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email })
                });
                
                if (response.ok) {
                    alert('Thank you for subscribing!');
                    form.reset();
                } else {
                    throw new Error('Subscription failed');
                }
            } catch (error) {
                alert('Sorry, there was an error. Please try again later.');
            }
        });
    }
}

// Donation Form Amount Selector
function initDonationForm() {
    const amountButtons = document.querySelectorAll('.amount-btn');
    const customAmount = document.getElementById('customAmount');
    
    if (amountButtons.length && customAmount) {
        amountButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                amountButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                customAmount.value = btn.dataset.amount;
            });
        });
    }
}

// Image Slider for Hero Section
function initImageSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length > 0) {
        let currentSlide = 0;
        
        setInterval(() => {
            slides[currentSlide].style.opacity = '0';
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].style.opacity = '1';
        }, 5000);
    }
}

// Initialize all features when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initNewsTicker();
    initMobileMenu();
    initNewsletterForm();
    initDonationForm();
    initImageSlider();
});
