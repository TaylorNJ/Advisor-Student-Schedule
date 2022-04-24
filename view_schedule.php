<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
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
<h1>Center for Academic Advising</h1>

<?php
    if($_GET = ['userId']){
        $aid= $_REQUEST['userId'];
        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());
        $query = "SELECT first_name, last_name FROM advisor WHERE advisor_id=$aid";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
            echo "<center><p><h2>Schedules for ",$row['first_name']," ", $row['last_name'], " </h2></p>";
        }
        echo "<a href=index.php>Return Home</a></center>";

        $OGquery="SELECT schedule_id, week_start, week_end FROM schedule WHERE advisor_id=$aid;";
        $OGresult = mysqli_query($conn, $OGquery);
        if(mysqli_num_rows($OGresult) > 0){
            while($row = mysqli_fetch_assoc($OGresult)) {
            $trySave = $row['schedule_id'];


            ///////////should create table per schedule_id associated w/ account
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
                    
                
                
            }
        }
                
    }

    


    elseif($_GET = ['studentId']){
        $sid = $_REQUEST['studentId'];
        echo $sid;
        echo "<p>View your advisor's schedule.</p>";
    }
    
    
    
    
    else{
        echo"ERROR: You are not logged in<br> <a href='index.php'>Log in</a>";
    }




?>
    
</body>
</html>