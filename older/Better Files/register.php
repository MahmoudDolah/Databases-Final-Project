<!DOCTYPE html>
<html>
<title>Registration</title>
<?php

include "include.php";
ini_set('display_errors', '0');

if(isset($_SESSION["username"])){
    echo "You are already logged in, redirecting to your homepage. ";
    header("refresh: 3; home.php");
}
else{
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["zipcode"])){
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
                if($stmt = $mysqli->prepare("INSERT INTO member (username,password,firstname,lastname,email,zipcode) VALUES (?,?,?,?,?,?)")){
                    $stmt->bind_param("sssssi", $_POST["username"], md5($_POST["password"]), $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["zipcode"]);
                    $stmt->execute();
                    $stmt->close();
                    echo "Registration Complete! Please <a href=\"login.php\">Log In</a>.";
                }
            }
        }
    }
    else{
        echo "<h2>Please Fill Out All Fields</h2> <br />";
        echo '<form action="register.php" method="POST">';
        echo "\n";
        echo 'Username: <input type="text" name="username" required/><br /><br />';
        echo "\n";
        echo 'Password: <input type="text" name="password" required/><br /><br />';
        echo "\n";
        echo 'First Name: <input type="text" name="firstname" required/><br /><br />';
        echo "\n";
        echo 'Last Name: <input type="text" name="lastname" required/><br /><br />';
        echo "\n";
        echo 'Email: <input type="text" name="email" required/><br /><br />';
        echo "\n";
        echo 'ZipCode: <input type="number" name="zipcode" required/><br /><br />';
        echo "\n";
        echo '<input type="submit" value="Submit" /><br />';
        echo '</form>';
        echo "\n";
        echo '<br /><a href="index.php">Go back</a>';

    }
}    
$mysqli->close();
    
    
    
?>
</html>