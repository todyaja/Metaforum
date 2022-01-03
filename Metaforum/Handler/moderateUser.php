<?php 
include_once('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$conn = getConnection();
$bannedhour = $_REQUEST['bannedhour'];
$bannedtype = $_REQUEST['bannedtype'];
$email = $_REQUEST['email'];
$userid = $_REQUEST['userid'];
$threadid = $_REQUEST['threadid'];
$reportmessage = $_REQUEST['reportmessage'];
$query = "UPDATE user SET Status = $bannedtype, banned_date = DATE_ADD(now(),interval $bannedhour hour), banned_ThreadID = '$threadid' WHERE user.UserID like '$userid'";
if ($conn->query($query) === TRUE) {
    echo "Moderation inserted successfully<br>";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
try {
    $mail = new PHPMailer(true);
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
    $mail->Subject = 'Your Account has been Moderated';
    $mail->Body    = "${reportmessage}";
    // $mail->Body='halolagi';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>