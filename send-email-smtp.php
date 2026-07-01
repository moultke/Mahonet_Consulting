<?php
/**
 * MahoneT HR Consulting - Email Handler with PHPMailer
 * Handles contact form and booking submissions with SMTP authentication
 */

// IMPORTANT: Before this works, you need to install PHPMailer
// Run: composer require phpmailer/phpmailer
// Or download PHPMailer manually and include the files

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Try to load PHPMailer via Composer
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    // If PHPMailer is not installed, return error
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'PHPMailer not installed. Please run: composer require phpmailer/phpmailer'
    ]);
    exit;
}

// Disable error display in production
ini_set('display_errors', 0);
error_reporting(E_ALL);

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Email configuration - credentials loaded from environment or .env file
// On cPanel, set these in cPanel > Setup PHP Variables, or create a .env file in the site root
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $envLines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            putenv(trim($line));
        }
    }
}

define('SMTP_HOST', getenv('SMTP_HOST') ?: 'mail.mahonetconsulting.com');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 465);
define('SMTP_USERNAME', getenv('SMTP_USERNAME') ?: 'reply@mahonetconsulting.com');
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD') ?: '');
define('SMTP_FROM', getenv('SMTP_FROM') ?: 'reply@mahonetconsulting.com');
define('SMTP_FROM_NAME', 'MahoneT HR Consulting Website');
define('SMTP_TO', getenv('SMTP_TO') ?: 'reply@mahonetconsulting.com');
define('SMTP_TO_NAME', 'MahoneT HR Consulting');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
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

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Build email content
if ($type === 'consultation_booking') {
    $date = isset($data['date']) ? htmlspecialchars(strip_tags($data['date'])) : '';
    $time = isset($data['time']) ? htmlspecialchars(strip_tags($data['time'])) : '';
    $meetingType = isset($data['meetingType']) ? htmlspecialchars(strip_tags($data['meetingType'])) : '';
    $meetingTypeLabel = $meetingType === 'zoom' ? 'Video Call (Zoom)' : 'Phone Call';

    $emailSubject = "New Consultation Booking Request - $name";
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; }
            .header { background: #571326; color: white; padding: 30px; text-align: center; }
            .header h2 { margin: 0; font-size: 24px; }
            .content { padding: 30px; background: #ffffff; }
            .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            .info-table td { padding: 12px 15px; border-bottom: 1px solid #e0e0e0; }
            .info-table td:first-child { font-weight: bold; width: 180px; color: #571326; }
            .highlight { background: #fff3e0; padding: 15px; border-left: 4px solid #FF6B35; margin: 20px 0; }
            .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>🗓️ New Consultation Booking Request</h2>
            </div>
            <div class='content'>
                <p>You have received a new consultation booking request from your website.</p>

                <table class='info-table'>
                    <tr>
                        <td>Name:</td>
                        <td><strong>$name</strong></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><a href='mailto:$email' style='color: #FF6B35;'>$email</a></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>$phone</td>
                    </tr>
                    " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                    <tr>
                        <td>Requested Date:</td>
                        <td><strong style='color: #571326;'>$date</strong></td>
                    </tr>
                    <tr>
                        <td>Requested Time:</td>
                        <td><strong style='color: #571326;'>$time EST</strong></td>
                    </tr>
                    <tr>
                        <td>Meeting Format:</td>
                        <td>$meetingTypeLabel</td>
                    </tr>
                    " . ($message ? "<tr><td>Additional Notes:</td><td>$message</td></tr>" : "") . "
                    <tr>
                        <td>Submitted:</td>
                        <td>" . date('F j, Y g:i A') . "</td>
                    </tr>
                </table>

                <div class='highlight'>
                    <strong>⚠️ Action Required:</strong><br>
                    This is a <strong>requested time slot</strong> - please confirm availability and send a confirmation email to the client within 24 hours.
                </div>

                <p><strong>Next Steps:</strong></p>
                <ul>
                    <li>Check your calendar for availability at the requested time</li>
                    <li>Reply to <a href='mailto:$email'>$email</a> to confirm or suggest alternative times</li>
                    <li>Send calendar invite once confirmed</li>
                </ul>
            </div>
            <div class='footer'>
                <p>This booking request was submitted via the MahoneT HR Consulting website.</p>
                <p style='margin: 5px 0;'><a href='https://mahonetconsulting.com' style='color: #571326;'>mahonetconsulting.com</a></p>
            </div>
        </div>
    </body>
    </html>
    ";
} else {
    // Contact form
    $subjectLabels = [
        'compliance' => 'HR Compliance & Audits',
        'recruiting' => 'Recruiting & Talent Acquisition',
        'policies' => 'Policy & Employee Handbooks',
        'relations' => 'Employee Relations',
        'leadership' => 'Leadership Coaching & Training',
        'general' => 'General Inquiry'
    ];
    $subjectLabel = isset($subjectLabels[$subject]) ? $subjectLabels[$subject] : $subject;

    $emailSubject = "New Contact Form Submission - $name";
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; }
            .header { background: #571326; color: white; padding: 30px; text-align: center; }
            .header h2 { margin: 0; font-size: 24px; }
            .content { padding: 30px; background: #ffffff; }
            .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            .info-table td { padding: 12px 15px; border-bottom: 1px solid #e0e0e0; }
            .info-table td:first-child { font-weight: bold; width: 180px; color: #571326; }
            .message-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>📧 New Contact Form Submission</h2>
            </div>
            <div class='content'>
                <p>You have received a new message from your website contact form.</p>

                <table class='info-table'>
                    <tr>
                        <td>Name:</td>
                        <td><strong>$name</strong></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><a href='mailto:$email' style='color: #FF6B35;'>$email</a></td>
                    </tr>
                    " . ($phone ? "<tr><td>Phone:</td><td>$phone</td></tr>" : "") . "
                    " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                    " . ($subjectLabel ? "<tr><td>Subject:</td><td><strong style='color: #571326;'>$subjectLabel</strong></td></tr>" : "") . "
                    <tr>
                        <td>Submitted:</td>
                        <td>" . date('F j, Y g:i A') . "</td>
                    </tr>
                </table>

                " . ($message ? "
                <div class='message-box'>
                    <strong style='color: #571326;'>Message:</strong><br><br>
                    " . nl2br($message) . "
                </div>
                " : "") . "

                <p><strong>Reply to this inquiry by clicking:</strong> <a href='mailto:$email' style='color: #FF6B35; font-weight: bold;'>$email</a></p>
            </div>
            <div class='footer'>
                <p>This message was sent from the MahoneT HR Consulting website contact form.</p>
                <p style='margin: 5px 0;'><a href='https://mahonetconsulting.com' style='color: #571326;'>mahonetconsulting.com</a></p>
            </div>
        </div>
    </body>
    </html>
    ";
}

// Send email using PHPMailer
try {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->SMTPDebug = 0; // Set to 2 for debugging
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL on port 465
    $mail->Port = SMTP_PORT;

    // Recipients
    $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
    $mail->addAddress(SMTP_TO, SMTP_TO_NAME);
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $emailSubject;
    $mail->Body = $emailBody;
    $mail->AltBody = strip_tags($emailBody);

    // Send
    $mail->send();

    echo json_encode([
        'success' => true,
        'message' => 'Email sent successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo
    ]);
}
?>