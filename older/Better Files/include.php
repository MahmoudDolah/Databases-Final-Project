<?php

$mysqli = new mysqli("localhost", "root", "", "meetup");

if(mysqli_connect_errno()){
    printf("Connection Failed %s\n", mysqli_connect_error());
    exit();
}

session_start();
if(isset($SESSION["REMOTE_ADDR"]) && $SESSION["REMOTE_ADDR"] != $SERVER["REMOTE_ADDR"]){
    session_destroy();
    session_start();
}

?>