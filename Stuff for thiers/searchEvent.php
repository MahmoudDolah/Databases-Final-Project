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
    
echo "<h2> Here is the list of future events that correlates with your interests </h2>";
    
if($stmt = $mysqli->prepare("SELECT * FROM an_event WHERE event_id IN (SELECT event_id FROM organize WHERE DATEDIFF(start_time, NOW()) > -1 AND group_id IN (SELECT group_id FROM about WHERE EXISTS (SELECT category,keyword FROM interested_in WHERE username = ?)))")){
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
    echo '<br /><br /><br />';
}

else{
    echo "<h2> Oops, something went wrong. Returning home...";
    header("refresh: 5; home.php");
}
echo '<form action="home.php">';
echo '<input type="submit" value="Return Home">';
echo '</form>';    
    
?>
</html>