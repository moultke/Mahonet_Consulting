# MahoneT HR Consulting Website

A professional, responsive website for MahoneT HR Consulting, specializing in HR strategy, compliance, and consulting services for small businesses and behavioral health agencies.

## Features

### Public Pages
- **Home Page** (`index.html`) - Contemporary hero section with prominent eggplant design, animated shapes, core values, services overview, and who we serve
- **About Page** (`about.html`) - Founder story, mission, and what sets MahoneT apart
- **Services Page** (`services.html`) - Detailed service offerings with descriptions
- **Contact Page** (`contact.html`) - Contact form for general inquiries
- **Booking Page** (`booking.html`) - **NEW!** Interactive consultation booking system with calendar, time slots, and multi-step form

### Admin Features
- **Admin Dashboard** (`admin.html`) - View and manage all consultation requests
  - Statistics dashboard showing total requests, contact forms, bookings, and today's requests
  - Filter requests by type
  - Search by name, email, or organization
  - Export all data to CSV
  - Clear all data functionality

### Key Features
- **Professional Branding**
  - MHRC logo integrated throughout the site
  - Logo in navigation header (all pages)
  - Logo in footer with white filter effect
  - Consistent brand identity across all pages

- **Contemporary Design with Prominent Eggplant Color**
  - Full eggplant gradient hero section with animated background shapes
  - Floating blob animation and decorative circles
  - Elegant image frames with accent decorations
  - Hero badge with orange accents

- **Interactive Booking System**
  - 4-step consultation booking process
  - Interactive calendar with date selection
  - Time slot picker (16 slots throughout the day)
  - Multi-step form with progress indicators
  - Real-time validation
  - Booking confirmation with summary
  - All bookings saved to localStorage

- Responsive design that works on desktop, tablet, and mobile devices
- Brand colors: Orange (#FF6B35) and Eggplant (#571326)
- Professional photography integration
- Contact form with local storage for tracking inquiries
- Smooth scrolling navigation
- Mobile-friendly hamburger menu

## File Structure

```
Mahonet_Consulting/
├── index.html          # Home page
├── about.html          # About page
├── services.html       # Services page
├── contact.html        # Contact page
├── booking.html        # NEW: Consultation booking page
├── admin.html          # Admin dashboard
├── css/
│   └── style.css       # Main stylesheet
├── js/
│   ├── script.js       # JavaScript functionality
│   └── booking.js      # NEW: Booking system logic
├── img/                # Images folder
│   ├── 2G7A0267.JPG
│   ├── 2G7A0282.JPG
│   ├── 2G7A0463.JPG
│   ├── 2G7A0504.JPG
│   └── 2G7A0566.JPG
├── content/            # Content documents
│   └── Terris Website_Ken.docx
├── mockup/             # Design mockups
│   └── img.png
└── README.md           # This file
```

## Getting Started

### Viewing the Website
1. Open `index.html` in a web browser
2. Navigate through the site using the navigation menu
3. All pages are interconnected with proper navigation

### Accessing the Admin Dashboard
1. Open `admin.html` in a web browser
2. View all consultation requests submitted through the contact form
3. Export data to CSV for record keeping
4. Filter and search through requests

### Data Storage
- All consultation requests are stored in the browser's localStorage
- Data persists until manually cleared or browser cache is cleared
- Access the admin dashboard to export data before clearing browser data

## Form Features

### Contact Form
The contact form on the contact page captures:
- Name (required)
- Organization Name
- Email (required)
- Phone
- Subject/How can we help (required)
- Message (required)

### Consultation Booking
The system is set up to handle consultation bookings with:
- Name
- Email
- Phone
- Preferred date and time
- Message

All submissions are logged with a timestamp and can be viewed in the admin dashboard.

## Brand Guidelines

### Colors
- **Primary Orange**: #FF6B35 - Used for CTAs, highlights, and accents
- **Primary Eggplant**: #571326 (RGB 87, 19, 74) - Used for headings, footer, and branding
- **Light Gray**: #f8f9fa - Used for backgrounds
- **Medium Gray**: #6c757d - Used for body text

### Typography
- System font stack for optimal performance
- Headings use bold weights for emphasis
- Body text maintains 1.6 line-height for readability

## Responsive Breakpoints
- Desktop: 1200px+
- Tablet: 768px - 1199px
- Mobile: Below 768px

## Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Email Integration ✅

The website now includes professional email functionality:
- **PHPMailer** integration for SMTP authentication
- Email notifications for contact form submissions
- Email notifications for consultation bookings
- Backup storage in localStorage
- Professional HTML email templates

**Email Setup:** See `EMAIL_SETUP_INSTRUCTIONS.md` for deployment details

## SEO Optimization ✅

The website is fully optimized for search engines:
- Meta tags (title, description, keywords) on all pages
- Open Graph tags for social media sharing
- Schema.org structured data (JSON-LD)
- XML sitemap (`sitemap.xml`)
- robots.txt file
- Canonical URLs
- Mobile-friendly responsive design

**SEO Guide:** See `SEO_IMPLEMENTATION_GUIDE.md` and `SEO_QUICK_START_CHECKLIST.md`

## Deployment Ready 🚀

All files are ready for deployment to GreenGeeks cPanel:
- Complete deployment guide available
- PHPMailer setup instructions included
- SSL certificate ready (HTTPS)
- All forms tested and functional

**Deployment Guide:** See `GREENGEEKS_DEPLOYMENT_GUIDE.md`

## Future Enhancements
- Blog section for HR tips and insights
- Client testimonials section
- Google reCAPTCHA for spam protection
- Calendar integration (Google Calendar, Outlook)
- Email auto-responder to clients
- Advanced analytics and tracking

## Development Notes

### JavaScript Functions
- `saveConsultationRequest(data)` - Saves form data to localStorage
- `getConsultationRequests()` - Retrieves all stored requests
- `exportRequestsToCSV()` - Exports data to CSV file
- Mobile navigation toggle
- Smooth scrolling for anchor links
- Scroll animations for cards

### CSS Architecture
- Mobile-first responsive design
- CSS custom properties for theme colors
- Modular component-based styling
- Smooth transitions and hover effects

## Contact

For questions about this website, please contact MahoneT HR Consulting.

---

**Built with HTML, CSS, and JavaScript**
**© 2025 MahoneT HR Consulting. All rights reserved.**