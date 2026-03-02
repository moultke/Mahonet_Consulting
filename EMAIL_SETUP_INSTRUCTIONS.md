# Email Setup Instructions - IMPORTANT! 📧

## Current Status

The website has been updated with:
✅ Improved booking page messaging (requests vs confirmed bookings)
✅ Professional SMTP email backend with PHPMailer
✅ Clear "What Happens Next" messaging on all pages

**However, emails will NOT work until you deploy to a web server and install PHPMailer.**

---

## Why Emails Aren't Sending Yet

The PHP email system requires:
1. **A web server** with PHP installed (Apache, Nginx, etc.)
2. **PHPMailer library** for SMTP authentication
3. **Your actual email password** in the PHP file

Currently, the site is running locally as static HTML files, so PHP code doesn't execute.

---

## DEPLOYMENT STEPS - Required for Emails to Work

### Option 1: Deploy to Web Hosting (Recommended)

#### Step 1: Upload Files to Your Web Host
Upload all these files to your web hosting:
```
/Mahonet_Consulting/
├── index.html
├── about.html
├── services.html
├── contact.html
├── booking.html
├── admin.html
├── send-email-smtp.php  ← IMPORTANT!
├── composer.json        ← IMPORTANT!
├── css/
├── js/
└── img/
```

#### Step 2: Install PHPMailer on Your Server
Connect to your server via SSH and run:
```bash
cd /path/to/your/website
composer install
```

**Don't have Composer?** Install it first:
```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

**No SSH Access?** Contact your hosting provider to install PHPMailer, or:
1. Download PHPMailer manually from https://github.com/PHPMailer/PHPMailer
2. Extract to `vendor/phpmailer/` folder
3. Update the require path in `send-email-smtp.php`

#### Step 3: Add Your Email Password
Edit `send-email-smtp.php` on line 29:
```php
// Replace this line:
define('SMTP_PASSWORD', 'YOUR_ACTUAL_PASSWORD_HERE');

// With your real password:
define('SMTP_PASSWORD', 'YourActualPassword123');
```

**IMPORTANT:** Never commit this file to Git with the real password!

#### Step 4: Update JavaScript to Use New PHP File
Edit `js/script.js` and `js/booking.js`:

**Find:**
```javascript
fetch('send-email.php', {
```

**Replace with:**
```javascript
fetch('send-email-smtp.php', {
```

Do this in both files (2 places total).

#### Step 5: Test the Email System
1. Go to your website: `https://yourdomain.com/contact.html`
2. Fill out and submit the contact form
3. Check `reply@mahonetconsulting.com` for the email
4. If not in inbox, check spam folder

---

### Option 2: Use cPanel Email Forwarder (Simple Alternative)

If you have cPanel hosting and don't want to set up PHP:

1. **Log into cPanel**
2. **Go to Email Forwarders**
3. **Set up forwarders:**
   - Forward `reply@mahonetconsulting.com` to your personal email
   - Or set up email access directly in cPanel

4. **Keep using localStorage** for form submissions
5. **View submissions** in `admin.html`
6. **Export to CSV** regularly

This way you don't need email integration - just check the admin dashboard!

---

## Email Configuration Details

### SMTP Settings (Already in Code)
```
Host:     mail.mahonetconsulting.com
Port:     465 (SSL/TLS)
Username: reply@mahonetconsulting.com
Password: [Your password - add to code]
```

### Email Flow
1. User submits form
2. JavaScript sends data to `send-email-smtp.php`
3. PHP uses PHPMailer to send via SMTP
4. Email arrives at `reply@mahonetconsulting.com`
5. Data also saved to localStorage (backup)

---

## Testing Checklist

After deployment, test these:

### Contact Form
- [ ] Go to contact.html
- [ ] Fill out all fields
- [ ] Submit form
- [ ] Check for success message
- [ ] Verify email received at reply@mahonetconsulting.com

### Booking Form
- [ ] Go to booking.html
- [ ] Complete all 4 steps
- [ ] Read "suggested time" notice
- [ ] Submit booking request
- [ ] Check success page shows "What Happens Next"
- [ ] Verify booking email received

### Admin Dashboard
- [ ] Go to admin.html
- [ ] Verify submissions appear
- [ ] Test CSV export
- [ ] Confirm data is saved

---

## Troubleshooting

### "PHPMailer not installed" Error
**Solution:** Run `composer install` on your server

### "SMTP Error: Could not connect"
**Possible causes:**
- Wrong password in code
- Port 465 blocked by firewall
- SSL certificate issues

**Solutions:**
- Double-check password
- Try port 587 with `ENCRYPTION_STARTTLS`
- Contact hosting provider

### "Email sent but not received"
**Check:**
1. Spam/junk folder
2. Email server logs (in cPanel)
3. SPF/DKIM records (ask hosting provider)

### Still Having Issues?
Contact your web hosting support and provide them:
- Your domain: mahonetconsulting.com
- Email: reply@mahonetconsulting.com
- Request: "Help set up PHPMailer for SMTP email sending"

---

## Security Recommendations

### 1. Protect Your Password
**DO NOT** put the real password in the code if you're sharing it publicly!

Better approach:
```php
// Use environment variable
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD'));
```

Then set it in your server's environment variables.

### 2. Enable HTTPS
Get an SSL certificate (free with Let's Encrypt) to encrypt form data.

### 3. Add CAPTCHA
Consider adding Google reCAPTCHA to prevent spam:
```html
<script src="https://www.google.com/recaptcha/api.js"></script>
```

### 4. Set File Permissions
```bash
chmod 644 send-email-smtp.php
chmod 755 vendor/
```

---

## Booking Page Updates Made

### 1. "What to Expect" Section
Added as the first item:
```
📅 Suggested Time Slot
Your selected date and time is a request.
We'll confirm availability within 24 hours and send a calendar invite.
```

### 2. Confirmation Page (Step 4)
Added prominent notice box:
```
📅 Please Note: This is a requested time slot.
We will confirm availability within 24 hours and send you
a calendar invite with the confirmed time or suggest
alternative slots if needed.
```

### 3. Success Page
Changed from:
- "Consultation Booked!" ❌

To:
- "Consultation Request Submitted!" ✅
- "What Happens Next?" section with 3 steps
- Clear explanation of confirmation process

---

## Alternative: No-Code Email Solution

If you don't want to mess with PHP/server setup:

### Use Formspree or similar service:
1. Sign up at https://formspree.io
2. Get your form endpoint
3. Update forms to POST to Formspree
4. They'll forward emails to you

### Example:
```html
<form action="https://formspree.io/f/YOUR-ID" method="POST">
```

This is easier but less customizable than the PHP solution.

---

## Files Created for Email System

### New Files:
- ✅ `send-email-smtp.php` - PHPMailer email handler
- ✅ `composer.json` - PHPMailer dependency
- ✅ `EMAIL_SETUP_INSTRUCTIONS.md` - This file

### Updated Files:
- ✅ `booking.html` - Clear messaging about requests vs confirmations
- ✅ `js/script.js` - Email integration (needs PHP file update)
- ✅ `js/booking.js` - Email integration (needs PHP file update)

---

## Summary

### What's Working Now (Locally):
✅ All pages display correctly
✅ Forms save to localStorage
✅ Admin dashboard works
✅ CSV export works
✅ Booking page has clear "request" messaging

### What Needs Server Setup:
❌ Email sending (requires deployment + PHPMailer)
❌ SMTP authentication
❌ Professional email notifications

### Quick Path to Working Emails:
1. Upload files to web host
2. Run `composer install`
3. Add your password to `send-email-smtp.php`
4. Update JS files to use `send-email-smtp.php`
5. Test!

---

**Need help with deployment? Contact your web hosting provider and show them this document!**

Last updated: November 6, 2025