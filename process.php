<?php
// process.php

// Block non-POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method Not Allowed");
}

// Include PHPMailer classes (make sure /phpmailer/ folder is in the root)
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';
require __DIR__ . '/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Simple sanitize helper
function clean($s) { return trim(filter_var($s, FILTER_SANITIZE_STRING)); }

// Collect form fields
$first   = clean($_POST["firstName"] ?? "");
$last    = clean($_POST["lastName"] ?? "");
$email   = filter_var($_POST["email"] ?? "", FILTER_VALIDATE_EMAIL);
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

// Honeypot field (hidden in your form with CSS)
$website = $_POST["website"] ?? "";
if (!empty($website)) {
    http_response_code(200);
    exit("OK"); // silently drop bots
}

// Validate required fields
if (!$first || !$last || !$email || !$message) {
    http_response_code(400);
    exit("Missing required fields.");
}

// ======== CONFIGURE THESE VALUES ========
$smtpHost   = "mail.tylervolpert.me";      // SMTP host (from your provider)
$smtpPort   = 587;                         // 587 (TLS) or 465 (SSL)
$smtpUser   = "tylervolpert22@tylervolpert.me";    // full email address
$smtpPass   = "dog-chance-22";       // mailbox password or app password
$fromEmail  = "tylervolpert22@tylervolpert.me";    // must be your domain email
$fromName   = "tylervolpert.me Contact Form";              // appears in From name
$toEmail    = "tylervolpert22@gmail.com";        // where you want to receive messages
// ========================================

// Build subject if left blank
if ($subject === "") {
    $subject = "New contact form message from $first $last ($fromName)";
}

// Build body
$body = "Name: $first $last\n";
$body .= "Email: $email\n";
$body .= "Subject: $subject\n\n";
$body .= "Message:\n$message\n";

$mail = new PHPMailer(true);
$mail->SMTPDebug = 2;          // show conversation
$mail->Debugoutput = 'html';   // easier to read in browser


try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    if ($smtpPort == 465) {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    }
    $mail->Port       = $smtpPort;

    // Sender & recipient
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($toEmail);
    $mail->addReplyTo($email, "$first $last");

    // Content
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Send
    $mail->send();
    header("Location: messagesent.html"); // redirect on success
    exit();
} catch (Exception $e) {
    http_response_code(500);
    echo "Message failed to send. Error: " . $mail->ErrorInfo;
}
