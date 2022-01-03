<?php
    include_once ('../config.php');
    $conn = getConnection();
    $query = "SELECT * FROM forum_group";
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