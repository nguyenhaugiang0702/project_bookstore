<?php
require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send($title, $content, $tennguoinhan, $mailnguoinhan, $diachicc = '')
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // gửi mail SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'nguyenhaugiang0702@gmail.com'; // SMTP username
        $mail->Password = 'dyjwpppxcrzoxhrj'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('nguyenhaugiang0702@gmail.com', 'BOOKSTORE');
        $mail->addAddress($mailnguoinhan, $tennguoinhan); // Add a recipient

        // Content
        $mail->isHTML(true);   // Set email format to HTML
        $mail->Subject = "=?utf-8?b?" . base64_encode($title) . "?=";
        $mail->Body = $content;
        $mail->AltBody = '';

        $mail->send();
        return true;
        //echo "<div class='alert alert-success'>Thư đã được gửi</div>";
    } catch (Exception $e) {
        //echo "<div class='alert alert-danger'>Thư chưa được gửi</div>";
    }
}
