<!DOCTYPE html>
<html>
<head><title>Home</title></head>
    
<?php

include("include.php");
    
if(!isset($_SESSION["username"])){
    echo "You are not logged in. <br />\n";
    echo "Returning to welcome page...";
    header("refresh: 5; index.php");
}
else{
    $username = htmlspecialchars($_SESSION["username"]);
    echo "<h1>Welcome to FindFolks, $username </h1><br />";
    echo "<h2>What would you like to do?</h2> <br /><br />";
    echo '<form action="viewEvent.php">';
    echo '<input type="submit" value="View My Upcoming Events" /></form><br />';
    echo '<form action="signUp.php">';
    echo '<input type="submit" value="Sign Up For A New Event" /></form><br />';
    echo '<form action="searchEvent.php">';
    echo '<input type="submit" value="Search For Events Of My Interests" /></form><br />';
    echo '<form action="createEvent.php">';
    echo '<input type="submit" value="Create A New Event" /></form><br />';
    echo '<form action="rateEvent.php">';
    echo '<input type="submit" value="Rate A Past Event" /></form><br />';
    echo '<form action="seeRatings.php">';
    echo '<input type="submit" value="See Average Ratings of Past Events" /></form><br />';
    echo '<form action="friendEvent.php">';
    echo '<input type="submit" value="See Friends\' Events" /></form><br />';
    echo '<form action="joinGroup.php">';
    echo '<input type="submit" value="Join A Group" /></form><br />';
    echo '<form action="logout.php">';
    echo '<input type="submit" value="Log Out" /></form><br />';
    echo '<form action="deleteAccount.php" <br /><br /><br /><br />';
    echo '<input type="submit" value="Delete Account" /></form><br />';
    
}    
?>
</html>