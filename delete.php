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
			//UPDATE post and thread counts later
			
			session_start();
			
			//DB connection code
			require('connect.php');
			
			//check if user is logged in
			if (empty($_SESSION['username']) || empty($_SESSION['email']) || empty($_SESSION['authenticated'])){
				//if not authenticated, redirect to login
				header( 'Location: /login.php' );
			}
			
			//user has not requested to delete either a post or thread, so redirect to home 
			if (empty($_GET['type']) || empty($_GET['id'])){
				header( 'Location: /forum.php' );
			}
			
			else {
				if (empty($_GET)){
					header( 'Location: /forum.php' );  //cannot be accessed without providing type and id values
				}
				
				else {
					//must decrease thread count later
					$type = mysql_real_escape_string($_GET['type']);
					$id = mysql_real_escape_string($_GET['id']);
					$username = $_SESSION['username'];
					
					if ($type == "post"){
						$sql="SELECT * FROM post WHERE postID=".$id;
						$findrecord = makequery($sql);
						$findrecord = mysql_fetch_assoc($findrecord);
						
						$sql="SELECT * FROM member WHERE username='".$username."'";
						$finduser = makequery($sql);
						$finduser = mysql_fetch_assoc($finduser);
						
						if (($findrecord['author'] == $username) || ($finduser['user_class'] == "admin")){
								$sql="DELETE FROM post WHERE postID=".$id;
								$delrecord = makequery($sql);
								echo 'Post deleted successfully!  <a href="/thread.php?thread='.$findrecord['thread_id'].'">Go back to thread.</a>';
							}
						else 
							die("You don't have permission to delete this.  You need to be the author of this post or an administrator to do so. ".$findrecord['author'].$username);
					}
					
					else 
						if ($type == "thread"){
							$sql="SELECT * FROM thread WHERE threadID=".$id;
							$findrecord = makequery($sql);
							$findrecord = mysql_fetch_assoc($findrecord);
							
							$sql="SELECT * FROM member WHERE username='".$username."'";
							$finduser = makequery($sql);
							$finduser = mysql_fetch_assoc($finduser);
							
							if (($findrecord['author'] == $username) || ($finduser['user_class'] == "admin")){
								$sql="DELETE FROM thread WHERE threadID=".$id;
								$delrecord = makequery($sql);
								echo 'Thread deleted successfully!  <a href="/forums.php?forum='.$findrecord['forum'].'">Go back to forum.</a>';
							}
							
							else 
								die("You don't have permission to delete this.  You need to be the author of this thread or an administrator to do so.");
						
					}
					
					else
						die('Bad URL, type specified is invalid.');
				}
			}
        ?>
		</head>
        <body>
        </body>
</html>