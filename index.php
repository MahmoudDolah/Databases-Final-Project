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
    </head>
    <body>
        <h1>Welcome! To the Everything Forum!</h1>
        <h3>Please login here:</h3>
        <div id = "login">
            <form name = "login" action = "/login.php" method = "post">
                Username: <input type = "text" name = "username" />
                <br />
                Password: <input type = "password" name = "password" />
                <br />
                <input id = "button" type = "submit" value = "Login" />
            </form>
        </div>
        <br />
        <span id ="new" >New? </span><a href = "/register.php">Register now!</a>
        <script type = "text/javascript">
		
		</script>
    </body>
</html>