<?php
function connectDB()
	{
		$con = mysqli_connect("localhost","root","", "meetup");
		if (mysqli_connect_errno())
		  {
		  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  			//you need to exit the script, if there is an error
    		exit();
		  }
		return $con;
	}
	
function closeConnectionDB(){
	$dbConnection = connectDB();
	mysqli_close($dbConnection);
}

function makequery($sql)
{
	
	$dbConnection = connectDB();
	// Prevents sql injection
	$stmt = $dbConnection->prepare($sql);
	// $stmt->bind_param('s', $name);

	$stmt->execute();

	$result = $stmt->get_result();
	return $result;
	
	mysqli_close($dbConnection);

}

?>