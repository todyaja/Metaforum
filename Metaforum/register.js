let error = false;
document.getElementById("register").addEventListener("submit", (event)=>
{
    event.preventDefault();
    let username = document.getElementById("Username")
    let email = document.getElementById("Email")
    let password = document.getElementById("Password");
    let confirmpassword = document.getElementById("cPassword");
    var alphanumeric= /^[a-z0-9]+$/i
    if (!username.value.match(alphanumeric)){
        document.getElementById("username-error").innerHTML="Username must only contain alphanumeric characters"
        error=true;
    }
    else if(username.value.length<6||username.value.length>20){
        document.getElementById("username-error").innerHTML="Username must be between 6 and 20 characters long";
        error=true;
    }else{
        document.getElementById("username-error").innerHTML=""
    }
    validateUsernameUsed(username.value)
    if(!validateEmail(email.value)){
        document.getElementById("email-error").innerHTML="Invalid e-mail format"
        error=true;
    }else{
        document.getElementById("email-error").innerHTML=""
    }
    if(password.value.length<8){
        document.getElementById("password-error").innerHTML="Password must be at least 8 characters long"
        error=true;
    }else{
        document.getElementById("password-error").innerHTML=""
    }
    if(password.value!=confirmpassword.value){
        document.getElementById("cpassword-error").innerHTML="Please correctly confirm the password"
        error=true;
    }else{
        document.getElementById("cpassword-error").innerHTML=""
    }
    if(document.getElementById("username-error").innerHTML!=""){
        error=true;
    }
    if(!error){
        $.ajax({
            url: 'Model/createUser.php',
            type: 'post',
            data: {Username:username.value,
                Email:email.value,
                Password:password.value},
            success: function(response){
                window.location.href = 'login.php';
                alert('Registered Succesfully');
            }
         });
    }
});
function validateEmail(email) 
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
function validateUsername (username)
    {
        var re = /^[0-9a-zA-Z]+$/;
        return re.test(username);
    }

function validateUsernameUsed(username){
    $.ajax({
        url: 'validateUsername.php',
        type: 'post',
        async: false,
        data: {username:username},
        success: function(response){
            if(response>=1){
                document.getElementById("username-error").innerHTML="Username is already taken"
                error=true
            }else{
                error=false;
            }
        }
     });
}

