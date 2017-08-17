<?php 
    require('connect.php');
    
    // load list of interests
    function viewInterests(){
        $dbConnection = connectDB();
        
        $sql = "SELECT interest_name FROM interest";
        $stmt = $dbConnection->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        closeConnectionDB();
    	return $result;
    }
?>