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
		</style>	
		<?php
			session_start();
			
			//DB connection code
			require('connect.php');
			
			//check if user is logged in
			if (empty($_SESSION['username']) || empty($_SESSION['email']) || empty($_SESSION['authenticated'])){
				//if not authenticated, redirect to login
				header( 'Location: /index.php' );
			}
			
			//user has not requested a specific thread, so redirect to home
			if (empty($_GET['thread'])){ 
				header( 'Location: /home.php' );
			}
			
			else {
				$username = $_SESSION['username'];
				
				//ID user
				$sql="SELECT * FROM member WHERE username='".$username."'";
				$finduser = makequery($sql);
				$finduser = mysql_fetch_assoc($finduser);
				
				$threadID = mysql_real_escape_string($_GET['thread']);
				
				$sql="SELECT * FROM thread WHERE threadID='".$threadID."'";
				$originalpost = makequery($sql);
				$first = mysql_fetch_assoc($originalpost);
				
				$author = $first['author'];
				$subject = $first['subject'];
				$content = $first['content'];
				$forum = $first['forum'];
				$reply_count = $first['post_count'];
				
				$sql="SELECT * FROM post WHERE thread_ID='".$threadID."' ORDER BY post_number";
				$replies = makequery($sql);
				
				echo 'Forum: '.$forum;
				echo '<br>';
				echo 'Thread Title: '.$subject.'<br>Replies: '.$reply_count.' reply(ies) <br>';
				
				if (($author == $username) || ($finduser['user_class'] == "admin"))
					echo '<a href="/delete.php?type=thread&id='.$first['threadID'].'">Delete thread</a>';
					
				echo '<table><tr><th>User</th><th>Message</th></tr>';
				echo '<tr><td>'.$author.'</td><td>'.$content.'</td></tr>';
				
				while ($reply = mysql_fetch_assoc($replies)){ 
					$user = $reply['author'];
					$link = '<a href="/profile.php?user='.$user.'">'.$user.'</a>';
					$msg = $reply['message'];
					echo '<tr><td>'.$link.'</td><td>'.$msg.'</td>';
					
					if (($user == $username) || ($finduser['user_class'] == "admin")) echo '<td><a href="/delete.php?type=post&id='.$reply['postID'].'">delete</a></td>';
					
					echo '</tr>';
				}
				echo '</table>';
				echo '<br><a href="/reply.php?thread='.$threadID.'">Make a reply</a>';
				echo '<br><a href="/forums.php?forum='.$forum.'">Go back to '.$forum.'</a>';
				echo '<br><a href="/logout.php?">Log out</a>';
			}
        ?>
		</head>
    	<body>
   		</body>
</html>