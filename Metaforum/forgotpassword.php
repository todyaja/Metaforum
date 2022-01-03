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
    <input id="email" name="email" type="text" placeholder="E-mail">
    <button onclick="sendPasswordtoEmail()">SEND PASSWORD RESET LINK</button>
    <a href="login.php"><button>Back to Login</button></a>
</body>
</html>
<script>
function sendPasswordtoEmail(){
    let email = document.getElementById("email").value;
    $.ajax({
        url:'Handler/sendPassword.php',
        async:false,
        data:{email:email},
        success: function(response){
            alert('Please check your email to reset your password!')
            window.location.href="login.php"
        }
    })
}
    

</script>