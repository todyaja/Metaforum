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
    <link rel = "stylesheet" href ="homepage.css">
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
            echo '<div>';
            if($_SESSION['Role']==1){
                echo '<a href="userManagement.php"><button style="width:150px;">User Management</button></a>';
            }
            echo '<a href="accountManagement.php"><button>Account</button></a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    <div class="title">
        Recent Abuse Report
        <hr>
    </div>
    <div class="content">
        <div id="group" class="group">
        </div>
        <div id="category" class="category">
            Please Choose a Group!
        </div>
        <div id="thread" class="thread">
        </div>
    </div>
    <div id="main-post">
    </div>
    <div id="moderate-form">

    </div>
</body>
</html>
<script>
    let group=document.getElementById("group")
    let category=document.getElementById("category")
    function goHome(){
       window.location.href="http://localhost/Metaforum/homepage.php";
    }
    $.ajax({
            url: 'functions/getAllGroupWithinReport.php',
            success: function(response){
                let data = JSON.parse(response);
                group.innerHTML = `${data.map((item) => (`<div onclick="getCategorybyGroupID(${item.GroupID})" class="group-card">${item.GroupName.toUpperCase()}</div>`)).join('')}`;
            }
        })
    function getCategorybyGroupID(groupid){
        $.ajax({
            url: 'functions/getAllCategoriesWithinReport.php',
            data:{groupid:groupid},
            success:function(response){
                if(response!='[]'){
                let data = JSON.parse(response);
                category.innerHTML = `${data.map((item) => (`<div onclick="getReportbyCategoryID(${item.CategoryID})" class="category-card">${item.CategoryName.toUpperCase()}</div>`)).join('')}`;
                }
                else{
                category.innerHTML = "This group does not have any category at the moment";
                thread.innerHTML="";
                }
            }
        })
    }
    function getReportbyCategoryID(categoryid){
        $.ajax({
            url: 'functions/getReportbyCategory.php',
            data:{categoryid:categoryid},
            success:function(response){
                if(response!='[]'){
                let data = JSON.parse(response);
                    thread.innerHTML = 
                    `${data.map((item) => (
                        `<div onclick="getThreadDetailbyThreadID('${item.ThreadID}','${item.UserThreadID}')" class="thread-card"><div class="title-thread">${item.Title}</div>Report by ${item.reportBy}
                        Reported : ${item.reported}   ${item.timediff}</div>`)).join('')}`;
                }
                else{
                    thread.innerHTML = "This category does not have any thread at the moment";
                }
            }
        })
    }
    function getThreadDetailbyThreadID(threadid,userid){
        $.ajax({
            url: 'functions/getThreadDetail.php',
            async: false,
            data: {threadid:threadid, userid:userid},
            success:function(response){
                let data = JSON.parse(response);
                document.getElementById('main-post').innerHTML=`<div style="background-color: cyan; width:100%; height:fit-content; padding:5px;" class="main-forum-header"><div>Main Post</div><div>${data[0].timediff}</div></div>
                    <div>
                        <div class="create-thread-content">
                            <div class="user">
                                <div class="avatar">
                                    <img onclick="window.location='accountDetail.php?userid=${data[0].UserID}';" src="assets/${data[0].Display_Picture}" alt="avatar"><br>
                                    ${data[0].Username}<br>
                                    ${data[0].Islogin}<br>
                                </div>
                                <div class="user-detail">
                                    ${data[0].Role}<br>
                                    ${data[0].user_posts} post(s)<br>
                                    Moments ago<br>
                                    ${data[0].Status}<br>
                                </div>
                            </div>
                            <div class="thread-content-description">
                                ${data[0].Title}
                                <hr style="width: 100%;">
                                ${data[0].Description}
                            </div>
                        </div>
                        <div class="main-thread-footer">
                        <div class="favorites">
                            ${data[0].favorite_count} user has favorites this post
                        </div>
                        <div class="actions">
                            <button onclick = "showModerateForm('${threadid}','${data[0].UserID}','${data[0].Email}')">Moderate</button>
                        </div>
                        </div>
                    </div>`
            }
        });
    }
    function showModerateForm(threadid,userreportid,email){
        var userId = '<?php if(isset($_SESSION['UserID']))
                            {echo $_SESSION['UserID'];
                            }
                            else echo 'null'?>'
        document.getElementById('moderate-form').innerHTML=`<div style="background-color: yellow; width:100%; height:fit-content; padding:5px;" class="create-forum-header">Moderating</div>
                    <div>
                        <div class="create-thread-content">
                            <div id="user-reply-thread" class="user">
                                
                            </div>
                            <div class="thread-input">
                                <input id="report-message" type="text" placeholder="Input your message here...">
                            </div>
                        </div>
                        <div class="confirm-thread-creation">
                            <button onclick="document.getElementById('moderate-form')=""">X</button>
                            <div>
                            <select id="bannedhour">
                            <option value="3">3 hours</option>
                            <option value="6">6 hours</option>
                            <option value="12">12 hours</option>
                            <option value="24">24 hours</option>
                            </select>
                            <select id="bannedtype">
                            <option value="1">Pardoned</option>
                            <option value="2">Silenced</option>
                            <option value="3">Banned</option>
                            </select>
                            <button onclick="Moderate('${userreportid}','${email}','${threadid}')">Y</button>
                            </div>
                        </div>
                    </div>`
        
        $.ajax({
            url:'functions/getAvatarData.php',
            data:{userid:userId},
            async:false,
            success:function(e){
            let data = JSON.parse(e);
                document.getElementById('user-reply-thread').innerHTML=`
                                <div class="avatar">
                                    <img onclick="window.location='accountDetail.php?userid=${data[0].UserID}';" src="assets/${data[0].Display_Picture}" alt="avatar"><br>
                                    ${data[0].Username}<br>
                                    ${data[0].Islogin}<br>
                                </div>
                                <div class="user-detail">
                                    ${data[0].Role}<br>
                                    ${data[0].user_posts} post(s)<br>
                                    Moments ago<br>
                                    ${data[0].Status}<br>
                                </div>`
            }
        })
    }
    function Moderate(userid,email,threadid){
        bannedhour = document.getElementById('bannedhour').value
        bannedtype = document.getElementById('bannedtype').value
        reportmessage = document.getElementById('report-message').value
        $.ajax({
            url:"Handler/moderateUser.php",
            async:false,
            data:{userid:userid,email:email,bannedhour:bannedhour,bannedtype:bannedtype,reportmessage:reportmessage,threadid:threadid},
            success:function(e){
                console.log(e);
                alert('Moderate success');
            }
        })
    }
    
</script>