<?php
    include_once ('../config.php');
    $userid = $_REQUEST['userid'];
    $conn = getConnection();
    $query = "SELECT u.Verified, u.UserID, u.Display_Picture,u.Username, (SELECT CASE WHEN u.Role=0 THEN 'Site Admin' WHEN  u.Role=1 THEN 'Moderator' WHEN u.Role=2 THEN 'User' END) as Role,
    (SELECT CASE WHEN u.Status=0 THEN 'Active' WHEN  u.Status=1 THEN 'Pardoned' WHEN u.Status=2 THEN 'Silenced' WHEN u.Status=3 THEN 'Banned' END) as Status,
    (SELECT CASE WHEN u.isLogin = 1 THEN 'Online' ELSE 'Offline' END) as Islogin,
    (SELECT COUNT(*) FROM forum_thread x WHERE x.UserID LIKE '$userid' ) as user_posts 
    FROM user u WHERE u.UserID LIKE '$userid' AND u.Deleted_At IS NULL ";
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