<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : null;

 
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div style='color: red; text-align: center;'>Please enter a valid email address.</div>";
        exit;
    }

  
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME']; 
        $mail->Password = $_ENV['SMTP_PASSWORD']; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your-email@example.com', 'Your Name'); 
        $mail->addAddress('newsletter@example.com'); // 

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'New Newsletter Subscription';
        $mail->Body = "New subscriber:\nEmail: $email";

        // Send email
        $mail->send();
        echo "<div style='color: green; text-align: center;'>Thank you for subscribing!</div>";
    } catch (Exception $e) {
        echo "<div style='color: red; text-align: center;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
    }
} else {
    echo "<div style='color: red; text-align: center;'>Invalid request method.</div>";
}
?>
