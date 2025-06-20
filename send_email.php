<?php
// filepath: c:\xampp\htdocs\new Web\web22\send_email.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendSMTPMail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // For Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'youraddress@gmail.com'; // Your Gmail address
        $mail->Password = 'your_app_password';     // Your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('youraddress@gmail.com', 'TechRica');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // For debugging: echo $mail->ErrorInfo;
        return false;
    }
}