<?php 
include_once('../config.php');
$threadid = $_REQUEST['threadid'];
$conn = getConnection();
  $query = "UPDATE forum_thread SET View = (SELECT View From forum_thread WHERE ThreadID LIKE '$threadid')+1 WHERE ThreadID LIKE '$threadid'";
    if ($conn->query($query) === TRUE) {
        echo "Change successfull";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

?>