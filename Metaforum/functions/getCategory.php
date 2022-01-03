<?php
    include_once ('../config.php');
    $categoryid = $_REQUEST['categoryid'];
    $conn = getConnection();
    $query = "SELECT * FROM forum_category WHERE CategoryID = $categoryid";
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