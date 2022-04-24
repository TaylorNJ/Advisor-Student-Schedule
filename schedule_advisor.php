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
       margin: auto;
       width: 50%;
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

    .week_button {
        background-color: #555;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        /* position: fixed; */
        bottom: 23px;
        /* right: 28px; */
        width: 200px;
    }
    .weekForm {
    display: none;
    bottom: 0;
    right: 15px;
    border: 3px solid #f1f1f1;
    }
</style>

<body>
    <div clas="header">
        <h1>Center for Academic Advising</h1>
        <p>Welcome to the Center for Academic Advising. Every student has an assigned advisor to help you plan your journey with us.
            Set up an appointment with your advisor after loging in.
        </p>
    </div>
    <?php
    $aid= $_REQUEST['userId'];
    $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());
    $query = "SELECT first_name, last_name FROM advisor WHERE advisor_id=$aid;";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        if($row = mysqli_fetch_assoc($result)){
            echo"<center>";
            echo"<h1>Create an Advising Schedule</h1>";
            echo"<h2>Welcome ", $row['first_name']," ",$row['last_name'],"</h2>";
            echo"</center>";
        }
    }


    function createTimeSlots($start_date, $end_date, $time_s, $time_e, $interval){
        $date = [];
        $startD = strtotime($start_date);
        $endD = strtotime($end_date);

        $start = new dateTime($time_s);
        $end = new dateTime($time_e);

        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');


        $i=0;
        $time=[];
        for ($currentDate=$startD; $currentDate<=$endD; $currentDate+=(86400)) {            
            $Store = date('D m/d', $currentDate);
            $date[] = $Store;
        }
        while(strtotime($startTime) <= strtotime($endTime)){
                $start = $startTime;
                $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
                $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
                $cstart = new DateTime($startTime);
                $convertstart = $cstart->format('h:i');
                $cend = new DateTime($end);
                $convertend = $cend->format('h:i');
                $i++;
                if(strtotime($startTime) <= strtotime($endTime)){
                    $time[$i]['start'] = $convertstart;
                    $time[$i]['end'] = $convertend;
                } 
            }
        $week= array();
        foreach($date as $day=>$value){
            $week[$value] = $time;
            echo"<br>";
        }
        return $week;
    }
    

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo"<center><button class='week_button'' onclick='openFormWeek()'>Click Here to Start</button>";

        echo "<form name='schedule_advisor.php' method='post' class='weekForm' id='weekForm'>
            <h2>Select Week</h2>
            <p>*Week must start from Monday and end on Friday*</p>
            <label for='week_start'>Start Date: <input type='date' name='week_start'></label>
            <br>
            <label for='week_start'>End Date: <input type='date' name='week_end'></label>

            <h2>Select Time</h2>
            <label>From: <input type='time' name='time_start'></label>
            <br>
            <label>To: <input type='time' name='time_end'></label>

            <br><br>
            <button type='submit' class='btn' name= 'btnWeek' value='btnWeek'>Submit</button>
            <button type='button' class='btn cancel' onclick='closeFormWeek()'>Close</button>
        </form></center>";

        }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $weekStart = $_POST['week_start'];
        $weekEnd = $_POST['week_end'];
        $timeStart = $_POST['time_start'];
        $timeEnd = $_POST['time_end'];
        echo"<center> <h3>This is a preview of your schedule for $weekStart - $weekEnd</h3></center>";
        echo"<center><a href=view_schedule.php?userId=$aid>Click Here to View Your Schedules</a>";
        echo"<center><a href=index.php?userId=$aid>Return to Homepage</a>";

        $query= "INSERT INTO schedule VALUES (NULL, $aid, '$weekStart', '$weekEnd', '$timeStart', '$timeEnd');";
        // echo $query;
        $result = mysqli_query($conn, $query);
        
        //grab PK of newly created schedule
        if ($result) {
            $last_id = mysqli_insert_id($conn);
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        //create slots
        $slots = createTimeSlots($weekStart, $weekEnd, $timeStart, $timeEnd, 30);
        //add slot values to db
        foreach($slots as $day=>$value){
            foreach($value as $select=>$time){
                $query= "INSERT INTO time_slots VALUES ($last_id, '$time[start]', '$time[end]', $aid, NULL, '$day');";
                $result = mysqli_query($conn, $query);
                // print_r($query);
            }
        }
        
        
        echo "<div class='schedule'>";
        echo"<table><tr>";
        $query="SELECT day FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Mon%';";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
        echo"<th>",$row['day'],"</th>"; 
        }
        $query="SELECT day FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Tue%';";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
            echo"<th>",$row['day'],"</th>"; 
            }
        $query="SELECT day FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Wed%';";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
            echo"<th>",$row['day'],"</th>"; 
            }
        $query="SELECT day FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Thu%';";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
            echo"<th>",$row['day'],"</th>"; 
            }
        $query="SELECT day FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Fri%';";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
            echo"<th>",$row['day'],"</th>"; 
            }
        echo"</tr>";


        $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Mon%';";
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

        $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Tue%';";
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

        $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Wed%';";
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

        $query="SELECT time_start, time_end, slot FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Thu%';";
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

        $query="SELECT  time_start, time_end, slot FROM time_slots WHERE schedule_id=$last_id AND day LIKE 'Fri%';";
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
    ?>
    <script>
        function openFormWeek() {
            document.getElementById("weekForm").style.display = "block";
        }
        function closeFormWeek() {
            document.getElementById("weekForm").style.display = "none";
        }
    </script>
</body>
</html>