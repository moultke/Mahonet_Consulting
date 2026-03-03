<?php
/**
 * MahoneT HR Consulting - Email Handler
 * Handles contact form and booking submissions
 */

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// CORS headers for AJAX requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Email configuration
define('SMTP_HOST', 'mail.mahonetconsulting.com');
define('SMTP_PORT', 465);
define('SMTP_USERNAME', 'reply@mahonetconsulting.com');
define('SMTP_PASSWORD', 'YOUR_ACTUAL_PASSWORD_HERE'); // Replace this!
define('SMTP_FROM', 'reply@mahonetconsulting.com');
define('SMTP_FROM_NAME', 'MahoneT HR Consulting Website');
define('SMTP_TO', 'reply@mahonetconsulting.com');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// If not JSON, try regular POST
if (!$data) {
    $data = $_POST;
}

// Validate required fields
if (empty($data['name']) || empty($data['email'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name and email are required']);
    exit;
}

// Sanitize inputs
$name = htmlspecialchars(strip_tags($data['name']));
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$phone = isset($data['phone']) ? htmlspecialchars(strip_tags($data['phone'])) : '';
$organization = isset($data['organization']) ? htmlspecialchars(strip_tags($data['organization'])) : '';
$message = isset($data['message']) ? htmlspecialchars(strip_tags($data['message'])) : '';
$subject = isset($data['subject']) ? htmlspecialchars(strip_tags($data['subject'])) : '';
$type = isset($data['type']) ? htmlspecialchars(strip_tags($data['type'])) : 'contact_form';

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Build email content based on type
if ($type === 'consultation_booking') {
    // Booking form
    $date = isset($data['date']) ? htmlspecialchars(strip_tags($data['date'])) : '';
    $time = isset($data['time']) ? htmlspecialchars(strip_tags($data['time'])) : '';
    $meetingType = isset($data['meetingType']) ? htmlspecialchars(strip_tags($data['meetingType'])) : '';

    $emailSubject = "New Consultation Booking - $name";
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background: #571326; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            .info-table td { padding: 10px; border-bottom: 1px solid #ddd; }
            .info-table td:first-child { font-weight: bold; width: 180px; color: #571326; }
            .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 0.9em; color: #666; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>New Consultation Booking</h2>
        </div>
        <div class='content'>
            <p>You have received a new consultation booking request from your website.</p>

            <table class='info-table'>
                <tr>
                    <td>Name:</td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><a href='mailto:$email'>$email</a></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>$phone</td>
                </tr>
                " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                <tr>
                    <td>Preferred Date:</td>
                    <td><strong>$date</strong></td>
                </tr>
                <tr>
                    <td>Preferred Time:</td>
                    <td><strong>$time</strong></td>
                </tr>
                <tr>
                    <td>Meeting Format:</td>
                    <td>$meetingType</td>
                </tr>
                " . ($message ? "<tr><td>Message:</td><td>$message</td></tr>" : "") . "
                <tr>
                    <td>Submitted:</td>
                    <td>" . date('F j, Y g:i A') . "</td>
                </tr>
            </table>

            <p><strong>Action Required:</strong> Please confirm this appointment with the client within 24 hours.</p>
        </div>
        <div class='footer'>
            <p>This email was sent from the MahoneT HR Consulting website contact form.</p>
        </div>
    </body>
    </html>
    ";
} else {
    // Contact form
    $subjectLabel = '';
    switch($subject) {
        case 'compliance': $subjectLabel = 'HR Compliance & Audits'; break;
        case 'recruiting': $subjectLabel = 'Recruiting & Talent Acquisition'; break;
        case 'policies': $subjectLabel = 'Policy & Employee Handbooks'; break;
        case 'relations': $subjectLabel = 'Employee Relations'; break;
        case 'leadership': $subjectLabel = 'Leadership Coaching & Training'; break;
        case 'general': $subjectLabel = 'General Inquiry'; break;
        default: $subjectLabel = $subject;
    }

    $emailSubject = "New Contact Form Submission - $name";
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background: #571326; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            .info-table td { padding: 10px; border-bottom: 1px solid #ddd; }
            .info-table td:first-child { font-weight: bold; width: 180px; color: #571326; }
            .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 0.9em; color: #666; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>New Contact Form Submission</h2>
        </div>
        <div class='content'>
            <p>You have received a new message from your website contact form.</p>

            <table class='info-table'>
                <tr>
                    <td>Name:</td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><a href='mailto:$email'>$email</a></td>
                </tr>
                " . ($phone ? "<tr><td>Phone:</td><td>$phone</td></tr>" : "") . "
                " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                " . ($subjectLabel ? "<tr><td>Subject:</td><td>$subjectLabel</td></tr>" : "") . "
                " . ($message ? "<tr><td>Message:</td><td>$message</td></tr>" : "") . "
                <tr>
                    <td>Submitted:</td>
                    <td>" . date('F j, Y g:i A') . "</td>
                </tr>
            </table>
        </div>
        <div class='footer'>
            <p>This email was sent from the MahoneT HR Consulting website contact form.</p>
        </div>
    </body>
    </html>
    ";
}

// Send email using SMTP
try {
    // Create email headers
    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM . ">\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send email using PHP mail() function
    // Note: For proper SMTP with authentication, you'll need PHPMailer library
    $mailSent = mail(SMTP_TO, $emailSubject, $emailBody, $headers);

    if ($mailSent) {
        echo json_encode([
            'success' => true,
            'message' => 'Email sent successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send email. Please try again later.'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
?>