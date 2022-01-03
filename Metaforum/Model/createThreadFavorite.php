<?php
include('../config.php');
session_start();
    $threadid = $_REQUEST['threadid'];
    $conn = getConnection();
    $userid = $_SESSION['UserID'];
    $query = "INSERT INTO thread_favorite (UserID, ThreadID) VALUES ('$userid', '$threadid')";
        if ($conn->query($query) === TRUE) {
            echo "favorite inserted successfully<br>";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
?>