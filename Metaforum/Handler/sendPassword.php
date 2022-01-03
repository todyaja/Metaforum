<?php
include_once('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
$conn = getConnection();
$email = $_REQUEST['email'];
$newpassword = uniqid();
$insertpass = password_hash($newpassword,PASSWORD_DEFAULT);
$query = "SELECT UserID, Username FROM user WHERE user.Email LIKE '$email' AND user.Deleted_At IS NULL ";
$result = mysqli_query($conn,$query);
    if ($result) {
        while($data = mysqli_fetch_array($result)){
            $userid = $data['UserID'];
            $username = $data['Username'];
        }

    } else {
        echo "Error: " . $query . $conn->error;
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
        $mail->addAddress($email, $username);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Link to reset password';
        $link = "http://localhost/Metaforum/insertNewPassword.php?userID=".$userid." ";
        $mail->Body    = '<button><a href ='.'"'.$link.'">Reset Password</a></button><br>Please press the look safe button so the reset password button can work!';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
?>