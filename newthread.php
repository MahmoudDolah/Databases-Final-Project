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
			if (empty($_SESSION['username']) || empty($_SESSION['email']) || empty($_SESSION['authenticated']))
			{
			//if not authenticated, redirect to login
			header( 'Location: /login.php' );
			}
			
			//user has not requested to reply to a specific thread, so redirect to home
			if (empty($_GET['forum'])) {
				header( 'Location: /home.php' );
			}
			
			else {
				if (empty($_POST)){
					echo '<h1>New Thread!</h1>
					<form name="thread" action="/newthread.php?forum='.$_GET['forum'].'" method="post">
					Title/Subject: <input type="text" name="title" /><br />
					Message: <textarea rows="4" cols="50" name="message"></textarea><br />
					<input type="submit" value="Submit" />
					</form>';
				}
			
				else {
					$forum = mysql_real_escape_string($_GET['forum']);
					$username = $_SESSION['username'];
				
					$sql="SELECT * FROM forum WHERE title='".$forum."'";
					$forumstats = makequery($sql);
					
					$sql="SELECT * FROM stats WHERE id=1";
					$stats = makequery($sql);
					$stats = mysql_fetch_assoc($stats);
					
					$total_threads = $stats['total_threads'];
				
					$forumstats = mysql_fetch_assoc($forumstats);
					$thread_count = $forumstats['thread_count'];
					$threadID = $total_threads + 1;
					
					$title= mysql_real_escape_string($_POST['title']);
					$message= mysql_real_escape_string($_POST['message']);
				
					$sql='INSERT INTO thread (subject, content, post_count, threadID, forum, author) VALUES ("'.$title.'", "'.$message.'", 0, '.$threadID.', "'.$forum.'", "'.$username.'")';
					$makethread = makequery($sql);
					
					$sql='UPDATE stats SET total_threads='.$threadID.' WHERE id=1';
					$updatestats = makequery($sql);
					
					$sql='UPDATE forum SET thread_count='.($thread_count + 1).' WHERE title="'.$forum.'"';
					$updateforum = makequery($sql);
				
					echo 'Success!<br><a href="/thread.php?thread='.$threadID.'">Go to newly created thread.</a>';
				}
			}
        ?>
		</head>
    	<body>
   		</body>
</html>