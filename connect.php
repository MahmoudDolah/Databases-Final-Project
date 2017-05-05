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

function connectDB()
	{
		$mysqli = new mysqli("localhost", "root", "", "meetup");
		if (mysqli_connect_errno())
		  {
		  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  			//you need to exit the script, if there is an error
    		exit();
		  }
		return $mysqli;
	}

function closeConnectionDB(){
	$dbConnection = connectDB();
	mysqli_close($dbConnection);
}
?>