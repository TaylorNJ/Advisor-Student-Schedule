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
     $studentID = $_REQUEST["studentId"]; 
 
      $conn = mysqli_connect("localhost", "natalia", "root", "termproject") or die("Connection failed: " . mysqli_connect_error());
      $query= "SELECT DISTINCT advisor.first_name, advisor.last_name FROM advisor
                INNER JOIN department ON advisor.advisor_id=department.advisor_id
                INNER JOIN major ON department.dept_name=major.dept_name
                INNER JOIN student ON student.major=major.dept_name
                WHERE student_id ='$studentID';";

        
    $result = mysqli_query($conn, $query);
    echo"<h1>Make appointment with: </h1><br>";
    if ($result) {
                while($row = mysqli_fetch_assoc($result)) {
                echo
                    $row['first_name'] ," ", $row['last_name'];
                }
            } else {
                echo "0 results";
                }
    
    ?>
</body>
</html>