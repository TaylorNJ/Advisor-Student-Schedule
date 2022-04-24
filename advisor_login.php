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
               echo"<br><br>Upcoming Appointments: ";
               echo"</center>" ;
           }
        }else{
            echo"Login failed";
            echo"<br><a href=advisor_login.html>Return to Login Page</a>";
        }

        

    ?>
</body>
</html>