/*
 * MahoneT HR Consulting Website JavaScript
 */

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        // Close menu when clicking on a nav link
        const navLinks = document.querySelectorAll('.nav-menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!hamburger.contains(event.target) && !navMenu.contains(event.target)) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#booking') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Contact Form Handling
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(contactForm);
            const data = {
                name: formData.get('name'),
                organization: formData.get('organization'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                subject: formData.get('subject'),
                message: formData.get('message'),
                timestamp: new Date().toISOString(),
                type: 'contact_form'
            };

            // Save to local storage (for backup)
            saveConsultationRequest(data);

            // Send email via backend
            fetch('send-email-secure.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Thank you for your message! We will get back to you within one business day.');
                    contactForm.reset();
                } else {
                    alert('Your message was saved but there was an issue sending the email. We will still get back to you soon!');
                    console.error('Email send failed:', result.message);
                }
            })
            .catch(error => {
                // Still save locally even if email fails
                alert('Your message has been saved. We will get back to you within one business day.');
                console.error('Error:', error);
                contactForm.reset();
            });
        });
    }

    // Consultation booking form (if implemented)
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(bookingForm);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                preferred_date: formData.get('preferred_date'),
                preferred_time: formData.get('preferred_time'),
                message: formData.get('message'),
                timestamp: new Date().toISOString(),
                type: 'consultation_booking'
            };

            // Save to local storage
            saveConsultationRequest(data);

            // Show success message
            alert('Thank you for booking a consultation! We will confirm your appointment within one business day.');

            // Reset form
            bookingForm.reset();
        });
    }
});

// Function to save consultation requests to localStorage
function saveConsultationRequest(data) {
    // Get existing requests or initialize empty array
    let requests = JSON.parse(localStorage.getItem('consultationRequests') || '[]');

    // Add new request
    requests.push(data);

    // Save back to localStorage
    localStorage.setItem('consultationRequests', JSON.stringify(requests));

    console.log('Consultation request saved:', data);
}

// Function to retrieve all consultation requests (for admin use)
function getConsultationRequests() {
    return JSON.parse(localStorage.getItem('consultationRequests') || '[]');
}

// Function to export requests to CSV (for admin use)
function exportRequestsToCSV() {
    const requests = getConsultationRequests();

    if (requests.length === 0) {
        alert('No consultation requests to export.');
        return;
    }

    // Create CSV header
    const headers = ['Timestamp', 'Type', 'Name', 'Email', 'Phone', 'Organization', 'Subject', 'Preferred Date', 'Preferred Time', 'Message'];

    // Create CSV rows
    const rows = requests.map(req => [
        req.timestamp,
        req.type,
        req.name,
        req.email,
        req.phone || '',
        req.organization || '',
        req.subject || '',
        req.preferred_date || '',
        req.preferred_time || '',
        req.message || ''
    ]);

    // Combine headers and rows
    const csvContent = [headers, ...rows]
        .map(row => row.map(cell => `"${cell}"`).join(','))
        .join('\n');

    // Create download link
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `consultation_requests_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.value-card, .service-card, .serve-card');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});