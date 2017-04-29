<?php
function connectDB()
	{
		$con = mysql_connect("localhost","root","Y8NaBjfzJMWdcLpqaS9pcJdF");
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		mysql_select_db("datastore", $con);
		return $con;
	}

function makequery($sql)
{
	$con = connectDB();
	$result = mysql_query($sql,$con);
	if (!$result)
	  {
	  die('Error: ' . mysql_error());
	  }
	return $result;
}
?>