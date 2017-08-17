<!DOCTYPE html>
<html>
<title>Login</title>
<?php
    
include "include.php";    
ini_set('display_errors', '0'); 
    
if(isset($_SESSION["username"])){
    echo "You are already logged in, redirecting to your homepage. ";
    header("refresh: 5; home.php");
}
    
else{
    if(isset($_POST["username"]) && isset($_POST["password"])){
        if($stmt = $mysqli->prepare("SELECT * FROM member WHERE username = ? AND password = ?")){
            $stmt->bind_param("ss", $_POST["username"], md5($_POST["password"]));
            $stmt->execute();
            $stmt->bind_result($username, $password, $firstname, $lastname, $email, $zipcode);
            if($stmt->fetch()){
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                $_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];
                echo "Login Successful! \n";
                echo "Redirecting to your homepage in 3 seconds...";
                header("refresh: 3; home.php");
            }
            else{
                sleep(1);
                echo "Incorrect username or password. Please try again.";
                echo "\n";
                echo "Reloading page...";
                header("refresh: 3; login.php");
            }
            $stmt->close();
            $mysqli->close();
        }
    }
    else{
        echo "Please enter your username and password <br /><br />";
        echo '<form action="login.php" method="POST">';
        echo 'Username: <input type="text" name="username" required/><br /><br />';
        echo 'Password: <input type="password" name="password" required/><br /><br />';
        echo '<input type="submit" value="Submit" /><br /><br />';
        echo '</form>';
        echo '<br /><a href="index.php">Go back</a>';
    }
}
?>
</html>