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
					First Name: <input type = "text" name = "firstname" />
					<br />
					Last Name: <input type ="text" name = "lastname" />
					<br />
					Zipcode: <input type = "number" name = "zipcode" />
					<input id = "button" type = "submit" value = "Register!" />
				</form>';
			}
        
        else{
            if (! (strlen($_POST['username']) <= 1 ||
            	   strlen($_POST['username']) > 20 ||
            	   strlen($_POST['password']) <= 1 || 
				   strlen($_POST['password']) > 32 || 
            	   strlen($_POST['firstname']) <= 1 ||
            	   strlen($_POST['firstname']) > 20 ||
            	   strlen($_POST['lastname']) <= 1 ||
            	   strlen($_POST['lastname']) > 20)){
                $username = mysqli_real_escape_string(connectDB(), $_POST['username']);
                $password = mysqli_real_escape_string(connectDB(), $_POST['password']);
                $firstname =mysqli_real_escape_string(connectDB(), $_POST['firstname']);
                $lastname = mysqli_real_escape_string(connectDB(), $_POST['lastname']);
                $zipcode = mysqli_real_escape_string(connectDB(), $_POST['zipcode']);
            }
			
            else{
                die('<body><div id = "regFail">Username cannot be greater than 20 characters, password cannot be greater than 32 characters long. Please try again.</div></body>');
            }
            
			$userVerify = "SELECT * FROM member WHERE username='".$username."';";
			$userVerify2 = makequery($userVerify);
			$userVerify2 = mysqli_fetch_assoc($userVerify2);
			
			if ($username == $userVerify2['username']) die ('<div id = "regFail2">Username is already taken. Please go back and try again!</div>');
			
			else {
				$sql='INSERT INTO member (username, password, firstname, lastname, zipcode) VALUES ("'.$username.'", "'.$password.'", "'.$firstname.'", "'.$lastname.'", "'.$zipcode.'")';
				$makepost = makequery($sql);
				
				echo '<div id = "regSuccess">Success!<a href="/login.php">Go login now!</a></div>';
			}
		}
    ?>
	</head>
    <body>
    </body>
</html>