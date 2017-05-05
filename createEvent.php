<?php
echo "<h2> Create A New Event </h2>";
if(!isset($_POST["groupID"])){
    echo "<h3> Select the ID of the group that you are representing </h3>";
    if($stmt = $mysqli->prepare("SELECT group_id FROM belongs_to WHERE username = ? AND authorized = 1")){
        $stmt->bind_param("s",$_SESSION["username"]);
        $stmt->execute();
        $stmt->bind_result($groupID);
        
        echo '<form action="home.php" method="POST">';
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
    if($stmt = $mysqli->prepare("SELECT lname, zip FROM location")){
        $stmt->execute();
        $stmt->bind_result($name, $zip);
        
        echo '<label for="location">Location: </label>';
        echo '<select required name="lname">';
        while($stmt->fetch()){
            echo "<option value = '$name'>$name</option>";
        }
        echo '</select><br />';
        $stmt->execute();
        $stmt->bind_result($name,$zip);
        echo '<label for="zip">Zip Code: </label>';
        echo '<select required name="zip">';
        while($stmt->fetch()){
            echo "<option value = '$zip'>$zip</option>";
        }
        echo '</select><br />';
        
    }
    echo '<input id="create" type="submit" value="Submit"/>';
    echo '</form>';
}
else{
    if($stmt = $mysqli->prepare("INSERT INTO events VALUES (0,?,?,?,?,?,?,?)")){
        $start = date('Y-m-d H:i:s', strtotime($_POST["start_time"]));
        
        $end = date('Y-m-d H:i:s', strtotime($_POST["end_time"]));
        
        $stmt->bind_param("ssssisi",$_POST["title"],$_POST["description"],$start,$end,$_POST["groupID"],$_POST["lname"],$_POST["zip"]);
        if($stmt->execute()){
            echo '<br /><br />';
            if($stmt = $mysqli->prepare("INSERT INTO belongs_to VALUES ((SELECT group_id FROM event WHERE title = ? AND description = ? AND start_time = ? AND end_time = ? AND lname = ? AND zip = ?),?,?)")){
                $stmt->bind_param("sssssisi", $_POST["title"], $_POST["description"], $start, $end, $_POST["lname"], $_POST["zip"], $_SESSION['username'], 1);
                $stmt->execute();
                echo "<h3> The event has been successfully created! Returning to home...";
            }
        }
        else{
            echo "Oops, looks like your location and zipcode input don't match. Please check and select the correct location and zipcode. Reloading...";
            header("refresh: 5; home.php");
        }
    }
}


echo '<br /><br />';
echo '<form action="home.php">';
echo '<input type="submit" value="Return Home">';
echo '</form>'; 
?>