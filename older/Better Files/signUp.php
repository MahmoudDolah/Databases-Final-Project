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
    
echo "<h2> Sign Up For A New Event </h2>";
echo '<br /><br />';

if(isset($_POST["eventID"])){
    if($stmt = $mysqli->prepare("INSERT INTO sign_up VALUES (?,?,NULL)")){
        $stmt->bind_param("is", $_POST["eventID"], $_SESSION["username"]);
        $stmt->execute();
        echo "Sign Up Complete! Reloading the page...";
        header("refresh: 3; signUp.php");
    }
}    
else{
    if($stmt = $mysqli->prepare("SELECT * FROM an_event WHERE DATEDIFF(start_time,NOW()) > -1 AND event_id NOT IN (SELECT event_id FROM sign_up WHERE username = ?)")){
    
    echo "<h3> List of events that you can sign up for </h3>";
    $stmt->bind_param("s",$_SESSION["username"]);
    $stmt->execute();
    $stmt->bind_result($id, $title, $description, $start, $end, $location, $zipcode);

    echo "<table border='2'>
            <tr>
                <th>Event ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Location</th>
                <th>Zip Code</th>
            </tr>";
    while($stmt->fetch()){
        echo "<tr align = 'center'>";
        echo "<td>". $id . "</td>";
        echo "<td>". $title . "</td>";
        echo "<td>". $description . "</td>";
        echo "<td>". $start . "</td>";
        echo "<td>". $end . "</td>";
        echo "<td>". $location . "</td>";
        echo "<td>". $zipcode . "</td>";
        echo "</tr>";
    }        
    echo "</table>";
    echo '<br /><br /><br /><br />';
        
    $stmt->bind_param("s",$_SESSION["username"]);
    $stmt->execute();
    $stmt->bind_result($id, $title, $description, $start, $end, $location, $zipcode);
    
    echo '<h3> Select the event you want to sign up for from the drop-down list, and press "submit". <br /><br />';

    echo '<form action="signUp.php" method="POST">';
    echo '<select required name="eventID">';
    while($stmt->fetch()){
        echo "<option value = '$id'>Event_ID: $id, Title: $title</option>";
    }
    echo '</select><br />';
    echo '<input type="submit" value="Sign Up" /></form>';
    echo '<br /><br />';
}
    
echo '<form action="home.php">';
echo '<input type="submit" value="Return Home">';
echo '</form>';    
}
?>
</html>