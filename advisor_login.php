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
           echo "login Successful <br>";
           setcookie("userId", $advisorId);
           while($row = mysqli_fetch_assoc($result)) {
               echo "Welcome ", $row['first_name'];
               echo"<br><a href='schedule_advisor.php?userId=$advisorId'>View/Edit Current Schedule</a>";
               echo"<br>Upcoming Appointments: ";
           }
        //    setcookie("firstname", $username, time() + 60*5);
        }else{
            echo"Login failed";
        }

        

    ?>
</body>
</html>