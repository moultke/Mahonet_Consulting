# GreenGeeks cPanel Deployment Guide
## MahoneT HR Consulting Website

This guide provides step-by-step instructions for deploying your website to GreenGeeks hosting using cPanel.

---

## Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Accessing cPanel](#accessing-cpanel)
3. [Uploading Website Files](#uploading-website-files)
4. [Installing PHPMailer](#installing-phpmailer)
5. [Configuring Email Settings](#configuring-email-settings)
6. [Setting Up Email Access](#setting-up-email-access)
7. [Testing Your Website](#testing-your-website)
8. [SSL Certificate Setup](#ssl-certificate-setup)
9. [Troubleshooting](#troubleshooting)

---

## Pre-Deployment Checklist

Before you begin, ensure you have:

- ✅ GreenGeeks hosting account active
- ✅ Domain name (mahonetconsulting.com) pointed to GreenGeeks nameservers
- ✅ cPanel login credentials (provided by GreenGeeks)
- ✅ Email password for reply@mahonetconsulting.com
- ✅ All website files ready to upload

**Files to Upload:**
```
/Mahonet_Consulting/
├── index.html
├── about.html
├── services.html
├── contact.html
├── booking.html
├── admin.html
├── send-email-smtp.php
├── composer.json
├── css/
│   └── style.css
├── js/
│   ├── script.js
│   └── booking.js
└── img/
    ├── logo.jpg
    ├── logo-white.png
    ├── main-image.jpg
    ├── behavioral-health-placeholder.jpg
    ├── small-business-placeholder.jpg
    ├── community-orgs-placeholder.jpg
    └── [other images]
```

---

## Accessing cPanel

### Step 1: Log Into cPanel

1. **Go to your cPanel URL** (one of these):
   - `https://yourdomain.com/cpanel`
   - `https://yourdomain.com:2083`
   - Direct link provided in GreenGeeks welcome email

2. **Enter your credentials:**
   - Username: (provided by GreenGeeks)
   - Password: (provided by GreenGeeks)

3. **Click "Log in"**

### Step 2: Familiarize Yourself with cPanel

Key sections you'll use:
- **FILES** → File Manager (upload files)
- **SOFTWARE** → Terminal or PHP MyAdmin (install PHPMailer)
- **EMAIL** → Email Accounts (configure email)
- **SECURITY** → SSL/TLS (manage SSL certificate)

---

## Uploading Website Files

### Method 1: Using cPanel File Manager (Recommended)

#### Step 1: Navigate to File Manager

1. In cPanel, find the **FILES** section
2. Click **File Manager**
3. A new window/tab will open

#### Step 2: Navigate to Public Directory

1. In the left sidebar, click **public_html**
   - This is where your website files go
   - `public_html` = your website root directory

#### Step 3: Clear Default Files (if any)

If you see default files like `index.html` or `cgi-bin`:
1. Select the default `index.html` (checkbox)
2. Click **Delete** in the top menu
3. Confirm deletion

#### Step 4: Upload Your Files

**Option A: Upload Folder (Easier)**

1. On your computer, compress the Mahonet_Consulting folder:
   - Right-click → Compress/ZIP
   - Name it `website.zip`

2. In File Manager, click **Upload** (top menu)

3. Click **Select File** and choose `website.zip`

4. Wait for upload to complete (progress bar will show)

5. Go back to File Manager (click the back link)

6. Right-click `website.zip` → **Extract**

7. Extract to `/public_html/`

8. Click **Extract Files**

9. Delete the ZIP file (right-click → Delete)

10. Move files from extracted folder to root:
    - If files are in `public_html/Mahonet_Consulting/`, move them to `public_html/`
    - Select all files → **Move** → Enter `/public_html/` → **Move Files**

**Option B: Upload Individual Files**

1. Click **Upload** in File Manager

2. Select and upload these files to `public_html/`:
   - All HTML files (index.html, about.html, etc.)
   - send-email-smtp.php
   - composer.json

3. Create folders:
   - Click **+ Folder** → Name it `css` → Create
   - Repeat for `js` and `img` folders

4. Navigate into each folder and upload respective files

#### Step 5: Verify File Structure

Your `public_html` directory should look like this:
```
public_html/
├── index.html          ✓
├── about.html          ✓
├── services.html       ✓
├── contact.html        ✓
├── booking.html        ✓
├── admin.html          ✓
├── send-email-smtp.php ✓
├── composer.json       ✓
├── css/
│   └── style.css       ✓
├── js/
│   ├── script.js       ✓
│   └── booking.js      ✓
└── img/
    └── [all images]    ✓
```

#### Step 6: Set File Permissions

1. Select `send-email-smtp.php`
2. Right-click → **Permissions** (or click Permissions in top menu)
3. Set to **644**:
   - Owner: Read + Write
   - Group: Read
   - Public: Read
4. Click **Change Permissions**

---

## Installing PHPMailer

PHPMailer is required for email functionality. You have **3 options**.

### Option 1: SSH Terminal (Recommended - Fastest)

#### Step 1: Enable SSH Access

1. In cPanel, go to **SECURITY** section
2. Click **SSH Access**
3. Click **Manage SSH Keys**
4. If not enabled, contact GreenGeeks support to enable SSH

#### Step 2: Connect via Terminal

**On Mac/Linux:**
```bash
ssh username@yourdomain.com
# Enter your cPanel password when prompted
```

**On Windows:**
- Use PuTTY or Windows Terminal
- Host: `yourdomain.com`
- Port: `22`
- Username: your cPanel username

#### Step 3: Navigate to Website Directory

```bash
cd public_html
ls -la
# You should see your HTML files and composer.json
```

#### Step 4: Install Composer (if not installed)

Check if Composer is installed:
```bash
composer --version
```

If not installed, install it:
```bash
curl -sS https://getcomposer.org/installer | php
```

#### Step 5: Install PHPMailer

If Composer is installed globally:
```bash
composer install
```

If you installed Composer locally:
```bash
php composer.phar install
```

You should see output like:
```
Loading composer repositories with package information
Installing dependencies from lock file
  - Installing phpmailer/phpmailer (v6.8.x)
    Downloading: 100%
Generating autoload files
```

#### Step 6: Verify Installation

```bash
ls -la vendor/
# You should see phpmailer directory
```

### Option 2: cPanel Terminal (If Available)

GreenGeeks may have a Terminal icon in cPanel:

1. In cPanel, look for **ADVANCED** section
2. Click **Terminal**
3. Follow Steps 3-6 from Option 1 above

### Option 3: Manual Installation (No SSH Access)

If you don't have SSH access:

#### Step 1: Download PHPMailer

On your computer:
1. Go to https://github.com/PHPMailer/PHPMailer/releases
2. Download the latest release ZIP (e.g., `PHPMailer-6.8.1.zip`)
3. Extract the ZIP file

#### Step 2: Upload PHPMailer

1. In cPanel File Manager, navigate to `public_html`
2. Create a folder named `vendor`
3. Inside `vendor`, create a folder named `phpmailer`
4. Inside `phpmailer`, create a folder named `phpmailer`
5. Upload all PHPMailer files to `public_html/vendor/phpmailer/phpmailer/`

#### Step 3: Upload Composer Autoload

Since you're not using Composer, you need to create autoload manually:

1. In File Manager, go to `public_html/vendor/`
2. Click **+ File** → Name it `autoload.php`
3. Right-click `autoload.php` → **Edit**
4. Paste this code:

```php
<?php
require __DIR__ . '/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/phpmailer/phpmailer/src/Exception.php';
```

5. Save the file

---

## Configuring Email Settings

### Step 1: Add SMTP Password to PHP File

1. In cPanel File Manager, navigate to `public_html`
2. Right-click `send-email-smtp.php` → **Edit**
3. Find line 50:
```php
define('SMTP_PASSWORD', 'YOUR_ACTUAL_PASSWORD_HERE');
```
4. Replace `YOUR_ACTUAL_PASSWORD_HERE` with your actual email password:
```php
define('SMTP_PASSWORD', 'Terris27HRQu33n');
```
5. **Important:** Save the file (Ctrl+S or Cmd+S)

### Step 2: Update JavaScript Files

#### Update script.js

1. Navigate to `public_html/js/`
2. Right-click `script.js` → **Edit**
3. Find this line (around line 40-50):
```javascript
fetch('send-email.php', {
```
4. Change it to:
```javascript
fetch('send-email-smtp.php', {
```
5. Save the file

#### Update booking.js

1. In `public_html/js/`, right-click `booking.js` → **Edit**
2. Find this line (around line 150-160):
```javascript
fetch('send-email.php', {
```
3. Change it to:
```javascript
fetch('send-email-smtp.php', {
```
4. Save the file

### Step 3: Verify PHP Version

1. In cPanel, go to **SOFTWARE** section
2. Click **Select PHP Version** (or **MultiPHP Manager**)
3. Ensure PHP version is **7.4 or higher**
4. If not, select a newer version (7.4, 8.0, or 8.1)

---

## Setting Up Email Access

### Option 1: Access Email via Webmail

1. In cPanel, go to **EMAIL** section
2. Click **Email Accounts**
3. Find `reply@mahonetconsulting.com`
   - If it doesn't exist, click **Create** and set it up
4. Click **Check Email** next to the account
5. Choose a webmail client:
   - **Roundcube** (recommended - modern interface)
   - Horde
   - SquirrelMail
6. Bookmark the webmail URL for easy access

### Option 2: Configure Desktop Email Client

If you want to use Outlook, Apple Mail, Thunderbird, etc.:

**Incoming Mail Settings (IMAP):**
- Server: `mail.mahonetconsulting.com`
- Port: `993`
- Security: SSL/TLS
- Username: `reply@mahonetconsulting.com`
- Password: `Terris27HRQu33n`

**Outgoing Mail Settings (SMTP):**
- Server: `mail.mahonetconsulting.com`
- Port: `465`
- Security: SSL/TLS
- Username: `reply@mahonetconsulting.com`
- Password: `Terris27HRQu33n`
- Authentication: Required

### Option 3: Set Up Email Forwarding

To forward emails to your personal email:

1. In cPanel, go to **EMAIL** section
2. Click **Forwarders**
3. Click **Add Forwarder**
4. Enter:
   - Address to Forward: `reply@mahonetconsulting.com`
   - Destination: Your personal email
5. Click **Add Forwarder**

---

## Testing Your Website

### Step 1: Visit Your Website

1. Open a web browser
2. Go to `https://mahonetconsulting.com` (or `http://` if SSL not set up yet)
3. Verify all pages load correctly:
   - Home page (index.html)
   - About page
   - Services page
   - Contact page
   - Booking page
   - Admin page

### Step 2: Test Contact Form

1. Go to `https://mahonetconsulting.com/contact.html`
2. Fill out the form with test data
3. Submit the form
4. Check for success message
5. Check `reply@mahonetconsulting.com` for the email (allow 1-2 minutes)
6. **If no email:** Check spam/junk folder

### Step 3: Test Booking Form

1. Go to `https://mahonetconsulting.com/booking.html`
2. Complete all 4 steps:
   - Select a date
   - Choose a time slot
   - Fill in contact details
   - Confirm booking request
3. Verify success page shows "Consultation Request Submitted!"
4. Check `reply@mahonetconsulting.com` for booking notification

### Step 4: Test Admin Dashboard

1. Go to `https://mahonetconsulting.com/admin.html`
2. Verify your test submissions appear
3. Test CSV export functionality
4. Confirm data is correctly stored

### Step 5: Test Responsive Design

Test on different devices:
- Desktop (full width)
- Tablet (iPad, etc.)
- Mobile phone (iPhone, Android)

Or use browser developer tools:
- Press F12 (Chrome/Firefox)
- Click "Toggle Device Toolbar" (Ctrl+Shift+M)
- Test different screen sizes

---

## SSL Certificate Setup

GreenGeeks provides free SSL certificates via Let's Encrypt.

### Step 1: Check Current SSL Status

1. Try accessing your site with `https://mahonetconsulting.com`
2. If it works and shows a padlock icon, SSL is already active! ✓

### Step 2: Enable SSL (if not active)

1. In cPanel, go to **SECURITY** section
2. Click **SSL/TLS Status**
3. Find `mahonetconsulting.com`
4. If status is "Not Secure", click **Run AutoSSL**
5. Wait 1-5 minutes for installation

### Step 3: Force HTTPS Redirect

To automatically redirect HTTP to HTTPS:

1. In cPanel File Manager, go to `public_html`
2. Look for `.htaccess` file
   - If it doesn't exist, click **+ File** and name it `.htaccess`
3. Right-click `.htaccess` → **Edit**
4. Add this code at the top:

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

5. Save the file

### Step 4: Verify HTTPS

1. Go to `http://mahonetconsulting.com` (without the 's')
2. It should automatically redirect to `https://mahonetconsulting.com`
3. Check for padlock icon in browser address bar

---

## Troubleshooting

### Issue: "PHPMailer not installed" Error

**Solution 1:** Verify installation
```bash
ssh username@yourdomain.com
cd public_html
ls -la vendor/phpmailer/
```

**Solution 2:** Reinstall PHPMailer
```bash
cd public_html
composer install --no-dev
```

**Solution 3:** Check autoload path
- Edit `send-email-smtp.php`
- Verify line 16-17:
```php
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
```

### Issue: "SMTP Error: Could not connect"

**Possible Causes:**
1. Wrong password in `send-email-smtp.php`
2. Port 465 blocked by server firewall
3. Email account not set up in cPanel

**Solutions:**

1. **Double-check password:**
   - Edit `send-email-smtp.php`
   - Verify line 50 has correct password

2. **Try alternative port:**
   - Edit `send-email-smtp.php`
   - Change line 48-49:
```php
define('SMTP_PORT', 587);  // Changed from 465
```
   - Change line 255:
```php
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Changed from SMTPS
```

3. **Verify email account exists:**
   - cPanel → Email Accounts
   - Confirm `reply@mahonetconsulting.com` is listed

4. **Check firewall:**
   - Contact GreenGeeks support
   - Ask: "Is port 465 (or 587) open for SMTP?"

### Issue: "Email sent but not received"

**Check these locations:**

1. **Spam/Junk folder** (most common)
2. **Webmail:** Log into cPanel webmail and check there
3. **Email forwarding:** If you set up forwarding, check the destination email

**Improve deliverability:**

1. **Add SPF record:**
   - cPanel → Zone Editor
   - Add TXT record:
   - Name: `@` or `mahonetconsulting.com`
   - Value: `v=spf1 include:greengeeksmail.net ~all`

2. **Add DKIM record:**
   - cPanel → Email Deliverability
   - Click "Manage" next to domain
   - Copy DKIM record if shown
   - Add to DNS if not already present

3. **Contact GreenGeeks support:**
   - Ticket: "Email deliverability issues with reply@mahonetconsulting.com"
   - They can verify DNS records and mail server settings

### Issue: Forms Save to LocalStorage but Don't Send Email

**Diagnosis:**

1. Open browser console (F12)
2. Go to "Console" tab
3. Submit a form
4. Look for errors

**Common Errors and Fixes:**

**Error: "404 Not Found - send-email-smtp.php"**
- File is missing or in wrong location
- Solution: Verify file is in `public_html/send-email-smtp.php`

**Error: "500 Internal Server Error"**
- PHP error in send-email-smtp.php
- Solution: Check error logs in cPanel → Errors

**Error: "CORS policy blocked"**
- AJAX request blocked
- Solution: Already handled in PHP file (lines 34-37)

### Issue: Website Shows Directory Listing Instead of Home Page

**Solution:**

1. Rename `index.html` to match server default:
   - cPanel → File Manager → public_html
   - Right-click `index.html` → Rename → ensure it's exactly `index.html` (lowercase)

2. Check for index.php:
   - If you see an old `index.php` file, delete it

3. Set directory index in .htaccess:
   - Edit `.htaccess`
   - Add: `DirectoryIndex index.html`

### Issue: CSS/JavaScript Not Loading

**Check browser console:**
- F12 → Console tab
- Look for 404 errors

**Common causes:**

1. **Wrong file paths:** Should be relative paths like `css/style.css`
2. **Mixed content:** Using `http://` resources on `https://` site
3. **Files not uploaded:** Verify `css/` and `js/` folders exist

### Issue: Images Not Showing

**Check:**

1. Images uploaded to `public_html/img/`
2. File names match exactly (case-sensitive):
   - `logo.jpg` not `Logo.jpg`
   - `main-image.jpg` not `main-image.JPG`

**Fix file permissions:**
```bash
chmod 644 img/*.jpg
chmod 644 img/*.png
```

### Issue: Admin Dashboard Shows No Submissions

**Cause:** LocalStorage is browser-specific and local

**Solution:** Submit new test forms after deployment

**Note:** Old submissions from local testing won't appear on live site

### Issue: Can't Access cPanel

**Solutions:**

1. **Check login URL:** Try all these:
   - `https://yourdomain.com/cpanel`
   - `https://yourdomain.com:2083`
   - GreenGeeks client area → Login to cPanel

2. **Reset password:**
   - Log into GreenGeeks client area
   - Services → My Services
   - Select your hosting
   22
### Getting Additional Help

**GreenGeeks Support:**
- 24/7 Live Chat (fastest)
- Phone: Check GreenGeeks website for current number
- Ticket System: Via client area

**What to provide to support:**
- Domain: mahonetconsulting.com
- Issue description
- Error messages (exact text or screenshots)
- What you've already tried

**Specific email issues:**
- Email account: reply@mahonetconsulting.com
- SMTP settings: Host mail.mahonetconsulting.com, Port 465
- Request: "Help troubleshoot PHPMailer SMTP authentication"

---

## Post-Deployment Checklist

Once everything is working, complete these tasks:

### Security

- [ ] SSL certificate active (HTTPS working)
- [ ] HTTP redirects to HTTPS
- [ ] File permissions correct (644 for files, 755 for folders)
- [ ] No sensitive passwords in client-side code
- [ ] Consider adding CAPTCHA to forms (prevents spam)

### Email

- [ ] Contact form sends emails
- [ ] Booking form sends emails
- [ ] Emails arrive in inbox (not spam)
- [ ] Email access configured (webmail or desktop client)
- [ ] Auto-responder set up (optional)

### Testing

- [ ] All pages load correctly
- [ ] All links work
- [ ] Forms submit successfully
- [ ] Responsive design works on mobile
- [ ] Images display correctly
- [ ] Admin dashboard accessible

### DNS & SEO

- [ ] Domain resolves correctly
- [ ] www and non-www both work
- [ ] Add to Google Search Console
- [ ] Submit sitemap (optional)
- [ ] Set up Google Analytics (optional)

### Monitoring

- [ ] Bookmark webmail for email access
- [ ] Bookmark cPanel for management
- [ ] Set up regular backups (cPanel → Backup Wizard)
- [ ] Test email notifications weekly

---

## Summary

You've successfully deployed your MahoneT HR Consulting website!

**What's now live:**
✅ Full website on mahonetconsulting.com
✅ Email integration with reply@mahonetconsulting.com
✅ Contact and booking forms
✅ Admin dashboard
✅ Responsive design for all devices
✅ SSL certificate (HTTPS)

**Regular maintenance:**
- Check emails daily at reply@mahonetconsulting.com
- Review form submissions weekly via admin.html
- Respond to consultation requests within 24 hours
- Back up website monthly via cPanel

**Need help?** Contact GreenGeeks 24/7 support or refer to troubleshooting section above.

---

Last updated: November 6, 2025
