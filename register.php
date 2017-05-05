<!DOCTYPE html>
<html>
<head>
<title>Registration</title>
    <script src="js/login.js"></script>
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/95e986a209.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/navbar.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <style type="text/css">
        #content{
            background: #666666;
        }

        #container {
            position: relative;
            width: 100%;
            height: 100%;
        }
    </style>
<?php

include ("connect.php");
ini_set('display_errors', '0');

if(isset($_SESSION["username"])){
    echo '<body>
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
                                <li class="active"><a href="register.php">Sign Up</a></li>
                                <li><a href="public.php">Public Info</a></li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Navbar finished -->
            <div id="content">
            <div id="container">
                <div id="center" style="background:rgba(255,255,255,0.5);">You are already logged in! Taking you to the home page now!</div>
                </div>
            </div>
        </body>';
    header("refresh: 3; home.php");
}
else{
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["zipcode"])){
        if($stmt = $mysqli->prepare("SELECT username FROM member WHERE username = ?")){
            $stmt->bind_param("s", $_POST["username"]);
            $stmt->execute();
            $stmt->bind_result($username);
            if($stmt->fetch()){
                echo "Username taken, please choose a different username.";
                echo "Reloading page in 3 seconds...";
                header("refresh: 3; register.php");
                $stmt->close();
            }
            else{
                $stmt->close();
                if($stmt = $mysqli->prepare("INSERT INTO member (username,password,firstname,lastname, zipcode) VALUES (?,?,?,?,?)")){
                    $stmt->bind_param("ssssi", $_POST["username"], md5($_POST["password"]), $_POST["firstname"], $_POST["lastname"], $_POST["zipcode"]);
                    $stmt->execute();
                    $stmt->close();
                    echo '<body>
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
                                                <li class="active"><a href="register.php">Sign Up</a></li>
                                                <li><a href="public.php">Public Info</a></li>
                                            </ul>
                                        </div>
                                        <!--/.nav-collapse -->
                                    </div>
                                </div>
                            </div>
                            <!-- Navbar finished -->
                            <div id="content">
                            <div id="container">
                                <div id="center" style="background:rgba(255,255,255,0.5);">Registration Complete! Please <a href="login.php">Log In</a></div>
                                </div>
                            </div>
                        </body>';
                }
            }
        }
    }
    else{
        echo '
              <!-- Latest compiled and minified JavaScript -->
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
                <link href="http://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" type="text/css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
                        <div class="text-center" style="padding: 50px 0;">
                        <div class="logo">Login</div>
                        <div class="login-form-1">
                            <form id="login-form" class="text-left" role="form" method="post">
                                <div class="main-login-form">
                                    <div class="login-group">
                                        <div class="form-group">
                                            <label for="username" class="sr-only">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="sr-only">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="firstname" class="sr-only">First Name</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="firstname">
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname" class="sr-only">Last Name</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="lastname">
                                        </div>
                                        <div class="form-group">
                                            <label for="zipcode" class="sr-only">Zipcode</label>
                                            <input type="number" class="form-control" id="zipcode" name="zipcode" placeholder="zipcode">
                                        </div>
                                    </div>
                                    <button type="submit" class="login-button" value="submit"><i class="fa fa-chevron-right"></i></button>
                                </div>
                                <div class="etc-login-form">
                                    <!-- <p>forgot your password? <a href="#">click here</a></p> -->
                                    <p><a href="index.php">Go back</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
    }
}    
$mysqli->close();
?>
</head>
</html>