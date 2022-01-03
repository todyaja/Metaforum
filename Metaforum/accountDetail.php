<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.js"></script>
    <link href="accountDetail.css" rel="stylesheet">
    <title>Document</title>
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
        <div id="ajax"></div>
        

</body>
</html>
<script>
    function goHome(){
       window.location.href="http://localhost/Metaforum/homepage.php";
    }
    var userId = '<?php echo $_GET['userid'] ?>';
    $.ajax({
        url:'functions/getAccountDetail.php',
        async:false,
        data:{userid:userId},
        success:function(e){
            let data = JSON.parse(e);
            document.getElementById('ajax').innerHTML=`<div style="background-color: pink; padding:15px;" class="header"> ${data[0].Username}'s Profile</div>
        <div class="content">
            <div class="avatar">
                <div class="avatar-detail">
                    <img src="assets/${data[0].Display_Picture}" alt="avatar"><br>
                    ${data[0].Username}<br>
                    ${data[0].Islogin}<br>
                    </div>
                <div class="user-detail">
                    ${data[0].Role}<br>
                    ${data[0].thread_count} post(s)<br>
                    Moments ago<br>
                    ${data[0].Status}<br>
                </div>
            </div>
            <div class="informations">
                <div class="about-me">
                    About me<br><hr>
                    ${data[0].Description}
                </div>
                <div class="detail">
                    <div class="additional-info">
                        Additional Information<br><hr>  
                        Username: ${data[0].Username}<br>
                        Email: ${data[0].Email}<br>
                        Most Active in:  ${data[0].CategoryName} (${data[0].GroupName})<br>
                        Number of hearts:  ${data[0].fav_count}<br>
                    </div>
                    <div class="recent-post">
                        Recent Posts On<br><hr>
                        <div id ="threads" class="threads">

                        </div>
                    </div>
                </div>
            </div>

        </div>`
        }
    })
    $.ajax({
        url:'functions/getThreadbyUserID.php',
        async:false,
        data:{userid:userId},
        success:function(e){
            let data = JSON.parse(e);
            document.getElementById('threads').innerHTML = 
                `${data.map((item) => (
                    `<div class="thread-card"><div class="title-thread">${item.Title}</div><div class="author-thread">by ${item.Username}</div> ${item.timediff}</div>`)).join('')}`;
        }
    })
</script>