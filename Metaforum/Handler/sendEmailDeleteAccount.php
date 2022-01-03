<?php
include_once('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
$email = $_REQUEST['email'];
$username = $_REQUEST['username'];
$userid = $_REQUEST['userid'];
$mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'tls://smtp.gmail.com:587';                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'metaforumbinus@gmail.com';                     //SMTP username
        $mail->Password   = 'binusmaya123';                               //SMTP password
    
        //Recipients
        $mail->setFrom('metaforumbinus@gmail.com', 'Metaforum');
        $mail->addAddress($email, $username);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verify your account!';
        $link = "http://localhost/Metaforum/Handler/verifyDeleteAccount.php?userid=".$userid."";
        $mail->Body    = '<button><a href ='.'"'.$link.'">Verify Delete Account</a></button><br>Please press the look safe button so the verify delete account button can work!';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
?>