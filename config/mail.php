<?php
// FILE: config/mail.php
// PHPMailer configured for Gmail SMTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

define('SMTP_USER', getenv('SMTP_USER') ?: 'your@gmail.com');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');


/**
 * sendOtpEmail() — Sends a 2FA OTP to the specified address.
 * @param string $toEmail   Recipient email address
 * @param string $toName    Recipient display name
 * @param string $otp       Plaintext OTP (6 digits)
 * @return bool             true on success, false on failure
 */
function sendOtpEmail(string $toEmail, string $toName, string $otp): bool {
    $mail = new PHPMailer(true);
    try {
        // Server config
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your IS351 Login Verification Code';
        $mail->Body    = '
            <div style="font-family:Arial,sans-serif;max-width:480px;margin:auto;
                         border:1px solid #ddd;border-radius:8px;overflow:hidden">
              <div style="background:#2E75B6;padding:20px;text-align:center">
                <h2 style="color:#fff;margin:0">IS351 Security Lab</h2>
              </div>
              <div style="padding:30px">
                <p>Hello <strong>' . htmlspecialchars($toName) . '</strong>,</p>
                <p>Your one-time login code is:</p>
                <div style="font-size:36px;font-weight:bold;letter-spacing:8px;
                            text-align:center;color:#1F4E79;padding:20px 0">' . $otp . '</div>
                <p>This code expires in <strong>10 minutes</strong>.
                   Do not share it with anyone.</p>
                <p style="color:#999;font-size:12px">
                   If you did not attempt to log in, ignore this email.</p>
              </div>
            </div>';
        $mail->AltBody = 'Your IS351 login code is: ' . $otp . ' (expires in 10 min)';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('PHPMailer error: ' . $mail->ErrorInfo);
        return false;
    }
}
?>
