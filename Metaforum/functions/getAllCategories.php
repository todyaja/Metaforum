<?php
session_start();
    include_once ('../config.php');
    $groupid = $_REQUEST['groupid'];
    $userid = "";
    if($_REQUEST['userid']!=null){
        $userid = $_REQUEST['userid'];  
    }
    $conn = getConnection();
    $query = "SELECT * FROM forum_category fc WHERE fc.GroupID = $groupid 
    AND NOT EXISTS(SELECT * from user u JOIN forum_thread ft on ft.ThreadID = u.banned_ThreadID where u.UserID LIKE '$userid' AND ft.CategoryID = fc.CategoryID AND u.Status = 3)";
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