<?php
    include_once ('../config.php');
    $categoryid = $_REQUEST['categoryid'];
    $conn = getConnection();
    $query = "SELECT *, (SELECT COUNT(*) FROM thread_reply tr WHERE tr.ThreadID = a.ThreadID) as Reply,
    (SELECT CASE WHEN  TIMESTAMPDIFF(day, a.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(day, a.Created_At, now()), ' days ago')
            WHEN TIMESTAMPDIFF(hour, a.Created_At, now())!=0 THEN CONCAT(TIMESTAMPDIFF(hour, a.Created_At, now()), ' hours ago')
            WHEN TIMESTAMPDIFF(minute, a.Created_At, now())=0 THEN 'Moments Ago'
            ELSE CONCAT(TIMESTAMPDIFF(minute, a.Created_At, now()), ' minutes ago') END AS waktu) as timediff,
    (SELECT CASE WHEN Reply/TIMESTAMPDIFF(minute, a.Created_At, now())>10 THEN '[HOT]' ELSE '' END) as isHot
    FROM forum_thread a LEFT JOIN user b ON a.UserID = b.UserID
    WHERE a.CategoryID = $categoryid AND b.Deleted_At IS NULL ORDER BY (a.View+(((SELECT COUNT(*) FROM thread_reply x WHERE x.ThreadID LIKE a.ThreadID)*10)/TIMESTAMPDIFF(second, a.Created_At, now()))) DESC";
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