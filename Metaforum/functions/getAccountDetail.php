<?php
include_once('../config.php');
$conn = getConnection();
$userid = $_REQUEST['userid'];
$query="SELECT (SELECT CASE WHEN u.Email_Visibility=0 THEN u.Email ELSE 'User has hidden the email.' END) AS Email,u.Username,COUNT(*) AS jumlah_thread, fc.CategoryName AS CategoryName,fg.GroupName,
u.Description,u.Display_Picture,(SELECT CASE WHEN u.isLogin=1 THEN 'Online' ELSE 'Offline' END) AS isLogin, (SELECT COUNT(*) FROM forum_thread x WHERE x.UserID LIKE '$userid') as thread_count,
(SELECT CASE WHEN u.Status=0 THEN 'Active' WHEN  u.Status=1 THEN 'Pardoned' WHEN u.Status=2 THEN 'Silenced' WHEN u.Status=3 THEN 'Banned' END) as Status, 
(SELECT CASE WHEN u.Role=0 THEN 'Site Admin' WHEN  u.Role=1 THEN 'Moderator' WHEN u.Role=2 THEN 'User' END) as Role, (SELECT COUNT(*) FROM thread_favorite tf WHERE tf.UserID LIKE '$userid') as fav_count,
(SELECT CASE WHEN u.isLogin = 1 THEN 'Online' ELSE 'Offline' END) as Islogin
FROM forum_thread ft
JOIN user u ON u.UserID = ft.UserID 
JOIN forum_category fc ON ft.CategoryID=fc.CategoryID 
JOIN forum_group fg ON fg.GroupID = fc.GroupID
WHERE ft.UserID LIKE '$userid' GROUP BY ft.CategoryID AND u.Deleted_At IS NULL ORDER BY jumlah_thread DESC LIMIT 1;";
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