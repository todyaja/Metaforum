<?php
    session_start();
    include_once ('../config.php');
    $threadid = $_REQUEST['threadid'];
    $userid = $_REQUEST['userid'];
    $userusing = $_SESSION['UserID'];
    $conn = getConnection();
    $query = "SELECT ft.Title,ft.Description, u.UserID, u.Display_Picture,u.Username, u.Email, (SELECT CASE WHEN u.Role=0 THEN 'Site Admin' WHEN  u.Role=1 THEN 'Moderator' WHEN u.Role=2 THEN 'User' END) as Role,
    (SELECT CASE WHEN  TIMESTAMPDIFF(day, ft.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(day, ft.Created_At, now()), ' days ago')
            WHEN TIMESTAMPDIFF(hour, ft.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(hour, ft.Created_At, now()), ' hours ago')
            WHEN TIMESTAMPDIFF(minute, ft.Created_At, now())=0 THEN 'Moments Ago'
            ELSE CONCAT(TIMESTAMPDIFF(minute, ft.Created_At, now()), ' minutes ago') END AS waktu) as timediff,
            (SELECT CASE WHEN u.Status=0 THEN 'Active' WHEN  u.Status=1 THEN 'Pardoned' WHEN u.Status=2 THEN 'Silenced' WHEN u.Status=3 THEN 'Banned' END) as Status,
            (SELECT COUNT(*) FROM thread_favorite tf WHERE tf.ThreadID LIKE '$threadid' ) as favorite_count,
            (SELECT COUNT(*) FROM forum_thread x WHERE x.UserID LIKE '$userid' ) as user_posts,
            (SELECT CASE WHEN (SELECT COUNT(*) FROM thread_favorite WHERE UserID LIKE '$userid' AND ThreadID LIKE '$threadid') = 1 THEN 'unlove' ELSE 'love' END) as favorite_button,
            (SELECT CASE WHEN u.isLogin = 1 THEN 'Online' ELSE 'Offline' END) as Islogin,
            (SELECT CASE WHEN (SELECT banned_ThreadID FROM user WHERE UserID LIKE '$userusing') LIKE '$threadid' THEN 'noreply' else 'reply' END) as canReply,
            (SELECT CASE WHEN (SELECT fth.CategoryID FROM user us JOIN forum_thread fth ON fth.ThreadID = us.banned_ThreadID WHERE us.UserID LIKE '$userusing') = (SELECT CategoryID from forum_thread WHERE ThreadID LIKE '$threadid') THEN 'noreply' else 'reply' END) as isSilenced
    FROM
    forum_thread ft JOIN user u ON ft.UserID = u.UserID WHERE ThreadID LIKE '$threadid' AND u.Deleted_At IS NULL ";
    $result = mysqli_query($conn,$query);
    if (!$result) {
        echo "Connection error";
    }else {
        $arr = [];
        while($item = mysqli_fetch_assoc($result)){
            $arr[] = $item;
        }
        echo json_encode($arr);
    }
?>