<!DOCTYPE HTML>
<!--Mahindra Persaud-->
<html>
	<head>
		<title>  </title>
		<script type= "text/javascript">
        </script>
		<style type = "text/css">
			body{
				background: url("Index Pictures/background.jpg");
				background-size: cover;
				color: white;
				font-family: papyrus;
				text-shadow: 2px 2px 5px white;
			}
			
			h1, form{
				margin-left: 20%;
			}

			a{
				color: white;
			}
			
			input#button{
				border-color: white;
				background-color: black;
				border-style: ridge;
				border-width: 2px;
				color: white;
			}

			table{
				border-style: groove;
				border-width: 5px;
				border-color: white;
				margin-left: 25%;
			}
			
			td, tr, th{
				border-style: ridge;
				border-width: 5px;
				border-color: grey;
				padding: 10px 15px 20px 25px;
			}
			
			span#stats{
				position: fixed;
			}
		</style>	
		<?php
			session_start();
	
			//DB connection code
			require('connect.php');
			
			//check if user is logged in
			if (empty($_SESSION['username']) || empty($_SESSION['firstname']) || empty($_SESSION['authenticated'])){
			//if not authenticated, redirect to login
			header( 'Location: /login.php' );
			}
			
			//if logged in, greet user
				if ($_SESSION['authenticated'] == 1){
					echo 'Hello, '.$_SESSION['firstname'].'!<br /><br />';
				}
			echo '<table><tr><th>Events</th><th>Description</th><th>Start Time</th><th>End Time</tr></tr>';
			
			$sql="SELECT * FROM events WHERE events.event_id IN (SELECT event_id FROM attend WHERE attend.username ='".$_SESSION['username']."'";
			$result = makequery($sql);
			
				
			while ($events = mysqli_fetch_assoc($result)){ 
				$title = $events['title'];
				$description = $events['description'];
				$startTime = $events['start_time'];
				$endTime = $events['end_time'];
				echo '<tr>
						<td>'.$title.'</td>
						<td>'.$description.'</td>
						<td>'.$startTime.'</td>
						<td>'.$endTime.'</td>
					</tr>';
			}			
			echo '</table>';

			echo '<br /><a href="/logout.php?">Log out</a>';
	?>
</head>
<body>
</body>
</html>