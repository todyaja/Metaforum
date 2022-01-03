<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="accountManagement.css" rel="stylesheet">
    <script src="jquery.js"></script>
</head>
<body style="background-color: rgb(238, 240, 255)">
<?php
            if(!isset($_SESSION['Role'])){
                echo '<div class="userIsNotLogin">';
                echo '<a href="register.php"><button>Sign Up</button></a>';
                echo '<a href="login.php"><button>Login</button></a>';
                echo '<img onclick="goHome()" src="assets/metaforum_logo.png">';
                echo '</div>';
            }
            else{
                echo '<div class="userIsLogin">';
                echo '<a href="Handler/logoutHandler.php"><button>Logout</button></a>';
                echo '<img onclick="goHome()" src="assets/metaforum_logo.png">';
                echo '<a href="accountManagement.php"><button>Account</button></a>';
                echo '</div>';
            }
            ?>
    <form id = "change-account-form" action="" method="post" enctype="multipart/form-data">
        
    </form>
    <div style="width: 100%; background-color:cyan; padding:5px;">Changing the fields below require you to access the link sent into your associated e-mail's inbox</div>
        <label for="password">Change Password</label>
        <input type="password" name="password" id="password" placeholder="New Password">
        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password"><br>
        <p id="error-password"></p>
        <button onclick="changePassword()">Save Change Password</button><br>
        <label for="email">Change Email</label>
        <input type="text" name="email" id="email"><br>
        <p id="error-email"></p>
        <button onclick="changeEmail()">Submit Change Email</button><br>
        <label for="username">Delete Account</label>
        <input type="username" name="username" id="inputusername" placeholder="Re-input your username here and submit"><br>
        <p id="error-inputusername"></p>
        <label for="password">Input Password</label>
        <input type="password" name="dpassword" id="dpassword" placeholder="Input your password to submit changes"><br>
        <p id="error-password"></p>
        <button onclick="deleteAccount()">Submit Delete Account</button>
</body>
</html>
<script>
    passcheck="";
    function goHome(){
       window.location.href="http://localhost/Metaforum/homepage.php";
    }
    var pass="";
    $.ajax({
        url: "functions/getUserbyUserID.php",
        data:{userid:'<?php echo $_SESSION['UserID']?>'},
        async:true,
        success:function(response){
            let data = JSON.parse(response)
            document.getElementById('change-account-form').innerHTML=
            `<label for="username">Display Name</label>
            <input type="text" name="username" id="username" value="${data.Username}" ${data.display_editable}> <p id="error-username"></p>
            <p style="font-size: 12px; color:red">YOU CAN ONLY CHANGE YOUR DISPLAY NAME ONCE A MONTH</p>
            <label for="description">About</label>
            <input type="text" name="description" id="description" value="${data.Description}"><br>
            <label for="email-visibility">E-mail Visibility</label>
            <input type="checkbox" name="email-visibility" id="email-visibility" ${data.isChecked}  ><br>
            <label for="image">Avatar</label>
            <input type="file" name="image" id="image"><br>
            <input onclick="validateUsername()" type="button" value="SAVE">`
            email= data.Email;
            username=data.Username;
            document.getElementById('email').value=`${email}`;
        }
    })
    function validateUsername(){
        var uname = document.getElementById('username').value
        var alphanumeric= /^[a-z0-9]+$/i
        $.ajax({
        url: 'validateUsernameChange.php',
        type: 'post',
        async: false,
        data: {username:uname},
        success: function(response){
            if(response>=1){
                document.getElementById("error-username").innerHTML="Username is already taken"
            }else{
                if(uname.length<6||uname.length>20){
                    document.getElementById("error-username").innerHTML="Username must be between 6 and 20 characters long"
                }
                else if(!uname.match(alphanumeric)){
                    document.getElementById("error-username").innerHTML="Username is already taken/Username must only contain alphanumeric characters"
                }
                else{
                    changeAccount();
                }
            }
        }
     });
    }
    function changeAccount(){
        var fd = new FormData();
        fd.append('username',document.getElementById('username').value)
        fd.append('description',document.getElementById('description').value)
        fd.append('email-visibility',document.getElementById('email-visibility').checked)
        var files = $('#image')[0].files[0]
        fd.append('image', files)
            $.ajax({
                url :'Handler/changeAccount.php',
                type:'post',
                async:false,
                data:fd,
                contentType: false,
                processData: false,
                success:function(e){
                    alert(e);
                    window.location.href="homepage.php"
                }

            })
    }
    function changePassword(){
        password = document.getElementById('password');
        cpassword = document.getElementById('cpassword');
        if(password.value.length<8){
            document.getElementById('error-password').innerHTML="Password must be at least 8 characters long"
        }
        else if(password.value!=cpassword.value){
            document.getElementById('error-password').innerHTML="Please correctly confirm your password";
        }
        else{
            document.getElementById('error-password').innerHTML="";
            $.ajax({
                url:"Handler/sendEmailChangePassword.php",
                async:false,
                data:{password:password.value,email:email,username:username,userid:'<?php echo $_SESSION['UserID']?>'},
                success:function(e){
                    console.log(e);
                }
            })
        }
    }
    function deleteAccount(){
        var inputpass = document.getElementById('dpassword').value;
        if(document.getElementById('inputusername').value!=username){
            document.getElementById("error-inputusername").innerHTML="Username invalid";
        }else if(document.getElementById('inputusername').value==username){
            document.getElementById("error-inputusername").innerHTML=``;
            $.ajax({
                url: "functions/getUserbyUserID.php",
                data:{userid:'<?php echo $_SESSION['UserID']?>'},
                async:true,
                success:function(response){
                    let data = JSON.parse(response)
                    passcheck=data.Password;
                }
            })
            $.ajax({
                url:"functions/verifyPassword.php",
                data:{password:inputpass, passcheck:passcheck},
                async:false,
                success:function(e){
                    if(e=="ok"){
                        document.getElementById('error-password').innerHTML="";
                        $.ajax({
                            url:'Handler/sendEmailDeleteAccount.php',
                            async:false,
                            data:{userid:'<?php echo $_SESSION['UserID']?>',email:email,username:username},
                            success:function(e){
                                alert('an email has been sent to your email address to verify delete account');
                            }
                        })
                    }
                    else{
                        document.getElementById('error-password').innerHTML="Wrong Password";
                    }
                }
            })
        }
    }
    
    function validateEmail(email) 
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    function changeEmail(){
        emailinput = document.getElementById('email');
        if(validateEmail(emailinput.value)){
            document.getElementById('error-email').innerHTML="";
            console.log('ok');
            $.ajax({
                url:'Handler/editEmail.php',
                async:false,
                data:{email:emailinput.value},
                success:function(e){
                    console.log(e);
                    alert('change email successful, dont forget to verify your email');
                }
            })
        }else{
            document.getElementById('error-email').innerHTML="Invalid e-mail format";
        }
    }


</script>