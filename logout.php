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

			a{
				color: white;
			}
			
			div{
				margin-left: 20%;
				font-size: 32px;
				margin-top: 10%;		
			}
		</style>			
		<?PHP
			session_start();
			session_destroy();
			
			echo "<div>You've been logged out. <a href=\"/index.php\">Click here to go home.</a></div>";
        
        ?>
	</head>
	<body>
    </body>
</html>