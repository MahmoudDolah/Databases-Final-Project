<!DOCTYPE html>
<html>
<title>Find Folks</title>
<?php

include "include.php";
    
if($stmt = $mysqli->prepare("SELECT * FROM an_event WHERE DATEDIFF(start_time, NOW()) < 4 AND DATEDIFF(start_time, NOW()) > -1")){
    echo "<h2> Here is the list of events happening in the next 3 days </h2>";
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

if(!isset($_POST["interest"])){
    echo "<h2> If you would like to search for a particular interest of yours, select from below and hit 'Submit' </h2>";
    
    if($stmt = $mysqli->prepare("SELECT * FROM interest")){
        $stmt->execute();
        $stmt->bind_result($category, $keyword);
        
        echo '<form action="public.php" method="POST">';
        echo '<select name="interest">';
        while($stmt->fetch()){
            echo "<option value = '$category$keyword'>$category..$keyword</option>";
        }
        echo '</select>';
        echo '<br /><br />';
        echo '<input type="submit" value="Submit" />';
        echo '</form>';
    }
}
    
else{
    echo "<h2> Here are the future events that correlate to your interests</h2>";
    if($stmt = $mysqli->prepare("SELECT * FROM an_event WHERE DATEDIFF(start_time,NOW()) > -1 AND event_id IN (SELECT event_id FROM organize WHERE group_id IN (SELECT group_id FROM about WHERE CONCAT(category,keyword) LIKE ?))")){
        $stmt->bind_param("s",$_POST["interest"]);
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
        
        echo '<br />';
        
        echo '<form action="public.php" method="POST">';
        echo '<input type="submit" value="Search For Different Interest" />';
        echo '</form>';
    }
}
    
echo '<br /><br /><br />';


echo '<form action="index.php">';
echo '<input type="submit" value="Return Home" />';
echo '</form>';

?>    
</html>