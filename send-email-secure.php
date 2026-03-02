<?php
/**
 * MahoneT HR Consulting - Secure Email Handler
 * Uses PHP's built-in mail() function - NO passwords needed!
 * Handles contact form and booking submissions
 */

// Disable error display in production
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

// Email configuration - NO PASSWORDS STORED!
define('EMAIL_TO', 'reply@mahonetconsulting.com');
define('EMAIL_FROM', 'reply@mahonetconsulting.com');
define('EMAIL_FROM_NAME', 'MahoneT HR Consulting Website');

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

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Build email content based on type
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

// Send email using PHP's built-in mail() function
// This uses the server's mail system - NO passwords needed!
try {
    $headers = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM . ">\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send notification to business
    $mailSent = mail(EMAIL_TO, $emailSubject, $emailBody, $headers);

    // If this is a booking request, also send confirmation to customer
    if ($type === 'consultation_booking' && $mailSent) {
        $customerSubject = "We've Received Your Consultation Request - MHRC";
        $customerBody = "
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
                .highlight { background: #fff3e0; padding: 20px; border-left: 4px solid #FF6B35; margin: 20px 0; }
                .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>✅ We've Received Your Consultation Request!</h2>
                </div>
                <div class='content'>
                    <p>Hi <strong>$name</strong>,</p>
                    <p>Thank you for requesting a consultation with MahoneT HR Consulting (MHRC). We're excited to connect with you!</p>

                    <h3 style='color: #571326; margin-top: 30px;'>Your Requested Details:</h3>
                    <table class='info-table'>
                        <tr>
                            <td>Date:</td>
                            <td><strong style='color: #571326;'>$date</strong></td>
                        </tr>
                        <tr>
                            <td>Time:</td>
                            <td><strong style='color: #571326;'>$time EST</strong></td>
                        </tr>
                        <tr>
                            <td>Meeting Format:</td>
                            <td>$meetingTypeLabel</td>
                        </tr>
                        " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                    </table>

                    <div class='highlight'>
                        <h3 style='margin-top: 0; color: #571326;'>📅 What Happens Next?</h3>
                        <p style='margin: 10px 0;'>Within the next <strong>24 hours</strong>, we will:</p>
                        <ol style='margin: 10px 0; padding-left: 20px;'>
                            <li><strong>Review your requested time slot</strong> and confirm availability</li>
                            <li><strong>Send you a confirmation email</strong> with either:
                                <ul style='margin-top: 5px;'>
                                    <li>A calendar invite if the time works, OR</li>
                                    <li>Alternative time suggestions</li>
                                </ul>
                            </li>
                            <li><strong>Provide meeting details</strong> (Zoom link or phone number)</li>
                        </ol>
                        <p style='margin: 15px 0 0 0;'><strong>Watch your inbox</strong> (and spam folder) for our confirmation!</p>
                    </div>

                    <h3 style='color: #571326;'>During Your 30-Minute Consultation:</h3>
                    <ul style='line-height: 1.8;'>
                        <li>Discuss your current HR pain points</li>
                        <li>Explore compliance concerns (CARF, OHMAS, etc.)</li>
                        <li>Get clarity on hiring and retention</li>
                        <li>Learn how MHRC can support your business</li>
                        <li>Receive a customized action plan</li>
                    </ul>

                    <p style='margin-top: 30px;'>If you have any questions before then, feel free to reply to this email or call us at <strong>(216) 245-8367</strong>.</p>

                    <p style='margin-top: 20px;'>Looking forward to speaking with you!</p>
                    <p style='margin: 5px 0;'><strong>Terris MahoneT</strong><br>
                    Founder, MahoneT HR Consulting</p>
                </div>
                <div class='footer'>
                    <p><strong>MahoneT HR Consulting</strong></p>
                    <p style='margin: 5px 0;'>📞 (216) 245-8367</p>
                    <p style='margin: 5px 0;'><a href='https://mahonetconsulting.com' style='color: #571326;'>mahonetconsulting.com</a></p>
                </div>
            </div>
        </body>
        </html>
        ";

        // Send customer confirmation
        $customerHeaders = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM . ">\r\n";
        $customerHeaders .= "Reply-To: " . EMAIL_FROM . "\r\n";
        $customerHeaders .= "MIME-Version: 1.0\r\n";
        $customerHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($email, $customerSubject, $customerBody, $customerHeaders);
    }

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
