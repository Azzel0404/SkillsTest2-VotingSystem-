<?php 
    $server = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "voting_system";

    $conn = new mysqli($server, $user, $pass, $dbname);

    if($conn->connect_error){
        die("Connection Failed!" . $conn->connect_error); 
    } else print "Connected Successfully!";
?>