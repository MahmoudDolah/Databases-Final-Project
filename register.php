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
				text-shadow: 2px 2px 5px white;
			}
			
			h1, h3, form{
				margin-left: 20%;
			}
		
			input#button{
				border-color: white;
				background-color: black;
				border-style: ridge;
				border-width: 2px;
				color: white;
			}
			
			div#regSuccess, div#regFail, div#regFail2{
				margin-left: 20%;
				font-size: 32px;
				margin-top: 10%;		
			}
			
			a{
				color: white;
			}
		</style>			
		<?php
			session_start();
			//DB connection code
        	require('connect.php');
        
			if (empty($_POST)){
				echo '<h1>Register!</h1>
				<form name = "register" action = "/register.php" method = "post">
					Username: <input type = "text" name = "username" />
					<br />
					Password: <input type = "password" name = "password" />
					<br />
					Email: <input type = "text" name = "email" /
					><br />
					<input id = "button" type = "submit" value = "Register!" />
				</form>';
			}
        
        else{
            if (! (strlen($_POST['username']) > 16 || strlen($_POST['password']) <= 1 || strlen($_POST['email']) < 5)){
                $email = mysql_real_escape_string($_POST['email']);
                $username = mysql_real_escape_string($_POST['username']);
                $password = mysql_real_escape_string($_POST['password']);
                $password = md5($password);
            }
			
            else{
                die('<body><div id = "regFail">Username cannot be greater than 16 characters, password must be at least two characters long, and a valid email should have at least 5 characters.  Please try again.</div></body>');
            }
            
            
            $sql="SELECT * FROM stats WHERE id=1";
            $stats = makequery($sql);
            $stats = mysql_fetch_assoc($stats);
            
            $total_users = $stats['total_users'];
            
			$userVerify = "SELECT * FROM member WHERE username='".$username."';";
			$userVerify2 = makequery($userVerify);
			$userVerify2 = mysql_fetch_assoc($userVerify2);
			
			if ($username == $userVerify2['username']) die ('<div id = "regFail2">Username is already taken. Please go back and try again!</div>');
			
			else {
				$sql='INSERT INTO member (username, password, email, registration_date, user_class, rep_points, posts) VALUES ("'.$username.'", "'.$password.'", "'.$email.'", CURDATE(), "user", 0, 0)';
				$makepost = makequery($sql);
				
				$sql='UPDATE stats SET total_users=total_users +1 WHERE id=1';
				$updatestats = makequery($sql);
				
				echo '<div id = "regSuccess">Success!<a href="/index.php">Go login now!</a></div>';
			}
		}
    ?>
	</head>
    <body>
    </body>
</html>