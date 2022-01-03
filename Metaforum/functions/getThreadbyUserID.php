<?php
    include_once ('../config.php');
    $userid = $_REQUEST['userid'];
    $conn = getConnection();
    $query = "SELECT *,b.Username,
    (SELECT CASE WHEN  TIMESTAMPDIFF(day, a.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(day, a.Created_At, now()), ' days ago')
            WHEN TIMESTAMPDIFF(hour, a.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(hour, a.Created_At, now()), ' hours ago')
            WHEN TIMESTAMPDIFF(minute, a.Created_At, now())=0 THEN 'Moments Ago'
            ELSE CONCAT(TIMESTAMPDIFF(minute, a.Created_At, now()), ' minutes ago') END AS waktu) as timediff
    FROM forum_thread a LEFT JOIN user b ON a.UserID = b.UserID
    WHERE a.UserID LIKE '$userid' AND b.Deleted_At IS NULL  ORDER BY a.Created_At DESC LIMIT 5 ";
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