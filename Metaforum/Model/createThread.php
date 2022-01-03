<?php
include('../config.php');
session_start();
    $categoryid = $_REQUEST['categoryid'];
    $title = $_REQUEST['title'];
    $desc = $_REQUEST['desc'];
    $conn = getConnection();
    $threadid=uniqid();
    $userid = $_SESSION['UserID'];
    $query = "INSERT INTO forum_thread (ThreadID, CategoryID, UserID, Title, Description, Status, View, Created_At) 
    VALUES ('$threadid', $categoryid, '$userid', '$title', '$desc', 0, 0, now())";
        if ($conn->query($query) === TRUE) {
            echo "Record inserted successfully<br>";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
?>