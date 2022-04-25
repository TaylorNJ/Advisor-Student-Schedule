<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //117, studentwa
        $studentId = $_REQUEST["studentId"];
        $password = $_REQUEST["password"];

        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());

        $query = "SELECT first_name, last_name FROM student WHERE student_id=$studentId AND pass=SHA2('$password', 512);";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0){
            // echo "login Successful <br>";
            setcookie("studentId", $studentId, time() + 60*60);
            while($row = mysqli_fetch_assoc($result)) {
                echo "<center><h1>Welcome ", $row['first_name']," ", $row['last_name'],"</h1>";
                echo"<br><a href='view_schedule.php?studentId=$studentId'>Make Appointment with Advisor</a>";
                // echo"<br><a href='appt_student.php?studentId=$studentId'>Make Appointment with Advisor</a>";
                echo"<br><a href='logout.php'>Logout</a>";
                echo"<br><br>Upcoming Appointments: <br>";
                

            }
            $query= "SELECT appt_day, time_from, time_to, advisor.first_name, advisor.last_name FROM appointments INNER JOIN advisor ON appointments.advisor_id = advisor.advisor_id WHERE student_id=$studentId;";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    echo"<li>", "<b>",$row['appt_day'],"</b>: ", "<b>",$row['time_from'],"</b> to <b>", $row['time_to'],"</b> with ", $row['first_name']," ", $row['last_name'],"</li>"; 
                }
            }
            echo"</center>" ;


        
        }else{
            echo"Login failed. Please re-enter your credentials.";
            echo"<br><a href=advisor_login.html>Return to Login Page</a>";
        }

        

    ?>
</body>
</html>