<?php
// See the meetups occuring at some date range
require("connect.php");

if (isset($_POST['start_time']) && isset($_POST['end_time'])) {
    $result = viewMeetups($_POST['start_time'], $_POST['end_time']);
    // need to convert the data into an ArrayAccess
    $arr = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $arr[$i] = array();
        $arr[$i]["title"] = $row["title"];
        $arr[$i]["description"] = $row["description"];
        $arr[$i]["start_time"] = $row["start_time"];
        $arr[$i]["end_time"] = $row["end_time"];
        $arr[$i]["zip"] = $row["zip"];
        $i = $i + 1;
    }
     echo json_encode($arr);
}

if(isset($_POST['interest_name'])){
    $result = viewGroupsByInterest($_POST['interest_name']);
    $arr = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        print_r($row);
        $arr[$i] = array();
        $arr[$i]["group_name"] = $row["group_name"];
        $arr[$i]["description"] = $row["description"];
        $i = $i + 1;
    }
     echo json_encode($arr);
}



function viewMeetups($startTime = "", $endTime = ""){
    $dbConnection = connectDB();
    if ($startTime != "" && $endTime != ""){
        $stmt = $dbConnection->prepare("SELECT title, description, start_time, end_time, zip FROM events WHERE start_time > ? AND end_time < ?");
        $stmt->bind_param("ss", $startTime, $endTime);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result;
    }
    else{
        $query = "SELECT title, description, start_time, end_time, zip FROM events";
        $stmt = $dbConnection->prepare($query);
        
        $stmt->execute();

    	$result = $stmt->get_result();
    	return $result;

    }
    closeConnectionDB();
}

function viewInterests(){
    $dbConnection = connectDB();
    
    $sql = "SELECT interest_name FROM interest";
    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    closeConnectionDB();
    return $result;
}

function viewGroupsByInterest($interestName){
    $sql = "SELECT g.group_name, g.description FROM groups g INNER JOIN interested_in ON interest_name = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("s", $interestName);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    closeConnectionDB();
    return $result;
}
?>