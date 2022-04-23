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
        $studentId = $_REQUEST["userId"];
        $password = $_REQUEST["password"];

        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());

        $query = "SELECT first_name, last_name FROM student WHERE student_id=$studentId AND pass=SHA2('$password', 512);";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0){
            echo "login Successful <br>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "Welcome ", $row['first_name'];

                
            }
        
        }else{
            echo"Login failed. Please re-enter your credentials.";
        }

        

    ?>
</body>
</html>