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

echo "<h3> Average Rating </h3>";
echo '<br /><br />';
    
if($stmt = $mysqli->prepare("SELECT AVG(rating),COUNT(rating) FROM sign_up WHERE event_id IN (SELECT event_id FROM organize WHERE group_id IN (SELECT group_id FROM belongs_to WHERE username = ?))")){
    $stmt->bind_param("s",$_SESSION["username"]);
    $stmt->execute();
    $stmt->bind_result($avgRating,$countRating);
    $stmt->fetch();
    if($countRating > 0){
        echo "<h3> The average rating of events sponsored by the groups you belong to in the past three days is: $avgRating out of 5. There were $countRating events in the past 3 days. </h3>";
    }
    else{
        echo "<h3> There were no events sponsored by the groups you belong to in the past three days. </h3>";
    }
    echo '<br /><br /><br />';
}

echo '<form action="home.php">';
echo '<input type="submit" value="Return Home">';
echo '</form>';

    
?>
</html>