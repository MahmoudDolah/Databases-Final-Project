<!DOCTYPE html>
<html>
<title>Logout</title>

<?php
    
session_start();
session_destroy();
echo "You are logged out. Redirecting in 3 seconds...";
header("refresh: 3; index.php");

?>
</html>