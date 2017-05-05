<!DOCTYPE html>
<html>
<title>Find Folks</title>
<?php

include "include.php";

if(!isset($_SESSION["username"])){
    echo "You are not logged in. <br />\n";
    echo "Returning to welcome page...";
    header("refresh: 5; index.php");
}
    
echo "<h2> Rate An Event That You Went To </h2>";
echo "<br /><br />";
    
if(!isset($_POST["rating"]) || !isset($_POST["eventID"])){
    echo "<h3> Select the event that you'd like to rate </h3>";
    if($stmt = $mysqli->prepare("SELECT event_id, title FROM an_event WHERE DATEDIFF(start_time,NOW()) < 0 AND event_id IN (SELECT event_id FROM sign_up WHERE username = ?)")){
        $stmt->bind_param("s",$_SESSION["username"]);
        $stmt->execute();
        $stmt->bind_result($id, $title);
        
        echo '<form action="rateEvent.php" method="POST">';
        echo '<select required name="eventID">';
        while($stmt->fetch()){
            echo "<option value = '$id'>Event ID: $id, Title: $title</option>";
        }
        echo '</select><br /><br />';
        
        echo 'Rating: <input type="number" name="rating" min="1" max="5" required/><br />';
        echo '<br /><br />';
        echo '<input type="submit" value="Submit Rating" />';
        echo '</form>';
    }
}
else{
    if($stmt = $mysqli->prepare("UPDATE sign_up SET rating = ? WHERE event_id = ? AND username = ?")){
        $stmt->bind_param("iis",$_POST["rating"],$_POST["eventID"], $_SESSION["username"]);
        $stmt->execute();
        echo "<h3> Your rating has been successfully submitted. Returning to home...</h3>";
        header("refresh: 5; home.php");
    }
        
}
echo '<br /><br /><br />';


echo '<form action="home.php">';
echo '<input type="submit" value="Return Home">';
echo '</form>';
?>
</html>