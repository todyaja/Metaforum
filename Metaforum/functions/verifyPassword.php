<?php 
$password= $_REQUEST['password'];
$passcheck = $_REQUEST['passcheck'];
if(password_verify($password, $passcheck)){
    echo("ok");
}
else{
    echo("notok");
}
?>