<?php 
include_once('../config.php');
$threadid = $_REQUEST['threadid'];
$conn = getConnection();
$query = "SELECT u.Username, u.UserID, u.Display_Picture, (SELECT CASE WHEN u.Role=0 THEN 'Site Admin' WHEN  u.Role=1 THEN 'Moderator' WHEN u.Role=2 THEN 'User' END) as Role,
(SELECT CASE WHEN u.Status=0 THEN 'Active' WHEN  u.Status=1 THEN 'Pardoned' WHEN u.Status=2 THEN 'Silenced' WHEN u.Status=3 THEN 'Banned' END) as Status,
(SELECT COUNT(*) FROM forum_thread x WHERE x.UserID LIKE u.UserID ) as user_posts, tr.ReplyDescription,
(SELECT CASE WHEN  TIMESTAMPDIFF(day, tr.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(day, tr.Created_At, now()), ' days ago')
WHEN TIMESTAMPDIFF(hour, tr.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(hour, tr.Created_At, now()), ' hours ago')
WHEN TIMESTAMPDIFF(minute, tr.Created_At, now())=0 THEN 'Moments Ago'
ELSE CONCAT(TIMESTAMPDIFF(minute, tr.Created_At, now()), ' minutes ago') END AS waktu) as timediff,
(SELECT CASE WHEN u.isLogin = 1 THEN 'Online' ELSE 'Offline' END) as Islogin
FROM thread_reply tr JOIN user u ON tr.UserID = u.UserID WHERE tr.ThreadID LIKE '$threadid' AND u.Deleted_At IS NULL  ";
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