<?php
/**
 * MahoneT HR Consulting - Email Handler using Azure Communication Services
 * Handles contact form and booking submissions via Azure Email API
 */

ini_set('display_errors', 0);
error_reporting(E_ALL);

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Azure Communication Services configuration (loaded from environment / App Settings)
$acsEndpoint = getenv('ACS_ENDPOINT') ?: '';
$acsAccessKey = getenv('ACS_ACCESS_KEY') ?: '';
$acsSenderAddress = getenv('ACS_SENDER_ADDRESS') ?: '';
$notificationEmail = getenv('NOTIFICATION_EMAIL') ?: 'reply@mahonetconsulting.com';

if (empty($acsEndpoint) || empty($acsAccessKey) || empty($acsSenderAddress)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Email service not configured']);
    exit;
}

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
                <h2>New Consultation Booking Request</h2>
            </div>
            <div class='content'>
                <p>You have received a new consultation booking request from your website.</p>
                <table class='info-table'>
                    <tr><td>Name:</td><td><strong>$name</strong></td></tr>
                    <tr><td>Email:</td><td><a href='mailto:$email' style='color: #FF6B35;'>$email</a></td></tr>
                    <tr><td>Phone:</td><td>$phone</td></tr>
                    " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                    <tr><td>Requested Date:</td><td><strong style='color: #571326;'>$date</strong></td></tr>
                    <tr><td>Requested Time:</td><td><strong style='color: #571326;'>$time EST</strong></td></tr>
                    <tr><td>Meeting Format:</td><td>$meetingTypeLabel</td></tr>
                    " . ($message ? "<tr><td>Additional Notes:</td><td>$message</td></tr>" : "") . "
                    <tr><td>Submitted:</td><td>" . date('F j, Y g:i A') . "</td></tr>
                </table>
                <div class='highlight'>
                    <strong>Action Required:</strong><br>
                    This is a <strong>requested time slot</strong> - please confirm availability and send a confirmation email to the client within 24 hours.
                </div>
            </div>
            <div class='footer'>
                <p>This booking request was submitted via the MahoneT HR Consulting website.</p>
                <p><a href='https://mahonetconsulting.com' style='color: #571326;'>mahonetconsulting.com</a></p>
            </div>
        </div>
    </body>
    </html>";
} else {
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
                <h2>New Contact Form Submission</h2>
            </div>
            <div class='content'>
                <p>You have received a new message from your website contact form.</p>
                <table class='info-table'>
                    <tr><td>Name:</td><td><strong>$name</strong></td></tr>
                    <tr><td>Email:</td><td><a href='mailto:$email' style='color: #FF6B35;'>$email</a></td></tr>
                    " . ($phone ? "<tr><td>Phone:</td><td>$phone</td></tr>" : "") . "
                    " . ($organization ? "<tr><td>Organization:</td><td>$organization</td></tr>" : "") . "
                    " . ($subjectLabel ? "<tr><td>Subject:</td><td><strong style='color: #571326;'>$subjectLabel</strong></td></tr>" : "") . "
                    <tr><td>Submitted:</td><td>" . date('F j, Y g:i A') . "</td></tr>
                </table>
                " . ($message ? "
                <div class='message-box'>
                    <strong style='color: #571326;'>Message:</strong><br><br>
                    " . nl2br($message) . "
                </div>" : "") . "
                <p><strong>Reply to this inquiry:</strong> <a href='mailto:$email' style='color: #FF6B35;'>$email</a></p>
            </div>
            <div class='footer'>
                <p>This message was sent from the MahoneT HR Consulting website.</p>
                <p><a href='https://mahonetconsulting.com' style='color: #571326;'>mahonetconsulting.com</a></p>
            </div>
        </div>
    </body>
    </html>";
}

// Send email via Azure Communication Services REST API
try {
    $apiVersion = '2023-03-31';
    $url = rtrim($acsEndpoint, '/') . "/emails:send?api-version=$apiVersion";

    $emailPayload = [
        'senderAddress' => $acsSenderAddress,
        'content' => [
            'subject' => $emailSubject,
            'html' => $emailBody,
            'plainText' => strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $emailBody))
        ],
        'recipients' => [
            'to' => [
                [
                    'address' => $notificationEmail,
                    'displayName' => 'MahoneT HR Consulting'
                ]
            ]
        ],
        'replyTo' => [
            [
                'address' => $email,
                'displayName' => $name
            ]
        ]
    ];

    $jsonPayload = json_encode($emailPayload);
    $contentHash = base64_encode(hash('sha256', $jsonPayload, true));
    $date = gmdate('D, d M Y H:i:s T');

    // Parse the endpoint URL
    $parsedUrl = parse_url($acsEndpoint);
    $host = $parsedUrl['host'];

    // Build the string to sign (HMAC-SHA256)
    $pathAndQuery = "/emails:send?api-version=$apiVersion";
    $stringToSign = "POST\n$pathAndQuery\n$date;$host;$contentHash";
    $signature = base64_encode(hash_hmac('sha256', $stringToSign, base64_decode($acsAccessKey), true));

    $headers = [
        'Content-Type: application/json',
        "x-ms-date: $date",
        "x-ms-content-sha256: $contentHash",
        "Authorization: HMAC-SHA256 SignedHeaders=x-ms-date;host;x-ms-content-sha256&Signature=$signature",
        'x-ms-communication-sticky: true'
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $jsonPayload,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        throw new Exception("Connection error: $curlError");
    }

    if ($httpCode >= 200 && $httpCode < 300) {
        echo json_encode([
            'success' => true,
            'message' => 'Your message has been sent successfully. We will get back to you within 24 hours.'
        ]);
    } else {
        $responseData = json_decode($response, true);
        $errorMsg = isset($responseData['error']['message']) ? $responseData['error']['message'] : 'Unknown error';
        throw new Exception("Azure Email API error ($httpCode): $errorMsg");
    }

} catch (Exception $e) {
    error_log("MahoneT Email Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unable to send email at this time. Please try again later or contact us directly.'
    ]);
}
?>