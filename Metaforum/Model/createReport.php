<?php
include_once ('../config.php');
session_start();
    $threadid = $_REQUEST['threadid'];
    $report = $_REQUEST['report'];
    $conn = getConnection();
    $reportid = uniqid();
    $userthreadid=$_REQUEST['userthreadid'];
    $userid = $_SESSION['UserID'];
    $query = "INSERT INTO thread_report (ThreadReportID, ThreadID, CategoryID, UserThreadID, UserReportID, CreatedAt)
    VALUES ('$reportid', '$threadid', (SELECT CategoryID From forum_thread WHERE ThreadID LIKE '$threadid'), '$userthreadid', '$userid', now())";
        if ($conn->query($query) === TRUE) {
            echo "Record inserted successfully<br>";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
?>