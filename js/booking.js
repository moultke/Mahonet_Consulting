/*
 * MahoneT HR Consulting - Booking System
 */

let currentStep = 1;
let selectedDate = null;
let selectedTime = null;
let currentMonth = new Date();

const bookingData = {
    date: null,
    time: null,
    name: '',
    email: '',
    phone: '',
    organization: '',
    meetingType: '',
    message: ''
};

// Available time slots
const timeSlots = [
    '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
    '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
    '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM'
];

// Initialize booking system
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('calendar')) {
        initializeBookingSystem();
    }
});

function initializeBookingSystem() {
    renderCalendar();
    setupEventListeners();
    updateStepDisplay();
}

function setupEventListeners() {
    // Calendar navigation
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() + 1);
        renderCalendar();
    });

    // Form navigation
    document.getElementById('nextBtn').addEventListener('click', handleNext);
    document.getElementById('backBtn').addEventListener('click', handleBack);
}

function renderCalendar() {
    const calendar = document.getElementById('calendar');
    const monthDisplay = document.getElementById('currentMonth');

    const year = currentMonth.getFullYear();
    const month = currentMonth.getMonth();

    // Display month and year
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];
    monthDisplay.textContent = `${monthNames[month]} ${year}`;

    // Clear calendar
    calendar.innerHTML = '';

    // Add day headers
    const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayHeaders.forEach(day => {
        const header = document.createElement('div');
        header.className = 'calendar-day-header';
        header.textContent = day;
        calendar.appendChild(header);
    });

    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Add empty cells for days before month starts
    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day empty';
        calendar.appendChild(emptyDay);
    }

    // Add days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDate = new Date(year, month, day);
        dayDate.setHours(0, 0, 0, 0);

        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = day;

        // Disable past dates and weekends
        const dayOfWeek = dayDate.getDay();
        if (dayDate < today || dayOfWeek === 0 || dayOfWeek === 6) {
            dayElement.classList.add('disabled');
        } else {
            dayElement.addEventListener('click', () => selectDate(dayDate, dayElement));
        }

        // Highlight selected date
        if (selectedDate && dayDate.getTime() === selectedDate.getTime()) {
            dayElement.classList.add('selected');
        }

        calendar.appendChild(dayElement);
    }
}

function selectDate(date, element) {
    // Remove previous selection
    document.querySelectorAll('.calendar-day').forEach(day => {
        day.classList.remove('selected');
    });

    // Add selection to clicked day
    element.classList.add('selected');
    selectedDate = date;
    bookingData.date = formatDate(date);

    // Enable next button
    document.getElementById('nextBtn').disabled = false;
}

function renderTimeSlots() {
    const timeSlotsContainer = document.getElementById('timeSlots');
    timeSlotsContainer.innerHTML = '';

    timeSlots.forEach(time => {
        const slot = document.createElement('div');
        slot.className = 'time-slot';
        slot.textContent = time;

        slot.addEventListener('click', () => selectTime(time, slot));

        if (selectedTime === time) {
            slot.classList.add('selected');
        }

        timeSlotsContainer.appendChild(slot);
    });
}

function selectTime(time, element) {
    // Remove previous selection
    document.querySelectorAll('.time-slot').forEach(slot => {
        slot.classList.remove('selected');
    });

    // Add selection to clicked slot
    element.classList.add('selected');
    selectedTime = time;
    bookingData.time = time;

    // Enable next button
    document.getElementById('nextBtn').disabled = false;
}

function handleNext() {
    if (currentStep === 1) {
        // Validate date selection
        if (!selectedDate) {
            alert('Please select a date for your consultation.');
            return;
        }
        renderTimeSlots();
        goToStep(2);
    } else if (currentStep === 2) {
        // Validate time selection
        if (!selectedTime) {
            alert('Please select a time for your consultation.');
            return;
        }
        goToStep(3);
    } else if (currentStep === 3) {
        // Validate form fields
        const form = document.getElementById('bookingForm');
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const meetingType = document.getElementById('meetingType').value;

        if (!name || !email || !phone || !meetingType) {
            alert('Please fill in all required fields.');
            return;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return;
        }

        // Validate phone format (at least 10 digits)
        const phoneDigits = phone.replace(/\D/g, '');
        if (phoneDigits.length < 10) {
            alert('Please enter a valid phone number (at least 10 digits).');
            return;
        }

        // Save form data
        bookingData.name = name;
        bookingData.email = email;
        bookingData.phone = phone;
        bookingData.organization = document.getElementById('organization').value.trim();
        bookingData.meetingType = meetingType;
        bookingData.message = document.getElementById('message').value.trim();

        // Show summary
        displaySummary();
        goToStep(4);
    } else if (currentStep === 4) {
        // Confirm booking
        submitBooking();
    }
}

function handleBack() {
    if (currentStep > 1) {
        goToStep(currentStep - 1);
    }
}

function goToStep(step) {
    currentStep = step;

    // Hide all steps
    document.querySelectorAll('.form-step').forEach(stepEl => {
        stepEl.classList.remove('active');
    });

    // Show current step
    document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');

    // Update step indicators
    document.querySelectorAll('.step').forEach((stepEl, index) => {
        const stepNum = index + 1;
        if (stepNum < step) {
            stepEl.classList.add('completed');
            stepEl.classList.remove('active');
        } else if (stepNum === step) {
            stepEl.classList.add('active');
            stepEl.classList.remove('completed');
        } else {
            stepEl.classList.remove('active', 'completed');
        }
    });

    updateStepDisplay();
}

function updateStepDisplay() {
    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');
    const formNav = document.getElementById('formNavigation');

    if (currentStep === 5) {
        // Hide navigation on success
        formNav.style.display = 'none';
        return;
    }

    formNav.style.display = 'flex';

    // Show/hide back button
    backBtn.style.display = currentStep > 1 ? 'block' : 'none';

    // Update next button text
    if (currentStep === 4) {
        nextBtn.textContent = 'Confirm Booking';
    } else {
        nextBtn.textContent = 'Next →';
    }

    // Disable next button if selection not made
    if (currentStep === 1 && !selectedDate) {
        nextBtn.disabled = true;
    } else if (currentStep === 2 && !selectedTime) {
        nextBtn.disabled = true;
    } else {
        nextBtn.disabled = false;
    }
}

function displaySummary() {
    const summaryHTML = `
        <h4>Your Consultation Details</h4>
        <div class="summary-item">
            <span class="summary-label">Date:</span>
            <span>${bookingData.date}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Time:</span>
            <span>${bookingData.time} EST</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Name:</span>
            <span>${bookingData.name}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Email:</span>
            <span>${bookingData.email}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Phone:</span>
            <span>${bookingData.phone}</span>
        </div>
        ${bookingData.organization ? `
        <div class="summary-item">
            <span class="summary-label">Organization:</span>
            <span>${bookingData.organization}</span>
        </div>
        ` : ''}
        <div class="summary-item">
            <span class="summary-label">Meeting Format:</span>
            <span>${bookingData.meetingType === 'zoom' ? 'Video Call (Zoom)' : 'Phone Call'}</span>
        </div>
    `;

    document.getElementById('bookingSummary').innerHTML = summaryHTML;
}

function submitBooking() {
    // Add timestamp
    bookingData.timestamp = new Date().toISOString();
    bookingData.type = 'consultation_booking';

    // Save to localStorage (for backup)
    saveConsultationRequest(bookingData);

    // Disable the submit button and show loading state
    const nextBtn = document.getElementById('nextBtn');
    const originalText = nextBtn.textContent;
    nextBtn.disabled = true;
    nextBtn.textContent = 'Sending...';

    // Send email via backend
    fetch('send-email-secure.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(bookingData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            console.log('Booking email sent successfully');

            // Update success message
            document.getElementById('confirmedEmail').textContent = bookingData.email;
            document.getElementById('confirmedEmail2').textContent = bookingData.email;
            document.getElementById('finalSummary').innerHTML = document.getElementById('bookingSummary').innerHTML;

            // Go to success step
            goToStep(5);
        } else {
            console.error('Email send failed:', result.message);
            alert('There was an issue sending your booking request. Please try again or contact us directly at reply@mahonetconsulting.com');
            nextBtn.disabled = false;
            nextBtn.textContent = originalText;
        }
    })
    .catch(error => {
        console.error('Error sending booking email:', error);
        alert('There was an issue sending your booking request. Your information has been saved locally. Please contact us directly at reply@mahonetconsulting.com or try again.');
        nextBtn.disabled = false;
        nextBtn.textContent = originalText;
    });
}

function formatDate(date) {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}