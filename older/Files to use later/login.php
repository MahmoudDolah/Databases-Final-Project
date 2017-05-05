<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>
<link rel="stylesheet" href="css/login.css">
    <script src="js/login.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/4ccdc21474.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <?php
            require('connect.php');
        
            // secure with UUID cookie
            // sanitize data with function
            // make connectDB module

            if (!empty($_SESSION['username']) && !empty($_SESSION['authenticated'])){
                //if authenticated already, send to home
                header( 'Location: /home.php' );
            }
        
            else{
                if (empty($_POST['username']) && empty($_POST['password']))
                    echo '<div class="text-center" style="padding: 50px 0;">
                            <div class="logo">Login</div>
                            <div class="login-form-1">
                                <form id="login-form" class="text-left" role="form" method="post" action="/login.php">
                                    <div class="login-form-main-message"></div>
                                    <div class="main-login-form">
                                        <div class="login-group">
                                            <div class="form-group">
                                                <label for="username" class="sr-only">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="username" value ="'.$_POST['username'].'" style="border-color: red;"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="sr-only">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="password" value ="'.$_POST['password'].'" style="border-color: red;"/>
                                            </div>
                                        </div>
                                        <button type="submit" class="login-button" value="Login"><i class="fa fa-chevron-right"></i></button>
                                    </div>
                                    <div class="etc-login-form">
                                        <!-- <p>forgot your password? <a href="#">click here</a></p> -->
                                        <p>new user? <a href="/signup.php">create new account</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>';
                            
                else if (empty($_POST['username']))
                    echo '<div class="text-center" style="padding: 50px 0;">
                            <div class="logo">Login</div>
                            <div class="login-form-1">
                                <form id="login-form" class="text-left" role="form" method="post" action="/login.php">
                                    <div class="login-form-main-message"></div>
                                    <div class="main-login-form">
                                        <div class="login-group">
                                            <div class="form-group">
                                                <label for="username" class="sr-only">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="username" style="border-color: red;"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="sr-only">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="password" value ="'.$_POST['password'].'"/>
                                            </div>
                                        </div>
                                        <button type="submit" class="login-button" value="Login"><i class="fa fa-chevron-right"></i></button>
                                    </div>
                                    <div class="etc-login-form">
                                        <!-- <p>forgot your password? <a href="#">click here</a></p> -->
                                        <p>new user? <a href="/signup.php">create new account</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>';

                else if (empty($_POST['password']))
                    echo '<div class="text-center" style="padding: 50px 0;">
                            <div class="logo">Login</div>
                            <div class="login-form-1">
                                <form id="login-form" class="text-left" role="form" method="post" action="/login.php">
                                    <div class="login-form-main-message"></div>
                                    <div class="main-login-form">
                                        <div class="login-group">
                                            <div class="form-group">
                                                <label for="lusername" class="sr-only">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="username" value ="'.$_POST['username'].'"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="lpassword" class="sr-only">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="password" style="border-color: red;"/>
                                            </div>
                                        </div>
                                        <button type="submit" class="login-button" value="Login"><i class="fa fa-chevron-right"></i></button>
                                    </div>
                                    <div class="etc-login-form">
                                        <!-- <p>forgot your password? <a href="#">click here</a></p> -->
                                        <p>new user? <a href="/signup.php">create new account</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>';

            else{
                if (!(strlen($_POST['username']) < 5 || strlen($_POST['password']) < 5)){
                    $username = mysqli_real_escape_string(connectDB(), $_POST['username']);
                    $password = mysqli_real_escape_string(connectDB(), $_POST['password']);
                    $password = md5($password);
                }
                else{
                    $message = 'Username must be at least five characters long, password must be at least five characters long.  Please try again.';
                    echo '<script type="text/javascript">alert('.$message.');</script>';
                }
                if(isset($username) && isset($password)){
                    $sql="SELECT username FROM member WHERE username='".$username."' AND password='".$password."';";
                    $result = makequery($sql);
                    
                    if(mysqli_num_rows($result) == 1){

                        session_start();
                        $_SESSION['username'] = $username;  
                        $_SESSION['authenticated'] = 1;
                
                        $message = 'Login successful!';
                        echo '<script type="text/javascript">var x = document.getElementsByClassName("login-form-main-message").innerHTML='.$message.';</script>';
                    }
                    else{
                        $message = 'Login unsuccessful! Please try again!';
                        echo '<script type="text/javascript">var x = document.getElementsByClassName("login-form-main-message").innerHTML='.$message.';</script>';
                    }
                }
            }
        }
        ?>
<body>
</body>

</html>
