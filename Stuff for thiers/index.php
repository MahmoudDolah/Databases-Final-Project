<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Meetups</title>
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/95e986a209.js"></script>
    <link rel="stylesheet" type="text/css" href="css/navbar.css" media="screen">
    <style rel="stylesheet" type="text/css">
        #content {
            display: block;
            position: absolute;
            background-image: url("img/totoro.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        #center {
            background:rgba(255,255,255,0.5);
            margin-top: 50%;
            margin-left: 50%;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<?php

include ("connect.php");
    
if(!isset($_SESSION["username"])){
    echo '<body>
          <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
            <div id="header">
                <!-- Fixed navbar -->
                <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <div class="small-logo-container">
                                <img class="small-logo" src="./img/meetup.png">
                            </div>
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="login.php">Login</a></li>
                                <li><a href="register.php">Sign Up</a></li>
                                <li><a href="public.php">Public Info</a></li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Navbar finished -->
            <div id="content">
            </div>
        </body>';
}

else{
    $username = htmlspecialchars($_SESSION["username"]);
    echo '<body>
          <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
            <div id="header">
                <!-- Fixed navbar -->
                <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <div class="small-logo-container">
                                <img class="small-logo" src="./img/meetup.png">
                            </div>
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="login.php">Login</a></li>
                                <li><a href="register.php">Sign Up</a></li>
                                <li><a href="public.php">Public Info</a></li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Navbar finished -->
            <div id="content">
                <div id="center">
                    You are already logged in! Taking you to the home page now!
                </div>
            </div>
        </body>';
    header("refresh: 3; home.php");
}
    
?>
</html>