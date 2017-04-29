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
				margin-left: 20%;
			}
			
			a{
				color: white;
			}
			
			div{
				margin-left: 20%;
				font-size: 32px;
				margin-top: 10%;		
			}
			
			h1{
				color: black;
				text-shadow: -1px -1px white, 1px 1px #333;
				text-shadow: 1px 1px white, -1px -1px #444;
				
			}
		</style>			
		<?php
			session_start();
			
			//DB connection code
			require('connect.php');
			
			//check if user is logged in
			if (empty($_SESSION['username']) || empty($_SESSION['email']) || empty($_SESSION['authenticated'])){
				//if not authenticated, redirect to login
				header( 'Location: /login.php' );
			}
			
			//user has not requested to see a specific user, so redirect to home
			if (empty($_GET['user'])) {
				header( 'Location: /home.php' );
			}
			else {
				$user_req = mysql_real_escape_string($_GET['user']);
				
				$sql='SELECT * FROM member WHERE username="'.$user_req.'"';
				$retrieved = makequery($sql);
				$retrieved = mysql_fetch_assoc($retrieved);
			
				$user = $retrieved['username'];
				$class = $retrieved['user_class'];
				$email = $retrieved['email'];
				$regdate = $retrieved['registration_date'];
				$posts = $retrieved['posts'];
				
				echo '<h1>'.$user.'</h1>';
				echo '<span>Class: '.$class.'</span><br />';
				echo '<span>E-mail: '.$email.'</span><br />';
				echo '<span>Registration Date: '.$regdate.'</span><br />';
				echo '<span>Posts made: '.$posts.'</span><br />';
				
				echo '<br /><a href="/forums.php?">Go back home</a>';
			}
        ?>
		</head>
		<body>
    	</body>
</html>