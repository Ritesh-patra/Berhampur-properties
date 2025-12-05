<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './mailer/PHPMailer.php';
require './mailer/SMTP.php';
require './mailer/Exception.php';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // Your Gmail
    $mail->Username = "patrasagarika654@gmail.com";
    $mail->Password = "rggc jbrt qygn fowo";

    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    // ⭐ DYNAMIC SET-FROM (User email from form)
    $userEmail = $_POST['email'];
    $userName = $_POST['owner'];

    $mail->setFrom($userEmail, $userName);

    // ⭐ Your email (receiver)
    $mail->addAddress("patrasagarika654@gmail.com", "Berhampur Property's");

    // ⭐ Reply to user also
    $mail->addReplyTo($userEmail, $userName);

    $mail->isHTML(true);
    $mail->Subject = "New Property Submission From: $userName";

    // FORM DATA
    $owner = $_POST['owner'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    // Email Body
    $mail->Body = "
        <h2>New Property Submission</h2>
        <p><strong>Name:</strong> $owner</p>
        <p><strong>Email:</strong> $userEmail</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Property Type:</strong> $type</p>
        <p><strong>Location:</strong> $location</p>
        <p><strong>Price:</strong> ₹$price</p>
        <p><strong>Description:</strong> $desc</p>
    ";

    // ⭐ Attach uploaded images
    if (!empty($_FILES['images']['name'][0])) {
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

            $tmp = $_FILES['images']['tmp_name'][$i];
            $name = $_FILES['images']['name'][$i];

            if (is_uploaded_file($tmp)) {
                $mail->addAttachment($tmp, $name);
            }
        }
    }

    $mail->send();
    echo "SUCCESS";

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

?>