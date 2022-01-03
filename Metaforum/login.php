<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.js"></script>
    <title>Document</title>
</head>
<body style="text-align: center; padding-top:15%">
<img src="assets/metaforum_logo.png">
    <form id="login" action="">
        <input type="text" name="username-email" id="username-email" placeholder="Username or E-mail">
        <p id="username-email-error"></p>
        <input type="password" name="password" id="password" placeholder="Password">
        <p id="password-error"></p>
        <input type="submit" value="Login">
    </form>
    <a href="forgotpassword.php">Forgot Password?</a><br>
    Dont have an account? <a href="register.php">Sign Up Here!</a>
</body>
</html>
<script src="login.js"></script>