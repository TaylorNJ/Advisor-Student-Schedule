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
        $sid = $_REQUEST['studentId'];
        // echo $sid;
        $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());
        $query = "SELECT first_name, last_name FROM student WHERE student_id=$sid";
        $result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($result)) {
            echo "<center><h2>", $row['first_name']," ", $row['last_name'];
                $query = "SELECT advisor.first_name, advisor.last_name FROM advisor 
                INNER JOIN advises ON advisor.advisor_id=advises.advisor_id
                WHERE advises.student_id=$sid;";
                $result = mysqli_query($conn, $query);
                if($row = mysqli_fetch_assoc($result)) {
                    echo" your advisor is ", $row['first_name'], " ",$row['last_name'],"</h2>";
                    echo"<p>Select an available slot from your advisor's schedule</p></center>";
                }
            }

            



    ?>
</body>
</html>