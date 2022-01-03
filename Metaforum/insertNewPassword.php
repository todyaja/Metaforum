<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.js"></script>
    <title>Document</title>
</head>
<body>
    Insert your new password<br>
    <input id="password" type="password" placeholder="Password"><br>
    <p id="error-password"></p>
    <input id="cpassword" type="password" placeholder="Confirm Password"><br>
    <p id="error-cpassword"></p>
    <button id="submit">Submit</button>
</body>
</html>
<script>

document.getElementById("submit").addEventListener("click", resetPassword);

function resetPassword(){
    error = false;
    password = document.getElementById('password');
    cpassword = document.getElementById('cpassword');
    if(password.value.length<8){
        error = true;
        document.getElementById('error-password').innerHTML="Password must be at least 8 characters long"
    }
    if(password.value!=cpassword.value){
        error=true;
        document.getElementById('error-cpassword').innerHTML="Please correctly confirm the password"
    }
    if(!error){
        $.ajax({
            url:'Handler/resetPassword.php',
            async:false,
            data:{password:password.value,userid:'<?php echo $_REQUEST['userID']?>'},
            success:function(response){
                alert('Password has been successfully reset');
                window.location.href = "login.php";
            }
        })
    }
}
</script>