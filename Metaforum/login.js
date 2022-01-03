let error=false;
document.getElementById("login").addEventListener("submit", (event)=>
{
    event.preventDefault();
    let usernameEmail = document.getElementById("username-email")
    let password = document.getElementById("password");
    if(!validateEmail(usernameEmail.value)){
        //user input username
        validateUsernameExists(usernameEmail.value, password.value)
        // console.log('tes');
    }else{
        //user input email
        validateEmailExists(usernameEmail.value, password.value)
    }
    if(!error){
        window.location.href = "homepage.php";
    }

});
function validateEmail($email) 
    {
        var re = /\S+@\S+\.\S+/;
        return re.test($email);
    }

function validateEmailExists($email, $password){
    $.ajax({
        url: 'functions/getUserbyEmail.php',
        type: 'post',
        async: false,
        data: {email:$email, password:$password},
        success: function(response){
            if(response=="Invalid Password"){
                document.getElementById("username-email-error").innerHTML = "";
                document.getElementById("password-error").innerHTML = response;
                error=true;
            }
            else if(response=="E-mail is not associated with an account"){
                document.getElementById("username-email-error").innerHTML = response;
                error=true;
            }
            else{
                error=false;
            }
        }
     });
}

function validateUsernameExists($username, $password){
    $.ajax({
        url: 'functions/getUserbyUsernamelogin.php',
        type: 'post',
        async: false,
        data: {username:$username, password:$password},
        success: function(response){
            console.log(response);
            if(response=="Invalid Password"){
                document.getElementById("username-email-error").innerHTML = "";
                document.getElementById("password-error").innerHTML = response;
                error=true;
            }
            else if(response=="Username does not exist."){
                document.getElementById("username-email-error").innerHTML = response;
                error=true;
            }
            else{
                error=false;
            }
        }
     });
}
