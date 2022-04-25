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
    </style>
<body>
<div clas="header">
        <h1>Center for Academic Advising</h1>
        <p>Welcome to the Center for Academic Advising. Every student has an assigned advisor to help you plan your journey with us.
            Set up an appointment with your advisor after loging in.
        </p>
</div>
    <?php
        $advisorId = $_REQUEST["userId"];
        $password = $_REQUEST["password"];

        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());
        $query = "SELECT first_name, last_name FROM advisor WHERE advisor_id=$advisorId AND pass=SHA2('$password', 512);";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0){
        //    echo "login Successful <br>";
           setcookie("userId", $advisorId, time() + 60*60);
           while($row = mysqli_fetch_assoc($result)) {
               echo "<center><h1>Welcome ", $row['first_name']," ", $row['last_name'],"</h1>";
               echo"<br><a href='schedule_advisor.php?userId=$advisorId'>Create Schedule</a>";
               echo"<br><a href='view_schedule.php?userId=$advisorId'>View Schedule</a>";
               echo"<br><a href='logout.php'>Logout</a>";
            //    echo"<br><br>Upcoming Appointments: ";
            //    echo"</center>" ;
               
           }
           $query= "SELECT appt_day, time_from, time_to, student.first_name, student.last_name FROM appointments INNER JOIN student ON appointments.student_id = student.student_id WHERE advisor_id=$advisorId;";
               $result = mysqli_query($conn, $query);
               echo"<center><br>Your Upcoming Appointments: <br>";
               if (mysqli_num_rows($result) > 0){
                   while($row = mysqli_fetch_assoc($result)) {
                       echo"<li>", "<b>",$row['appt_day'],"</b>: ", "<b>",$row['time_from'],"</b> to <b>", $row['time_to'],"</b> with ", $row['first_name']," ", $row['last_name'],"</li>"; 
                   }
               }
               echo"</center>";
        }else{
            echo"Login failed";
            echo"<br><a href=advisor_login.html>Return to Login Page</a>";
        }

        

    ?>
</body>
</html>