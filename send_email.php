<?php

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
        $mail->Username = 'njugunawilson977@gmail.com'; // Your Gmail address
        $mail->Password = 'dlng ulrl pwaz bdaq';     // Your Gmail App Password
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
          $mail->CharSet = 'UTF-8';
          //$mail->$isHTML(true); 

        // Email settings
        $mail->setFrom('njugunawilson977@gmail.com', 'TechRica');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
       
    } catch (Exception $e) {
    echo $mail->ErrorInfo;
        return false;
    }

     header("Location: reset-password.php?timeout=1");
}