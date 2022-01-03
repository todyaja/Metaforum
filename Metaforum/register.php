<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body style="text-align: center; padding-top:15%">
<img src="assets/metaforum_logo.png">
    <form id="register" action="" method="post">
        <input type="text" name="Email" id="Email" placeholder="Email">
        <p id="email-error"></p>
        <input type="text" name="Username" id="Username" placeholder="Username">
        <p id="username-error"></p>
        <input type="password" name="Password" id="Password" placeholder="Password">
        <p id="password-error"></p>
        <input type="password" name="cPassword" id="cPassword" placeholder="Confirm Password">
        <p id="cpassword-error"></p>
        <input type="submit" value="SignUp">
    </form>
    <a href="login.php">Back to login</a>
</body>
</html>
<script src='register.js'>
</script>