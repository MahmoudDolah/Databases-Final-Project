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
			
			div{
				margin-left: 20%;
				font-size: 32px;
				margin-top: 10%;		
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
			
			// sets up template for post
			if (empty($_POST)){
				echo '<h1>New Forum!</h1>
					<form name="thread" action="/newforum.php?" method="post">
						Forum Name: <input type="text" name="title" /><br />
						Description: <textarea rows="4" cols="50" name="message"></textarea><br />
						<input id = "button" type="submit" value="Submit" />
					</form>';
				}
			
				else {
					$title= mysql_real_escape_string($_POST['title']);
					$message= mysql_real_escape_string($_POST['message']);
					
					//inserts the data into the forum table
					$sql='INSERT INTO forum (title, description, thread_count) VALUES ("'.$title.'", "'.$message.'", 0)';
					$makeforum = makequery($sql);
				
					echo '<div>Success!<br /><a href="/forums.php?">Go to newly created forum.</a></div>';
				}
        ?>
		</head>
    	<body>
   		</body>
</html>