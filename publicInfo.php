<?php

require ("connect.php");
// See the meetups occuring at some date range
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


function viewMeetups($startTime = "", $endTime = ""){
        $mysqli = connectDB();
    if ($startTime != "" && $endTime != ""){
        $stmt = $mysqli->prepare("SELECT * FROM events where start_time >= ? AND end_time <= ?");
        $stmt->bind_param("ss", $startTime, $endTime);
        $stmt->execute();
        $stmt->bind_result($id, $title, $description, $start, $end, $groupID, $location, $zipcode);

        $result = $stmt->get_result();
        return $result;
    }
    else{
        $stmt = $mysqli->prepare("SELECT * FROM events WHERE DATEDIFF(start_time, NOW()) < 4 AND DATEDIFF(start_time, NOW()) > -1");
        $stmt->execute();
        $stmt->bind_result($id, $title, $description, $start, $end, $groupID, $location, $zipcode);

        $result = $stmt->get_result();
        return $result;

    }
    closeConnectionDB();
}
?>