

<?php

$config = require __DIR__ . '/../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer-master/src/Exception.php';
require __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer-master/src/SMTP.php';

$successMsg = "";
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP CONFIG
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username = $config['smtp_email'];
        $mail->Password = $config['smtp_pass']; // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // EMAIL
       $mail->setFrom('jivangauli321@gmail.com', 'Portfolio Contact');
    $mail->addReplyTo($email, $name);
    $mail->addAddress('jivangauli321@gmail.com');

    $mail->Subject = 'New Contact Form Submission';
    $mail->Body = "
    Name: $name
    Email: $email

    Message: $message";


        $mail->send();
        $successMsg = "Message sent successfully!";
    } catch (Exception $e) {
        $errorMsg = "Unable to Send Mail: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact | Jeevan Gauli</title>

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/dfuzexd10.github.io/style.css">
    <link rel="stylesheet" href="contact.css">
</head>
<body>

<?php 
$activePage = 'contact';
include '../navbar.php';
?>

<section class="contact-section">
    <div class="container">

        <h2 class="section-title">Get in Touch</h2>

        <?php if ($successMsg): ?>
            <p style="color:#00ff9c; margin-bottom:20px;">
                <?= $successMsg ?>
            </p>
        <?php endif; ?>

        <?php if ($errorMsg): ?>
            <p style="color:red; margin-bottom:20px;">
                <?= $errorMsg ?>
            </p>
        <?php endif; ?>

        <form class="contact-form" method="post" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="send-btn">
                Send Email →
            </button>
        </form>

        <div class="contact-email">
            <i class="fa-regular fa-envelope"></i>
            <span>Email: jivangauli@gmail.com</span>
        </div>

    </div>
</section>

</body>
</html>
