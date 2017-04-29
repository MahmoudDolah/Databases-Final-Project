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
			}
			
			h3{
				color: grey;
				text-shadow: -1px -1px white, 1px 1px #333;
				text-shadow: 1px 1px white, -1px -1px #444;
				margin-top: 10%;
				margin-left: 29%;
			}
			
			img#loading{
				margin-left: 35%;	
			}
			
			img#done{
				margin-left: 29%;	
			}
			
			h3#completed{
				display: none;
				margin-left: 40%;
			}
		</style>			
    </head>
    <body>
    	<h3 id = "waiting"> Please wait as we connect you to the server. Thank you! </h3>
        <h3 id = "completed"> Loading Completed! </h3>
       <img id = "loading" src = "Loading Pictures/loading.gif" />
       <img id = "done" src = "Loading Pictures/loadingDone.jpg" style = "display: none;"/>
       <script type = "text/javascript">
	   		setTimeout("displayDone()",5000);
			
			function displayDone(){
				document.getElementById("waiting").style.display = "none";
				document.getElementById("loading").style.display = "none";
				document.getElementById("completed").style.display = "block";
				document.getElementById("done").style.display = "block";
				setTimeout("loadNextPage()", 2000);
			}
			
			function loadNextPage(){
				window.open ("/forums.php","_self")	
			}
	   </script>
    </body>
</html>