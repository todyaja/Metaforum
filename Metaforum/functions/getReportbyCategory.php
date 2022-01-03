<?php
    include_once ('../config.php');
    $categoryid = $_REQUEST['categoryid'];
    $conn = getConnection();
    $query = "SELECT ft.Title, (SELECT Username from user WHERE user.UserID = tr.UserReportID) as reportBy, (SELECT Username from user WHERE user.UserID = tr.UserThreadID) as reported,
    (SELECT CASE WHEN  TIMESTAMPDIFF(day, tr.CreatedAt, now())!=0 THEN CONCAT(TIMESTAMPDIFF(day, tr.CreatedAt, now()), ' days ago')
            WHEN TIMESTAMPDIFF(hour, tr.CreatedAt, now())!=0 THEN CONCAT(TIMESTAMPDIFF(hour, tr.CreatedAt, now()), ' hours ago')
            WHEN TIMESTAMPDIFF(minute, tr.CreatedAt, now())=0 THEN 'Moments Ago'
            ELSE CONCAT(TIMESTAMPDIFF(minute, tr.CreatedAt, now()), ' minutes ago') END AS waktu) as timediff,
            tr.ThreadID,tr.UserThreadID 
    FROM thread_report tr JOIN forum_thread ft ON ft.ThreadID = tr.ThreadID WHERE tr.CategoryID = $categoryid";
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