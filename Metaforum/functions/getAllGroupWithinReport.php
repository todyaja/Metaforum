<?php
session_start();
    include_once ('../config.php');
    $conn = getConnection();
    $userid = $_SESSION['UserID'];
    $query = "SELECT * FROM forum_group fg WHERE EXISTS (SELECT * FROM thread_report tr JOIN forum_category fc ON tr.CategoryID = fc.CategoryID WHERE fc.GroupID = fg.GroupID) 
    AND EXISTS(SELECT * FROM moderator_category mc JOIN forum_category x ON mc.CategoryID = x.CategoryID WHERE x.GroupID = fg.GroupID AND mc.UserID LIKE '$userid' ) ";
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