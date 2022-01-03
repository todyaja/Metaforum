<?php 
session_start();
include_once ('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$conn = getConnection();
$userid = $_SESSION['UserID'];
$email = $_REQUEST['email'];
$query = "UPDATE user SET Email = '$email', Verified = 0 WHERE user.UserID = '$userid' AND user.Deleted_At IS NULL ";
if ($conn->query($query) === TRUE) {
    echo "Change email successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'tls://smtp.gmail.com:587';                   //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'metaforumbinus@gmail.com';                     //SMTP username
    $mail->Password   = 'binusmaya123';                               //SMTP password

    //Recipients
    $mail->setFrom('metaforumbinus@gmail.com', 'Metaforum');
    $mail->addAddress($email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verify your account!';
    $link = "http://localhost/Metaforum/Model/verifyUser.php?userID=".$userid." ";
    $mail->Body    = '<button><a href ='.'"'.$link.'">Verify account</a></button><br>Please press the look safe button so the verify account button can work!';
    // $mail->Body='halolagi';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}
?>