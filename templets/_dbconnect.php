<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "bank";


    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn){
        global $conn;
        echo "error --->".mysqli_error($conn);
    }
?>