<!DOCTYPE html>
<html>
<title>Login</title>
<?php
    
include "include.php";    
    
if(!isset($_SESSION["username"])){
    echo "You are not logged in. <br />\n";
    echo "Returning to welcome page...";
    header("refresh: 5; index.php");
}

if(!isset($_POST["groupID"])){
    if($stmt = $mysqli->prepare("SELECT group_id, group_name FROM a_group WHERE group_id NOT IN (SELECT group_id FROM belongs_to WHERE username=?)")){
        $stmt->bind_param("s",$_SESSION["username"]);
        $stmt->execute();
        $stmt->bind_result($GID, $GN);
        
        echo '<form action="joinGroup.php" method="POST">';
        echo '<label for="group">Group: </label>';
        echo '<select required name="groupID">';
        while($stmt->fetch()){
            echo "<option value = '$GID'>ID: $GID, Name: $GN</option>";
        }
        echo '</select><br /><br />';
        echo '<input type="submit" value="Join Group" /></form>';
        echo '<br /><br /><br />';
        echo '<form action="home.php">';
        echo '<input type="submit" value="Return Home">';
        echo '</form>'; 
    }
}
else{
    if($stmt = $mysqli->prepare("INSERT INTO belongs_to VALUES (?,?,0)")){
        $stmt->bind_param("is", $_POST["groupID"], $_SESSION["username"]);
        $stmt->execute();
        
        echo "<h3> You have been successfully added to the group! Returning home...</h3>";
        header("refresh: 4; home.php");
    }
}
    


?>
</html>