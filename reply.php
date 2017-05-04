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
			
			div{
				margin-left: 20%;
				font-size: 32px;
				margin-top: 10%;		
			}
			
			input#button{
				border-color: white;
				background-color: black;
				border-style: ridge;
				border-width: 2px;
				color: white;
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
			
			//user has not requested to reply to a specific thread, so redirect to home 
			if (empty($_GET['thread'])){
				header( 'Location: /home.php' );
			}
			
			else{
				if (empty($_POST)){
					echo '<h1>Reply!</h1>
						<form name="reply" action="/reply.php?thread='.$_GET['thread'].'" method="post">
						Message: <textarea rows="4" cols="50" name="message"></textarea><br />
						<input id = "button" type="submit" value="Reply" />
						</form>';
				}
			
				else {
					$threadID = mysql_real_escape_string($_GET['thread']);
					$username = $_SESSION['username'];
				
					$sql="SELECT * FROM thread WHERE threadID='".$threadID."'";
					$originalpost = makequery($sql);
					
					$sql="SELECT * FROM stats WHERE id=1";
					$stats = makequery($sql);
					$stats = mysql_fetch_assoc(makequery($sql));
					
					$total_posts = $stats['total_posts'];
					//$total_threads = $stats['total_threads'];
				
					$thread = mysql_fetch_assoc($originalpost);
					$reply_count = $thread['post_count'];
					$postnum = $reply_count + 1;
					$postID = $total_posts + 1;
					
					$message= mysql_real_escape_string($_POST['message']);
				
					$sql='INSERT INTO post (message, thread_id, author, post_number, postID) VALUES ("'.$message.'", '.$threadID.', "'.$username.'", '.$postnum.', '.$postID.')';
					$makepost = makequery($sql);
					
					$sql='UPDATE stats SET total_posts='.$postID.' WHERE id=1';
					$updatestats = makequery($sql);
					
					$sql='UPDATE member SET posts=posts + 1 WHERE username="'.$username.'"';
					$updatestats = makequery($sql);
					
					$sql='UPDATE thread SET post_count='.($reply_count + 1).' WHERE threadID='.$threadID;
					$updatethread = makequery($sql);
				
					echo '<div>Success!<br /><a href="/thread.php?thread='.$threadID.'">Go back to thread.</a></div>';
				}
			}
        ?>
	</head>
	<body>
    </body>
</html>