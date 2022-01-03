<?php
include_once ('../config.php');
session_start();
    $threadid = $_REQUEST['threadid'];
    $reply = $_REQUEST['reply'];
    $conn = getConnection();
    $threadreplyid=uniqid();
    $userid = $_SESSION['UserID'];
    $query = "INSERT INTO thread_reply (Thread_ReplyID, ThreadID, UserID, ReplyDescription, Created_At)
    VALUES ('$threadreplyid', '$threadid', '$userid', '$reply', now())";
        if ($conn->query($query) === TRUE) {
            echo "Record inserted successfully<br>";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
?>