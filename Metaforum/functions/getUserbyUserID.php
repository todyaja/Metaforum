<?php
    include_once ('../config.php');
    $userid = $_REQUEST['userid'];
    $conn = getConnection();
    $query = "SELECT *, (SELECT CASE WHEN TIMESTAMPDIFF(day, ADDTIME(u.lastChangedUsername,'06:00:00'), now()) <30 THEN 'disabled'
    ELSE '' END) AS display_editable, (SELECT CASE WHEN u.Email_Visibility = 0 THEN 'checked'
    ELSE '' END) AS isChecked
     FROM user u WHERE u.UserID LIKE '$userid' AND u.Deleted_At IS NULL ";
    $result = mysqli_query($conn,$query);
    if (!$result) {
        echo "Connection error";
    }else {
        echo json_encode(mysqli_fetch_assoc($result));
    }
?>