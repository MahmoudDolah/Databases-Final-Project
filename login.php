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
			
			h1, h3, form, span#new{
				margin-left: 20%;
			}
			
			a{
				color: white;
			}
			
			div#loginSuccess, div#badLogin, div#badLogin2{
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
			
			h3{
				color: black;
				text-shadow: -1px -1px white, 1px 1px #333;
				text-shadow: 1px 1px white, -1px -1px #444;
				
			}
		</style>			
		<?php
            require('connect.php');
        
            // secure with UUID cookie
            // sanitize data with function
            // make connectDB module
        
            if (!empty($_SESSION['username']) && !empty($_SESSION['email']) && !empty($_SESSION['authenticated'])){
                //if authenticated already, send to home
                header( 'Location: /home.php' );
            }
        
            else{
                if (empty($_POST['username']) && empty($_POST['password']))
                    echo '<h1>Welcome! To the Everything Forum!</h1>
                          <h3>Please login here:</h3>
                          <div id = "login">
                          <form name = "login" action = "/login.php" method = "post">
                          Username: <input type = "text" name = "username" placeholder = "username" value ="'.$_POST['username'].'"style = "border-color: red;"/>
                          <br />
                          Password: <input type = "password" name = "password" placeholder = "password" value ="'.$_POST['password'].'"style = "border-color: red;"/>
                          <br />
                          <input id = "button" type = "submit" value = "Login" />
                          </form>
                          </div>
                          <br />
                          <span id ="new" >New? </span><a href = "/register.php">Register now!</a>
                          <br />';
                            
                else if (empty($_POST['username']))
                    echo '<h1>Welcome! To the Everything Forum!</h1>
                          <h3>Please login here:</h3>
                          <div id = "login">
                          <form name = "login" action = "/login.php" method = "post">
                          Username: <input type = "text" name = "username" placeholder = "username" style = "border-color: red;"/>
                          <br />
                          Password: <input type = "password" name = "password" value ="'.$_POST['password'].'"/>
                          <br />
                          <input id = "button" type = "submit" value = "Login" />
                          </form>
                          </div>
                          <br />
                          <span id ="new" >New? </span><a href = "/register.php">Register now!</a>
                          <br />';
                
                else if (empty($_POST['password']))
                    echo '<h1>Welcome! To the Everything Forum!</h1>
                          <h3>Please login here:</h3>
                          <div id = "login">
                          <form name = "login" action = "/login.php" method = "post">
                          Username: <input type = "text" name = "username" value ="'.$_POST['username'].'"/>
                          <br />
                          Password: <input type = "password" name = "password" placeholder = "password" style = "border-color: red;"/>
                          <br />
                          <input id = "button" type = "submit" value = "Login" />
                          </form>
                          </div>
                          <br />
                          <span id ="new" >New? </span><a href = "/register.php">Register now!</a>
                          <br />';
        
            else{
                if (!(strlen($_POST['username']) > 16 || strlen($_POST['password']) <= 1)){
                    $username = mysql_real_escape_string($_POST['username']);
                    $password = mysql_real_escape_string($_POST['password']);
                    $password = md5($password);
                }
                else{
                    die('<body><div id = "badLogin2">Username must be less than 16 characters, password must be at least two characters long.  Please try again.</div></body>');
                }
        
                $sql="SELECT email FROM member WHERE username='".$username."' AND password='".$password."'";
                $result = makequery($sql);
                
                if(mysql_num_rows($result) == 1){
                    $row = mysql_fetch_array($result);  
                    $email = $row['email']; 
                    
                    session_start();
                    $_SESSION['username'] = $username;  
                    $_SESSION['email'] = $email;  
                    $_SESSION['authenticated'] = 1;
            
                    echo '<body><div id = "loginSuccess">Login successful!  <a href = "/loading.php">Click here to proceed!</a></div></body>';	
                }
                
                else{
                    die('<body><div id = "badLogin">Bad username or password.  Please try again.</div></body>');
                }
            }
        }
        ?>
	</head>
	<body>
    </body>
</html>