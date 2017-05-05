<!DOCTYPE HTML>
<!--Mahindra Persaud-->
<?php 
    require ("publicInfo.php");
    if(!isset($_SESSION["username"])){
        echo "You are not logged in. <br />\n";
        echo "Returning to welcome page...";
        header("refresh: 5; index.php");
    }
?>
<html>
    <head>
        <title>Database Final</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    
        <style>
            .interest{
                color:black;
            }
        </style>
    </head>
    <body>
        <!-- See occuring meetups all -->
        <div class="well">
            <div class="row">
                <div class="col-md-6">
                    <?php 
                    // See the meetups occuring at some date range
                        if($stmt = $mysqli->prepare("SELECT * FROM events WHERE DATEDIFF(start_time, NOW()) = 0 AND event_id IN (SELECT event_id FROM attend WHERE username = ? AND rsvp = 1)")){
                            echo "<h2> Events you're going to today </h2>";
                            $stmt->bind_param("s",$_SESSION["username"]);
                            $stmt->execute();
                            $stmt->bind_result($id, $title, $description, $start, $end, $groupID, $location, $zipcode);
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc()){
                                echo "<ul class='list-group'>";
                                echo "<li class='list-group-item h3'>".$row["title"]."</li>";
                                echo "<li class='list-group-item'>".$row["description"]."</li>";
                                echo "<li class='list-group-item'>Starts at: ".$row["start_time"]."</li>";
                                echo "<li class='list-group-item'>Ends at: ".$row["end_time"]."</li>";
                                echo "<li class='list-group-item'>Zipcode: ".$row["zip"]."</li>";
                                echo "</ul>";
                            }
                        }
                            echo "<h2> Upcomming Events </h2>";
                            $result = viewMeetups();
                            // Store data in variables, attach them to html objects
                            while ($row = $result->fetch_assoc()) {
                                echo "<ul class='list-group'>";
                                echo "<li class='list-group-item h3'>".$row["title"]."</li>";
                                echo "<li class='list-group-item'>".$row["description"]."</li>";
                                echo "<li class='list-group-item'>Starts at: ".$row["start_time"]."</li>";
                                echo "<li class='list-group-item'>Ends at: ".$row["end_time"]."</li>";
                                echo "<li class='list-group-item'>Zipcode: ".$row["zip"]."</li>";
                                echo "</ul>";
                            } 
                    ?>
                </div>
            <!-- Search for specific dates -->
            <div class="col-md-6">
                    <div class="search input-group">
                    <p class="h4">Enter dates in the form of DateTimes to search for ongoing events</p>
                    <input type="text" name="start_time" class="form-control" placeholder="yyyy-mm-dd or yyyy-mm-dd hh-mm-ss" required>
                    <input type="text" name="end_time" class="form-control" placeholder="yyyy-mm-dd or yyyy-mm-dd hh-mm-ss" required>
                    <div class="input-group-btn"><input id="submit" class="btn" value="submit" type="button"></div>
                </div>
                <div id="test"></div>
            </div>

            <script type="text/javascript">
                $('#submit').click(function() {
                    $.ajax({
                        type: "POST",
                        url: "publicInfo.php",
                        data: { 
                            start_time: $('input[name="start_time"]').val(), // "2017-04-30 00:00:00",
                            end_time: $('input[name="end_time"]').val() // "2017-05-01 00:00:00"
                        },
                        success: function(data){
                                data = JSON.parse(data);
                                $('#test').empty();
                                $('#test').append($('<p class="h3">Results</p>'));
                                for(i = 0; i < data.length; i++){
                                    // create the lists
                                    var list = $("<ul class='list-group'>'");
                                    list.append("<li class='list-group-item h3'>" + data[i].title + "</li>");
                                    list.append("<li class='list-group-item'>" + data[i].description + "</li>");
                                    list.append("<li class='list-group-item'>" + data[i].start_time + "</li>");
                                    list.append("<li class='list-group-item'>" + data[i].end_time + "</li>");
                                    list.append("<li class='list-group-item'>" + data[i].zip + "</li>");
                                    list.append("</ul>");
                                    $('#test').append(list);
                                }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    })
                });
                </script>   

            <!-- Create an Event -->
            <div class="col-md-6">
                <?php
                    include ("createEvent.php");
                ?>
            </div>
            <!-- RSVP an Event -->
            <div class="col-md-6">
                <?php
                    if(!isset($_SESSION["username"])){
                        echo "You are not logged in. <br />\n";
                        echo "Returning to welcome page...";
                        header("refresh: 5; index.php");
                    }

                        echo "<h2> Sign Up For A New Event </h2>";  

                        if(isset($_POST["eventID"])){
                            if($stmt = $mysqli->prepare("INSERT INTO attend VALUES (?,?,1,0)")){
                                $stmt->bind_param("is", $_POST["eventID"], $_SESSION["username"]);
                                $stmt->execute();
                                echo "Sign Up Complete! Reloading the page...";
                                echo '<form action="home.php">';
                                echo '<input type="submit" value="Return Home">';
                                echo '</form>';  
                            }
                        }    
                        else{
                            if($stmt = $mysqli->prepare("SELECT * FROM events WHERE DATEDIFF(start_time,NOW()) > -1 AND event_id NOT IN (SELECT event_id FROM attend WHERE username = ? AND rsvp = 1)")){
                            
                            echo "<h3> List of events that you can sign up for </h3>";
                            $stmt->bind_param("s",$_SESSION["username"]);
                            $stmt->execute();
                            $stmt->bind_result($id, $title, $description, $start, $end, $groupID, $location, $zipcode);

                            echo "<table border='2'>
                                    <tr>
                                        <th>Event ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Group ID</th>
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
                                echo "<td>". $groupID ."</td>";
                                echo "<td>". $location . "</td>";
                                echo "<td>". $zipcode . "</td>";
                                echo "</tr>";
                            }        
                            echo "</table>";
                                
                            $stmt->bind_param("s",$_SESSION["username"]);
                            $stmt->execute();
                            $stmt->bind_result($id, $title, $description, $start, $end, $groupID, $location, $zipcode);
                            
                            echo '<h3> Select the event you want to sign up for from the drop-down list, and press "submit". <br /><br />';

                            echo '<form action="home.php" method="POST">';
                            echo '<select required name="eventID">';
                            while($stmt->fetch()){
                                echo "<option value = '$id'>Event_ID: $id, Title: $title</option>";
                            }
                            echo '</select><br />';
                            echo '<input type="submit" value="Sign Up" /></form>';
                            echo '<br />';
                        }
                            
                        echo '<form action="home.php">';
                        echo '<input type="submit" value="Return Home">';
                        echo '</form>';    
                        }
                ?>
            </div>
        </div>
        <hr>
        
    </body>
</html>