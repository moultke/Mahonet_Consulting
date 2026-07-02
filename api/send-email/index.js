const { EmailClient } = require("@azure/communication-email");

module.exports = async function (context, req) {
  // Only accept POST
  if (req.method !== "POST") {
    context.res = { status: 405, body: { success: false, message: "Method not allowed" } };
    return;
  }

  const data = req.body;

  // Validate required fields
  if (!data || !data.name || !data.email) {
    context.res = {
      status: 400,
      headers: { "Content-Type": "application/json" },
      body: { success: false, message: "Name and email are required" }
    };
    return;
  }

  // Validate email format
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(data.email)) {
    context.res = {
      status: 400,
      headers: { "Content-Type": "application/json" },
      body: { success: false, message: "Invalid email format" }
    };
    return;
  }

  const connectionString = process.env.AZURE_COMMUNICATION_CONNECTION_STRING;
  const senderAddress = process.env.SENDER_EMAIL || "DoNotReply@mahonetconsulting.com";
  const recipientEmail = process.env.RECIPIENT_EMAIL || "reply@mahonetconsulting.com";

  // Build email content
  let subject, htmlBody;
  const name = escapeHtml(data.name);
  const email = escapeHtml(data.email);
  const phone = escapeHtml(data.phone || "");
  const organization = escapeHtml(data.organization || "");
  const message = escapeHtml(data.message || "");

  if (data.type === "consultation_booking") {
    const date = escapeHtml(data.date || "");
    const time = escapeHtml(data.time || "");
    const meetingType = data.meetingType === "zoom" ? "Video Call (Zoom)" : "Phone Call";

    subject = `New Consultation Booking Request - ${name}`;
    htmlBody = `
      <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <div style="background: #571326; color: white; padding: 30px; text-align: center;">
          <h2 style="margin: 0;">New Consultation Booking Request</h2>
        </div>
        <div style="padding: 30px; background: #ffffff;">
          <p>You have received a new consultation booking request from your website.</p>
          <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Name:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>${name}</strong></td></tr>
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Email:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${email}</td></tr>
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Phone:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${phone}</td></tr>
            ${organization ? `<tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Organization:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${organization}</td></tr>` : ""}
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Requested Date:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>${date}</strong></td></tr>
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Requested Time:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>${time} EST</strong></td></tr>
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Meeting Format:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${meetingType}</td></tr>
            ${message ? `<tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Notes:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${message}</td></tr>` : ""}
          </table>
          <div style="background: #fff3e0; border-left: 4px solid #FF6B35; padding: 15px; margin: 20px 0;">
            <strong>Action Required:</strong> Please confirm availability and send a confirmation email within 24 hours.
          </div>
        </div>
        <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #666;">
          Submitted via MahoneT HR Consulting website
        </div>
      </div>`;
  } else {
    const subjectLabels = {
      compliance: "HR Compliance & Audits",
      recruiting: "Recruiting & Talent Acquisition",
      policies: "Policy & Employee Handbooks",
      relations: "Employee Relations",
      leadership: "Leadership Coaching & Training",
      general: "General Inquiry"
    };
    const subjectLabel = subjectLabels[data.subject] || data.subject || "General Inquiry";

    subject = `New Contact Form Submission - ${name}`;
    htmlBody = `
      <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <div style="background: #571326; color: white; padding: 30px; text-align: center;">
          <h2 style="margin: 0;">New Contact Form Submission</h2>
        </div>
        <div style="padding: 30px; background: #ffffff;">
          <p>You have received a new message from your website contact form.</p>
          <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Name:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>${name}</strong></td></tr>
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Email:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${email}</td></tr>
            ${phone ? `<tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Phone:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${phone}</td></tr>` : ""}
            ${organization ? `<tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Organization:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;">${organization}</td></tr>` : ""}
            <tr><td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #571326;">Subject:</td><td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><strong>${subjectLabel}</strong></td></tr>
          </table>
          ${message ? `<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;"><strong style="color: #571326;">Message:</strong><br><br>${message.replace(/\n/g, "<br>")}</div>` : ""}
          <p><strong>Reply to:</strong> ${email}</p>
        </div>
        <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #666;">
          Submitted via MahoneT HR Consulting website
        </div>
      </div>`;
  }

  try {
    const emailClient = new EmailClient(connectionString);

    const emailMessage = {
      senderAddress: senderAddress,
      content: {
        subject: subject,
        html: htmlBody,
        plainText: htmlBody.replace(/<[^>]*>/g, "")
      },
      recipients: {
        to: [{ address: recipientEmail, displayName: "MahoneT HR Consulting" }]
      },
      replyTo: [{ address: data.email, displayName: data.name }]
    };

    const poller = await emailClient.beginSend(emailMessage);
    const result = await poller.pollUntilDone();

    context.res = {
      status: 200,
      headers: { "Content-Type": "application/json" },
      body: { success: true, message: "Email sent successfully", messageId: result.id }
    };
  } catch (error) {
    context.log.error("Email send error:", error.message);
    context.res = {
      status: 500,
      headers: { "Content-Type": "application/json" },
      body: { success: false, message: "Email could not be sent" }
    };
  }
};

function escapeHtml(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
