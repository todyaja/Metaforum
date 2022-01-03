<?php
    function getConnection(){
        $conn = mysqli_connect('localhost','root','','metaforum');
        if(!$conn){
            echo json_encode('Connection error');
        }
        else
        return $conn;
    }
?>