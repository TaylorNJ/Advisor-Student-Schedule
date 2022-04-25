<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .header{
        text-align: center;
    }
    table, th, td {
        border:1px solid black;
        text-align: center;

    }
    .schedule{
        margin: auto;
        padding: 20px;
    }
    .schedule input[type="radio"]{
        opacity: 0;
        position: fixed;
        width: 0;
        height: 0;
    }

    .schedule label{
    display: inline-block;
    background-color: #ddd;
    padding: 30px 30px;
    font-family: sans-serif, Arial;
    border: 1px solid #CCC;
    font-size: 20px;
    border-radius:20px;
    }
    .schedule label:hover {
        background-color: #dfd;
    }
    .schedule input[type="radio"]:focus + label {
        border: 1.5px solid #444;
        background-color: #00a9dc;
    }
    .schedule input[type="radio"]: checked + label {
        background-color:#bfb;
        border-color: #4c4;
    }
</style>
<body>
    <div class="header">
        <h1>Center for Academic Advising</h1>
    </div>

<?php

    if(isset($_GET['userId'] ) || isset($_GET['studentId'])){
        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());

        if(isset($_GET['userId'])){
            $aid= $_REQUEST['userId'];
            // echo $aid;
            $query = "SELECT first_name, last_name FROM advisor WHERE advisor_id=$aid";
            
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
                echo "<center><p><h2>Schedules for ",$row['first_name']," ", $row['last_name'], " </h2></p>";
            }

        }elseif(isset($_GET['studentId'])){
            $sid = $_REQUEST['studentId'];
            // echo $sid;
            $query = "SELECT first_name, last_name FROM student WHERE student_id=$sid";
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
                echo "<center><h2>", $row['first_name']," ", $row['last_name'];
                $query = "SELECT advisor.advisor_id, advisor.first_name, advisor.last_name FROM advisor 
                INNER JOIN advises ON advisor.advisor_id=advises.advisor_id
                WHERE advises.student_id=$sid;";
                $result = mysqli_query($conn, $query);
                if($row = mysqli_fetch_assoc($result)) {
                    $aid = $row['advisor_id'];
                    echo" your advisor is ", $row['first_name'], " ",$row['last_name'],"</h2>";
                    echo"<p>Select an available slot below from one of your advisor's schedule</p>
                    <p>Select a slot and then hit the submit button</center>";
                }
            
            }
        }
        echo "<center><a href=index.php>Return Home</a></center>";


        $OGquery="SELECT schedule_id, week_start, week_end FROM schedule WHERE advisor_id=$aid;";
        $OGresult = mysqli_query($conn, $OGquery);
        if(mysqli_num_rows($OGresult) > 0){
            while($row = mysqli_fetch_assoc($OGresult)) {
            $trySave = $row['schedule_id'];


            ///////////should create table per schedule_id associated w/ account
    echo"<form action='view_schedule.php?' method='post'>";
            echo "<div class='schedule'>";
            echo"<table><tr>";
            echo "<h3>schedule_id: ",$trySave, " start: ", $row['week_start']," end: ", $row['week_end'],"</h3>";
            $query="SELECT day FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Mon%';";
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
            echo"<th>",$row['day'],"</th>"; 
            }
            $query="SELECT day FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Tue%';";
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
                echo"<th>",$row['day'],"</th>"; 
                }
            $query="SELECT day FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Wed%';";
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
                echo"<th>",$row['day'],"</th>"; 
                }
            $query="SELECT day FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Thu%';";
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
                echo"<th>",$row['day'],"</th>"; 
                }
            $query="SELECT day FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Fri%';";
            $result = mysqli_query($conn, $query);
            if($row = mysqli_fetch_assoc($result)) {
                echo"<th>",$row['day'],"</th>"; 
                }
            echo"</tr>";

            ///radio slot selections
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Mon%';";
            $result = mysqli_query($conn, $query);
            echo"<tr><td>";
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    echo "<input type='radio' name='slot' value='",$row['slot'],"' id='",$row['slot'],"'>
                    <label for ='",$row['slot'],"'>",
                    $row['time_start']," - ", $row['time_end'],
                    "</label>";
                }
            }
            echo"</td>";
    
            $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Tue%';";
            $result = mysqli_query($conn, $query);
            echo "<td>";
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    echo "<input type='radio' name='slot' value='",$row['slot'],"' id='",$row['slot'],"'>
                    <label for ='",$row['slot'],"'>",
                    $row['time_start']," - ", $row['time_end'],
                    "</label>";
                }echo"</td>";
            }
    
            $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Wed%';";
            $result = mysqli_query($conn, $query);
            echo "<td>";
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    echo "<input type='radio' name='slot' value='",$row['slot'],"' id='",$row['slot'],"'>
                    <label for ='",$row['slot'],"'>",
                    $row['time_start']," - ", $row['time_end'],
                    "</label>";
                }echo"</td>";
            }
    
            $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Thu%';";
            $result = mysqli_query($conn, $query);
            echo "<td>";
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    echo "<input type='radio' name='slot' value='",$row['slot'],"' id='",$row['slot'],"'>
                    <label for ='",$row['slot'],"'>",
                    $row['time_start']," - ", $row['time_end'],
                    "</label>";
                }echo"</td>";
            }
    
            $query="SELECT  time_start, time_end, slot FROM time_slots WHERE schedule_id=$trySave AND day LIKE 'Fri%';";
            $result = mysqli_query($conn, $query);
            echo "<td>";
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    echo "<input type='radio' name='slot' value='",$row['slot'],"' id='",$row['slot'],"'>
                    <label for ='",$row['slot'],"'>",
                    $row['time_start']," - ", $row['time_end'],
                    "</label>";
                }echo"</td>";
            }
            echo"</tr></table>";
            echo "</div>";
            $i=0;
            echo" <button type='submit' name='submit' value='submit'>Submit</button>";   
              
    echo"</form>";
    $i++;    
                
            }
        }
        }
                
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<center><br><a href=index.php>Return to Homepage</a><br></center>";
        if( isset($_COOKIE["studentId"]) ){
            $sid= $_COOKIE['studentId'];
            $slotid = $_POST['slot'];

            $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());
            $query ="SELECT schedule_id, time_start, time_end, day, advisor.advisor_id, advisor.first_name, advisor.last_name FROM time_slots INNER JOIN advisor ON time_slots.advisor_id=advisor.advisor_id WHERE slot=$slotid;";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0){
                echo"<br>You've successfully made an appointment with your advisor ";
                while($row = mysqli_fetch_assoc($result)){
                    $advisorId= $row['advisor_id'];
                    $scheduleId = $row['schedule_id'];
                    echo $row['first_name'], " ", $row['last_name'],
                    "<br>Below are your details.
                    <p>Date: ", $apptday = $row['day'], "
                    <p>From: ", $timeF=$row['time_start'], "
                    <p>To: ", $timeT=$row['time_end'];
                }
            }

        $query ="INSERT INTO appointments VALUES (NULL, $advisorId, $sid, $scheduleId, '$apptday', '$timeF', '$timeT');";
        $result = mysqli_query($conn, $query);
        if($result){
            echo "appt successfully created so will be dropped.";
            $query = "DELETE FROM time_slots WHERE slot=$slotid;";
            $result = mysqli_query($conn, $query);
            if($result){
                echo"successfully dropped time_slot";
            }
                else{
                    echo"error dropping time_slot";
                }
        }else{
            echo "ERROR: Could not execute $query.";
        }
        }
    }




?>
    
</body>
</html>