<?php
include('../config.php');
session_start();
    $threadid = $_REQUEST['threadid'];
    $conn = getConnection();
    $userid = $_SESSION['UserID'];
    $query = "DELETE FROM thread_favorite WHERE UserID LIKE '$userid' AND ThreadID LIKE '$threadid'";
        if ($conn->query($query) === TRUE) {
            echo "favorite deleted successfully<br>";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
?>