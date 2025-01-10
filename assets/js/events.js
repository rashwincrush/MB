document.addEventListener('DOMContentLoaded', function() {
    // Tab Switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            // Remove active class from all buttons and contents
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(content => content.classList.add('hidden'));

            // Add active class to clicked button and show corresponding content
            this.classList.add('active');
            document.getElementById(`${tabId}-events`).classList.remove('hidden');
        });
    });

    // Event Category Filter
    const categorySelect = document.getElementById('event-category');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const category = this.value;
            const eventCards = document.querySelectorAll('.event-card');

            eventCards.forEach(card => {
                if (!category || card.dataset.category === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Event Registration Modal
    const modal = document.getElementById('registration-modal');
    const registerBtns = document.querySelectorAll('.register-btn');
    const closeModal = document.querySelector('.close-modal');
    const registrationForm = document.getElementById('event-registration-form');

    registerBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.style.display = 'block';
            document.getElementById('event_id').value = btn.dataset.eventId;
        });
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Form Submission
    registrationForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(registrationForm);
        
        try {
            const response = await fetch('/register-event.php', {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                alert('Registration successful! We will contact you with more details.');
                modal.style.display = 'none';
                registrationForm.reset();
            } else {
                throw new Error('Registration failed');
            }
        } catch (error) {
            alert('Sorry, there was an error processing your registration. Please try again later.');
        }
    });

    // Event Details Modal
    function createEventModal(event) {
        const modal = document.createElement('div');
        modal.classList.add('event-modal');
        modal.innerHTML = `
            <div class="event-modal-content">
                <span class="close-modal">&times;</span>
                <img src="${event.image}" alt="${event.title}">
                <h2>${event.title}</h2>
                <p class="event-date"><i class="far fa-calendar"></i> ${event.date}</p>
                <p class="event-location"><i class="fas fa-map-marker-alt"></i> ${event.location}</p>
                <p class="event-description">${event.description}</p>
            </div>
        `;

        // Close modal functionality
        const closeBtn = modal.querySelector('.close-modal');
        closeBtn.addEventListener('click', () => {
            document.body.removeChild(modal);
        });

        document.body.appendChild(modal);
    }

    // Add click event to event cards for modal
    const eventCards = document.querySelectorAll('.event-card, .past-event-card');
    eventCards.forEach(card => {
        card.addEventListener('click', function() {
            const image = this.querySelector('img').src;
            const title = this.querySelector('h3').textContent;
            const date = this.querySelector('.event-date') ? 
                this.querySelector('.event-date').textContent : 
                this.querySelector('.event-date i').textContent;
            const location = this.querySelector('.event-location') ? 
                this.querySelector('.event-location').textContent : 
                'Location not specified';
            const description = this.querySelector('.event-description').textContent;

            createEventModal({
                image,
                title,
                date,
                location,
                description
            });
        });
    });

    // Initialize Calendar
    const calendar = document.querySelector('.events-calendar');
    if (calendar) {
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();
        
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];
        
        function generateCalendar(month, year) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startingDay = firstDay.getDay();
            const monthLength = lastDay.getDate();
            
            let html = `
                <div class="calendar-header">
                    <button class="prev-month">&lt;</button>
                    <h3>${monthNames[month]} ${year}</h3>
                    <button class="next-month">&gt;</button>
                </div>
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            let day = 1;
            for (let i = 0; i < 6; i++) {
                html += '<tr>';
                
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < startingDay) {
                        html += '<td></td>';
                    } else if (day > monthLength) {
                        html += '<td></td>';
                    } else {
                        html += `<td data-date="${year}-${month + 1}-${day}">${day}</td>`;
                        day++;
                    }
                }
                
                html += '</tr>';
                if (day > monthLength) {
                    break;
                }
            }
            
            html += '</tbody></table>';
            calendar.innerHTML = html;
            
            // Add event handlers for navigation
            document.querySelector('.prev-month').addEventListener('click', () => {
                let newMonth = month - 1;
                let newYear = year;
                if (newMonth < 0) {
                    newMonth = 11;
                    newYear--;
                }
                generateCalendar(newMonth, newYear);
            });
            
            document.querySelector('.next-month').addEventListener('click', () => {
                let newMonth = month + 1;
                let newYear = year;
                if (newMonth > 11) {
                    newMonth = 0;
                    newYear++;
                }
                generateCalendar(newMonth, newYear);
            });
            
            // Highlight dates with events
            highlightEventDates();
        }
        
        function highlightEventDates() {
            // This function would typically fetch event dates from the server
            // and highlight the corresponding calendar cells
            const eventDates = document.querySelectorAll('[data-date]');
            eventDates.forEach(date => {
                // Check if date has events and add appropriate class
                // This is a placeholder - you would need to implement the actual logic
                if (Math.random() > 0.8) { // Just for demonstration
                    date.classList.add('has-event');
                }
            });
        }
        
        // Initialize calendar with current month
        generateCalendar(currentMonth, currentYear);
    }
});
