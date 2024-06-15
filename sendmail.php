<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
error_reporting(E_ALL);


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>All fields are required.</div>";
        exit;
    }

    $mail = new PHPMailer(true);
    try {
     
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('aviinyou07@gmail.com', 'Interior Hub');
        $mail->addAddress($_ENV['RECIPIENT_EMAIL']);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "Name: $name\nEmail: $email\n\n$message";

        if ($mail->send()) {
         
            echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #28a745; border-radius: 4px; background-color: #d4edda; color: #155724; width: 80%; text-align: center;' role='alert'>Thanks for contacting us! We will be in touch with you shortly.</div>";
            echo "<p style='margin-top: 10px; text-align: center;'>Redirecting back to the contact form in <span id='countdown' style='font-weight: bold;'>5</span> seconds...</p>";
            echo "<button onclick='redirectNow()' style='padding: 8px 16px; margin-top: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; display: block; margin: 0 auto;'>Redirect Now</button>";
            echo "<script>
                    // Countdown and redirect after 5 seconds
                    var countdown = 5;
                    setInterval(function() {
                        countdown--;
                        document.getElementById('countdown').textContent = countdown;
                        if (countdown <= 0) {
                            window.location.href = 'contact.html';
                        }
                    }, 1000);

                    function redirectNow() {
                        window.location.href = 'contact.html';
                    }
                  </script>";
        } else {
         
            echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Message could not be sent. Please try again later. Error: {$mail->ErrorInfo}</div>";
        }
    } catch (Exception $e) {
 
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Message could not be sent. Please try again later. Error: {$mail->ErrorInfo}</div>";
    }
} else {
  
    echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Invalid request method.</div>";
}
?>

