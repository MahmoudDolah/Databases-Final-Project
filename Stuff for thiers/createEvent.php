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

echo "<h2> Create A New Event </h2>";
echo "<br /><br />";
    
if(!isset($_POST["groupID"])){
    echo "<h3> Select the ID of the group that you are representing </h3>";
    if($stmt = $mysqli->prepare("SELECT group_id FROM belongs_to WHERE username = ? AND authorized = 1")){
        $stmt->bind_param("s",$_SESSION["username"]);
        $stmt->execute();
        $stmt->bind_result($groupID);
        
        echo '<form action="createEvent.php" method="POST">';
        echo '<select required name="groupID">';
        while($stmt->fetch()){
            echo "<option value = '$groupID'>Group ID: $groupID</option>";
        }
        echo '</select><br /><br />';
    }
    
    echo 'Title: <input type="text" name="title" required/><br />';
    echo "\n";
    echo 'Description: <input type="text" name="description" required/><br />';
    echo "\n";
    echo 'Start Time: <input type="datetime-local" name="start_time" required/><br />';
    echo "\n";
    echo 'End Time: <input type="datetime-local" name="end_time" required/><br />';
    echo "\n";
    if($stmt = $mysqli->prepare("SELECT location_name, zipcode FROM location")){
        $stmt->execute();
        $stmt->bind_result($name, $zip);
        
        echo '<label for="Location">Location: </label>';
        echo '<select required name="location_name">';
        while($stmt->fetch()){
            echo "<option value = '$name'>$name</option>";
        }
        echo '</select><br />';
        $stmt->execute();
        $stmt->bind_result($name,$zip);
        echo '<label for="Zip">Zip Code: </label>';
        echo '<select required name="zipcode">';
        while($stmt->fetch()){
            echo "<option value = '$zip'>$zip</option>";
        }
        echo '</select><br />';
        
    }
    /*
    echo 'Location Name: <input type="text" name="location_name" required/><br />';
    echo "\n";
    echo 'ZipCode: <input type="number" name="zipcode" required/><br />';
    echo "\n";
    */
    echo '<input type="submit" value="Submit" />';
    echo '</form>';
}
else{
    if($stmt = $mysqli->prepare("INSERT INTO an_event VALUES (0,?,?,?,?,?,?)")){
        $start = date('Y-m-d H:i:s', strtotime($_POST["start_time"]));
        
        $end = date('Y-m-d H:i:s', strtotime($_POST["end_time"]));
        
        $stmt->bind_param("sssssi",$_POST["title"],$_POST["description"],$start,$end,$_POST["location_name"],$_POST["zipcode"]);
        if($stmt->execute()){
            echo '<br /><br />';
            if($stmt = $mysqli->prepare("INSERT INTO organize VALUES ((SELECT event_id FROM an_event WHERE title = ? AND description = ? AND start_time = ? AND end_time = ? AND location_name = ? AND zipcode = ?),?)")){
                $stmt->bind_param("sssssii", $_POST["title"], $_POST["description"], $start, $end, $_POST["location_name"], $_POST["zipcode"], $_POST["groupID"]);
                $stmt->execute();
                echo "<h3> The event has been successfully created! Returning to home...";
                header("refresh: 5; home.php");
            }
        }
        else{
            echo "Oops, looks like your location and zipcode input don't match. Please check and select the correct location and zipcode. Reloading...";
            header("refresh: 5; createEvent.php");
        }
    }
}


echo '<br /><br />';
echo '<form action="home.php">';
echo '<input type="submit" value="Return Home">';
echo '</form>'; 
    
    
?>
</html>