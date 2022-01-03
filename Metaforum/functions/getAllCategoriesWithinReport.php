<?php
session_start();
    include_once ('../config.php');
    $groupid = $_REQUEST['groupid'];
    $conn = getConnection();
    $userid = $_SESSION['UserID'];
    $query = "SELECT * FROM forum_category fc WHERE fc.GroupID = $groupid AND EXISTS (SELECT * FROM thread_report tr WHERE tr.CategoryID = fc.CategoryID) 
    AND EXISTS(SELECT * FROM moderator_category mc WHERE mc.CategoryID = fc.CategoryID AND mc.UserID LIKE '$userid' ) ";
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