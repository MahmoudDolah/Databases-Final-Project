<?php
function connectDB()
	{
		$con = mysqli_connect("localhost","root","root", "meetup");
		if (mysqli_connect_errno())
		  {
		  	print "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		return $con;
	}
	
function closeConnectionDB(){
	mysqli_close($dbConnection);
}

// function makequery($sql)
// {
// 	
// 	$dbConnection = connectDB();
// 	// Prevents sql injection
// 	$stmt = $dbConnection->prepare($sql);
// 	// $stmt->bind_param('s', $name);
// 
// 	$stmt->execute();
// 
// 	$result = $stmt->get_result();
// 	return $result;
// 	
// 	mysqli_close($dbConnection);
// 
// }

?>