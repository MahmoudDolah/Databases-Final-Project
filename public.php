<!DOCTYPE html>
<html>
<head>
<title>Meetup</title>
<script src="js/login.js"></script>
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/95e986a209.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/navbar.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <style type="text/css">
        #content{
            background: #666666;
        }

        #container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        #center {
            position: absolute;
            display: block;
            margin: 0 auto;
            background:rgba(255,255,255,0.5);
        }
    </style>
<?php

include ("connect.php");

echo '<div id="header">
                <!-- Fixed navbar -->
                <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <div class="small-logo-container">
                                <img class="small-logo" src="./img/meetup.png">
                            </div>
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="login.php">Login</a></li>
                                <li><a href="register.php">Sign Up</a></li>
                                <li class="active"><a href="public.php">Public Info</a></li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Navbar finished -->';
if($stmt = $mysqli->prepare("SELECT * FROM events WHERE DATEDIFF(start_time, NOW()) < 4 AND DATEDIFF(start_time, NOW()) > -1")){
    $stmt->execute();
    $stmt->bind_result($id, $title, $description, $start, $end, $groupID, $location, $zipcode);

    echo '<div id="content"
            <h2> Here is the list of events happening in the next 3 days </h2>

            <table border="2">
                <tr>
                    <th>Event ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Group ID</th>
                    <th>Location</th>
                    <th>Zip Code</th>
                </tr>';
    while($stmt->fetch()){
        echo "<tr align = 'center'>";
        echo "<td>". $id . "</td>";
        echo "<td>". $title . "</td>";
        echo "<td>". $description . "</td>";
        echo "<td>". $start . "</td>";
        echo "<td>". $end . "</td>";
        echo "<td>". $groupID. "</td>";
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
        $stmt->bind_result($interestname);
        
        echo '<form action="public.php" method="POST">';
        echo '<select name="interest">';
        while($stmt->fetch()){
            echo "<option value = '".$interestname."'>".$interestname."</option>";
        }
        echo '</select>';
        echo '<br /><br />';
        echo '<input type="submit" value="Submit" />';
        echo '</form>';
    }
}
    
else{
    echo "<h2> Here are the future events that correlate to your interests</h2>";
    if($stmt = $mysqli->prepare("SELECT * FROM events WHERE DATEDIFF(start_time,NOW()) > -1 AND event_id IN (SELECT event_id FROM events WHERE group_id IN (SELECT group_id FROM about WHERE interest_name LIKE ?))")){
        $stmt->bind_param("s",$_POST["interest"]);
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
            echo "<td>". $groupID. "</td>";
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
</head> 
</html>