<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


ini_set('display_errors', 1);
error_reporting(E_ALL);


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $firstName = isset($_POST['firstName']) ? htmlspecialchars(trim($_POST['firstName'])) : null;
    $lastName = isset($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName'])) : null;
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : null;
    $mathAnswer = isset($_POST['mathAnswer']) ? htmlspecialchars(trim($_POST['mathAnswer'])) : null;

    if (empty($firstName) || empty($lastName) || empty($phone) || empty($email) || empty($mathAnswer)) {
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>All fields are required.</div>";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Please enter a valid email address.</div>";
        exit;
    }

 
    if ($mathAnswer != "5") {
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Incorrect answer to math question.</div>";
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

       
        $mail->setFrom('aviinyou07@gmail.com', 'Interior Hub');
        $mail->addAddress($_ENV['RECIPIENT_EMAIL']);

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Audit Form Submission';
        $mail->Body = "First Name: $firstName\n"
                     . "Last Name: $lastName\n"
                     . "Phone: $phone\n"
                     . "Email: $email\n"
                     . "Math Answer: $mathAnswer";

        $mail->send();

        // Success message
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #28a745; border-radius: 4px; background-color: #d4edda; color: #155724; width: 80%; text-align: center;' role='alert'>Thanks for contacting us! We will be in touch with you shortly.</div>";
    } catch (Exception $e) {
        
        echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Message could not be sent. Please try again later. Error: {$mail->ErrorInfo}</div>";
    }
} else {
    
    echo "<div style='padding: 10px; margin: 10px auto; border: 1px solid #dc3545; border-radius: 4px; background-color: #f8d7da; color: #721c24; width: 80%; text-align: center;' role='alert'>Invalid request method.</div>";
}
?>
