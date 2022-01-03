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
    <div id="create-thread" class="create-thread">
    <h2>Forum Groups</h2>
    <div id="btnCreateThread">
    </div>
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
    <div id="report-form">

    </div>
    <div id="reply-post">
    </div>
    <div id="reply-form">
    </div>
    <div id="thread-form">
    </div>
</body>
</html>
<script>
    function goHome(){
       window.location.href="http://localhost/Metaforum/homepage.php";
    }
    let group=document.getElementById("group")
    let category=document.getElementById("category")
    let thread=document.getElementById("thread")
    let btnCreateThread =document.getElementById("btnCreateThread")
        $.ajax({
            url: 'functions/getAllGroup.php',
            success: function(response){
                let data = JSON.parse(response);
                group.innerHTML = `${data.map((item) => (`<div onclick="getCategorybyGroupID(${item.GroupID})" class="group-card">${item.GroupName.toUpperCase()}</div>`)).join('')}`;
            }
        })

function getCategorybyGroupID(groupid){
    document.getElementById('main-post').innerHTML="";
    document.getElementById('reply-post').innerHTML="";
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    $.ajax({
        url: 'functions/getAllCategories.php',
        data:{groupid:groupid,userid:userId},
        success:function(response){
            console.log(response);
            if(response!='[]'){
            let data = JSON.parse(response);
            category.innerHTML = `${data.map((item) => (`<div onclick="getThreadbyCategoryID(${item.CategoryID})" class="category-card">${item.CategoryName.toUpperCase()}</div>`)).join('')}`;
            }
            else{
            category.innerHTML = "This group does not have any category at the moment";
            thread.innerHTML="";
            }
            btnCreateThread.innerHTML="";

        }
    })
}

function getThreadbyCategoryID(categoryid){
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    // btnCreateThread.innerHTML=``
    console.log(userId);
    if(userId!="null"){btnCreateThread.innerHTML=`<button onclick=createThread(${categoryid})>CreateThread</button>`};
    document.getElementById('main-post').innerHTML=``
    document.getElementById('reply-post').innerHTML="";
    $.ajax({
        url: 'functions/getThreadbyCategory.php',
        data:{categoryid:categoryid},
        success:function(response){
            if(response!='[]'){
            let data = JSON.parse(response);
                thread.innerHTML = 
                `${data.map((item) => (
                    `<div onclick="getThreadDetailbyThreadID('${item.ThreadID}','${item.UserID}')" class="thread-card"><div id="hot-thread">${item.isHot}</div><div class="title-thread">${item.Title}</div><div class="author-thread">by ${item.Username}</div>
                    <div class="views"><img src="assets/view_logo.png"> ${item.View}</div><div class="replies"><img src="assets/reply_logo.png"> ${item.Reply}</div>${item.timediff}</div>`)).join('')}`;
            }
            else{
                thread.innerHTML = "This category does not have any thread at the moment";
            }
        }
    })
}

function createThread(categoryid){
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    
    $.ajax({
        url:'functions/getAvatarData.php',
        data:{userid:userId},
        async:false,
        success:function(e){
        let data = JSON.parse(e);
        ver = data[0].Verified;
            if(data[0].Verified==0){
                alert('You must verify your email address before you can create threads!');
                return;
            }
        }
    })
    if(ver==0){
        return;
    }
    $.ajax({
        url: 'functions/getCategory.php',
        data:{categoryid:categoryid},
        async:false,
        success:function(response){
            if(response!='[]'){
            let data = JSON.parse(response);
            document.getElementById('thread-form').innerHTML=`
                <div style="background-color: pink; width:100%; height:fit-content; padding:5px;" class="create-forum-header">Creating Thread in ${data[0].CategoryName}</div>
                <div>
                    <div class="create-thread-content">
                        <div id="user-create-thread" class="user">
                            
                        </div>
                        <div class="thread-input">
                            <input id="thread-title" type="text" placeholder="Input thread title...">
                            <hr style="width: 100%;">
                            <input id="thread-desc" type="text" placeholder="Input thread description...">
                        </div>
                    </div>
                    <div class="confirm-thread-creation">
                        <button onclick="hideThreadForm()">X</button>
                        <button onclick="confirmCreateThread(${data[0].CategoryID})" >Y</button>
                    </div>
                </div>`
            }
        }
    })
    $.ajax({
        url:'functions/getAvatarData.php',
        data:{userid:userId},
        async:false,
        success:function(e){
        let data = JSON.parse(e);
            document.getElementById('user-create-thread').innerHTML=`
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
function hideThreadForm(){
    document.getElementById('thread-form').innerHTML="";
}
function confirmCreateThread(categoryid){
    $.ajax({
        url: 'Model/createThread.php',
        async: false,
        data:{categoryid:categoryid,
            title:document.getElementById('thread-title').value,
            desc:document.getElementById('thread-desc').value},
        method:'post',
        success:function(response){
            alert('Thread created succesfully');
            document.getElementById('thread-form').innerHTML="";
            getThreadbyCategoryID(categoryid);
        }
    })
}
function getThreadDetailbyThreadID(threadid,userid){
    $.ajax({
        url:'functions/addViewThread.php',
        async:false,
        data:{threadid:threadid},
        success(e){
            console.log(e);
        }
    })
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    
    $.ajax({
        url: 'functions/getThreadDetail.php',
        async: false,
        data: {threadid:threadid, userid:userid},
        success:function(response){
            let data = JSON.parse(response);
            let canReply = data[0].canReply;
            let isSilenced = data[0].isSilenced;
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
                    <div id ="actions" class="actions">
                    
                    </div>
                    </div>
                </div>`
                if(canReply=='reply'){
                    if(isSilenced=='reply'){
                        document.getElementById('actions').innerHTML=`<button id="favButton" onclick ="favoriteButton('${threadid}',this.innerHTML)">${data[0].favorite_button}</button>
                        <button id ="replyButton" onclick ="showReplyForm('${threadid}')">reply</button>
                        <button onclick = "showReportForm('${threadid}','${data[0].UserID}')">report</button>`
                    }else{
                    document.getElementById('actions').innerHTML=`<button id="favButton" onclick ="favoriteButton('${threadid}',this.innerHTML)">${data[0].favorite_button}</button>
                    <button onclick = "showReportForm('${threadid}','${data[0].UserID}')">report</button>`
                    }
                }else{
                    document.getElementById('actions').innerHTML=`<button id="favButton" onclick ="favoriteButton('${threadid}',this.innerHTML)">${data[0].favorite_button}</button>
                    <button onclick = "showReportForm('${threadid}','${data[0].UserID}')">report</button>`
                }
        }
    });
    
    $.ajax({
        url: 'functions/getThreadReplies.php',
        async:false,
        data:{threadid:threadid},
        success:function(response){
            let data = JSON.parse(response);
            document.getElementById('reply-post').innerHTML =  `${data.map((item) => (
                    `<div style="background-color: cyan; width:100%; height:fit-content; padding:5px;" class="main-forum-header"><div>Reply to Main Post</div><div>${item.timediff}</div></div>
                <div>
                    <div class="create-thread-content">
                        <div class="user">
                            <div class="avatar">
                                <img onclick="window.location='accountDetail.php?userid=${item.UserID}';"  src="assets/${item.Display_Picture}" alt="avatar"><br>
                                ${item.Username}<br>
                                ${item.Islogin}<br>
                            </div>
                            <div class="user-detail">
                                ${item.Role}<br>
                                ${item.user_posts} post(s)<br>
                                Moments ago<br>
                                ${item.Status}<br>
                            </div>
                        </div>
                        <div class="thread-input">
                            ${item.ReplyDescription}
                        </div>
                    </div>
                    </div>
                </div>`
                    )).join('')}`;
        }
    })
}
function hideReplyForm(){
    document.getElementById('reply-form').innerHTML="";   
}
function showReplyForm(threadid){
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    document.getElementById('reply-form').innerHTML=`<div style="background-color: pink; width:100%; height:fit-content; padding:5px;" class="create-forum-header">Creating Reply to Main Post</div>
                <div>
                    <div class="create-thread-content">
                        <div id="user-reply-thread" class="user">
                            
                        </div>
                        <div class="thread-input">
                            <input id="reply" type="text" placeholder="Input your reply here...">
                        </div>
                    </div>
                    <div class="confirm-thread-creation">
                        <button onclick="hideReplyForm()">X</button>
                        <button onclick="createReply('${threadid}')">Y</button>
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
function createReply(threadid){
    let reply = document.getElementById('reply').value;
    $.ajax({
        url: "Model/createReply.php",
        async: false,
        data: {threadid:threadid, reply:reply},
        success: function(response){
            alert('Reply created successfully');
            hideReplyForm();
        }
    })
}

function favoriteButton(threadid, Fav){
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    if(Fav=="love"){
        document.getElementById('favButton').innerHTML='unlove';
        $.ajax({
            url: 'Model/createThreadFavorite.php',
            async: false,
            data:{threadid:threadid},
            success:function(e){
                getThreadDetailbyThreadID(threadid,userId)
            }
        })
    }else if(Fav=="unlove"){
        document.getElementById('favButton').innerHTML='love';
        $.ajax({
            url: 'Model/deleteThreadFavorite.php',
            async: false,
            data:{threadid:threadid},
            success:function(e){
                getThreadDetailbyThreadID(threadid,userId)
            }
        })
    }
}
function showReportForm(threadid, userthreadid){
    var userId = '<?php if(isset($_SESSION['UserID']))
                        {echo $_SESSION['UserID'];
                        }
                        else echo 'null'?>'
    document.getElementById('report-form').innerHTML=`<div style="background-color: yellow; width:100%; height:fit-content; padding:5px;" class="create-forum-header">Reporting Abuse</div>
                <div>
                    <div class="create-thread-content">
                        <div id="user-report-thread" class="user">
                            
                        </div>
                        <div class="thread-input">
                            <input id="report" type="text" placeholder="Input your report here...">
                        </div>
                    </div>
                    <div class="confirm-thread-creation">
                        <button onclick="document.getElementById('report-form').innerHTML=""">X</button>
                        <button onclick="createReport('${threadid}','${userthreadid}')">Y</button>
                    </div>
                </div>`
    
    $.ajax({
        url:'functions/getAvatarData.php',
        data:{userid:userId},
        async:false,
        success:function(e){
        let data = JSON.parse(e);
            document.getElementById('user-report-thread').innerHTML=`
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
function createReport(threadid,userthreadid){
    let report = document.getElementById('report').value;
    $.ajax({
        url: "Model/createReport.php",
        async: false,
        data: {threadid:threadid, userthreadid:userthreadid, report:report},
        success: function(response){
            console.log((response));
            alert('Report successfull')
        }
    })
}
</script>