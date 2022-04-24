<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>

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
    .avail_button {
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
    /* position: fixed; */
    bottom: 0;
    right: 15px;
    border: 3px solid #f1f1f1;
    /* z-index: 9; */
    }
</style>
<body>

    <button class="week_button" onclick="openFormWeek()">Select Week & Times</button>
    <!-- <button class="avail_button" onclick="openFormAvail()">Select Unavailable Times</button> -->

    <?php
    $aid= $_REQUEST['userId'];


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
            while(strtotime($startTime) <= strtotime($endTime)){
                $start = $startTime;
                $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
                $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
                $i++;
                if(strtotime($startTime) <= strtotime($endTime)){
                    $time[$i]['start'] = $start;
                    $time[$i]['end'] = $end;
                } 
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

            <br>
            <button type='submit' class='btn' name= 'btnWeek' value='btnWeek'>Submit</button>
            <button type='button' class='btn cancel' onclick='closeFormWeek()'>Close</button>
        </form>";

        }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $weekStart = $_POST['week_start'];
        $weekEnd = $_POST['week_end'];
        $timeStart = $_POST['time_start'];
        $timeEnd = $_POST['time_end'];

        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());

        $query= "INSERT INTO schedule VALUES (NULL, $aid, '$weekStart', '$weekEnd', '$timeStart', '$timeEnd');";
        echo $query;
        $result = mysqli_query($conn, $query);
        // if($result){
        //     echo "Schedule perimeters successfully created.";
        // }else{
        //     echo "ERROR: Could not execute $query.";
        // }
        
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
            }
        }

    
        $query= "SELECT * FROM schedule WHERE schedule_id=$last_id;";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0){
            // print_r($result);

            while($row = mysqli_fetch_assoc($result)) {
                // print_r($row);
            }
        }



        //   echo $result;

        // if (mysqli_num_rows($result) > 0){
        //     echo"<table>";
        //     echo"<tr>
        //     <th>Monday</th>
        //     <th>Tuesday</th>
        //     <th>Wednesday</th>
        //     <th>Thursday</th>
        //     <th>Friday</th>";
        //     while($row = mysqli_fetch_assoc($result)){

        //     }
        // }

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