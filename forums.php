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
			if (empty($_SESSION['username']) || empty($_SESSION['email']) || empty($_SESSION['authenticated'])){
			//if not authenticated, redirect to login
			header( 'Location: /index.php' );
			}
			
			//user has not requested a specific forum, so display home
			if (empty($_GET['forum'])){
					//if logged in, greet user
					if ($_SESSION['authenticated'] == 1){
						echo 'Hello, '.$_SESSION['username'].'!<br /><br />';
					}
				echo '<table><tr><th>Forum name</th><th>Description</th><th>Posts</th></tr>';
			
				$sql="SELECT * FROM forum";
				$result = makequery($sql);
				
				$sql="SELECT * FROM stats WHERE id=1";
				$stats = makequery($sql);
				$stats = mysql_fetch_assoc($stats);
				
				echo '<span id = "stats">';
				echo '<br /><a href="/logout.php?">Log out</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/newforum.php?">Create a New Forum</a>';
				echo '<br /><br />';
				echo 'Total posts: '.$stats['total_posts'].'<br />';
				echo 'Total users: '.$stats['total_users'].'<br />';
				echo 'Total threads: '.$stats['total_threads'].'';
				echo '</span>';
				
				while ($forum = mysql_fetch_assoc($result)){ 
					$title = $forum['title'];
					$thread_count = $forum['thread_count'];
					$description = $forum['description'];
					echo '<tr>
							<td><a href="/forums.php?forum='.$title.'">'.$title.'</a></td>
							<td>'.$description.'</td>
							<td>'.$thread_count.'</td>
						</tr>';
				}
			
				echo '</table>';
				
			}
			
			else {
			//need to check if forum exists
			$username = $_SESSION['username'];
			
			//ID user
			$sql="SELECT * FROM member WHERE username='".$username."'";
			$finduser = makequery($sql);
			$finduser = mysql_fetch_assoc($finduser);
			
			$forum = mysql_real_escape_string($_GET['forum']);
			echo $forum;
			$sql="SELECT * FROM thread WHERE forum='".$forum."'";
			$result = makequery($sql);
			
			echo '<table>
					<tr>
						<th>Thread Title</th><th>Author</th><th>Replies</th>
					</tr>';
			
			while ($thread = mysql_fetch_assoc($result)){ 
				$subject = $thread['subject'];
				$author = $thread['author'];
				$link = '<a href="/profile.php?user='.$author.'">'.$author.'</a>';
				$post_count = $thread['post_count'];
				$threadID = $thread['threadID'];
				echo '<tr><td><a href="/thread.php?thread='.$threadID.'">'.$subject.'</a></td><td>'.$link.'</td><td>'.$post_count.'</td>';
				if (($author == $username) || ($finduser['user_class'] == "admin")) echo '<td><a href="/delete.php?type=thread&id='.$threadID.'">delete</a></td>';
				echo '</tr>';
			}
			
			echo '</table>';
			echo '<br /><a href="/newthread.php?forum='.$forum.'">New Thread</a>';
			echo '<br /><a href="/forums.php?">Go back home</a>';
			echo '<br /><a href="/logout.php?">Log out</a>';
		}
		?>
		</head>
        <body>
        </body>
</html>