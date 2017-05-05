<!DOCTYPE html>
<html>
<head>
    <title>CS3083 FindFolks</title>
</head>

<?php

include ("include.php");
    
if(!isset($_SESSION["username"])){
    echo "<h1>Welcome to FindFolks!</h1>";
    echo "<h2>Please choose an option below</h2>";
    echo "\n";
    echo "\n";
    echo '<form action="login.php">';
    echo '<input type="submit" value="Log In" /></form><br />';
    echo '<form action="register.php">';
    echo '<input type="submit" value="Create Account" /></form><br />';
    echo '<form action="public.php">';
    echo '<input type="submit" value="View Public Info" /></form><br />';
}

else{
    $username = htmlspecialchars($_SESSION["username"]);
    echo "Welcome, $username. You are logged in. <br />\n";
    echo "<br /><br />";
    echo "Redirecting to your homepage...";
    header("refresh: 3; home.php");
}
    
?>

</html>