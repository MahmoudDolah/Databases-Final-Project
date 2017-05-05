<!DOCTYPE html>
<html>
<title>Find Folks</title>
<?php

include ("connect.php");

if(!isset($_SESSION["username"])){
    echo "You are not logged in. <br />\n";
    echo "Returning to welcome page...";
    header("refresh: 5; index.php");
}
    
if(!isset($_POST["areYouSure"])){
    echo "<h2> Are you sure? All data related to this account will be deleted. </h3><br />";
    echo "<h2> If you're sure, please type in your username and hit 'DELETE' below.</h3><br />";
    echo '<form action="deleteAccount.php" method="POST">';
    echo '<input type="text" name="areYouSure" required /><br /><br />';
    echo '<input type="submit" value="DELETE" />';
    echo '</form>';
    
    echo "<br /><br />";
    echo '<br /><a href="home.php">Go Back</a>';

    
}
elseif($_POST["areYouSure"] != $_SESSION["username"]){
    
    echo "<h2> Are you sure? All data related to this account will be deleted. </h3><br />";
    echo "<h2> If you're sure, please type in your username and hit 'DELETE' below.</h3><br />";
    echo '<form action="deleteAccount.php" method="POST">';
    echo '<input type="text" name="areYouSure" required /><br /><br />';
    echo '<input type="submit" value="DELETE" />';
    echo '</form><br />';
    
    echo "<h2> The username does not match. Please try again, or press 'Go Back' to return home.</h2>";
    
    echo "<br /><br />";
    echo '<br /><a href="home.php">Go Back</a>';    
        
}
else{
    if($stmt = $mysqli->prepare("DELETE FROM member WHERE username = ?")){
        $stmt->bind_param("s",$_SESSION["username"]);
        $stmt->execute();
        session_destroy();
        echo "<h2> Your account has been successfully deleted, {$_SESSION["username"]} </h2><br />";
        echo "<h2> Returning to welcome page...</h2>";
        header("refresh: 5; index.php");
    }
}
?>
</html>