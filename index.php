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
        /* display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        border: 3px solid green;  */
    }
    a:link{
        text-decoration: none;
        color: black;
    }
    .link{
        font: bold 17px;
        text-decoration: none;
        background-color: #EEEEEE;
        color: #333333;
        padding: 2px 6px 2px 6px;
        border-top: 1px solid #CCCCCC;
        border-right: 1px solid #333333;
        border-bottom: 1px solid #333333;
        border-left: 1px solid #CCCCCC;
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
        if( isset($_COOKIE["userId"]) ){
            $aid= $_COOKIE['userId'];
            $conn = mysqli_connect("localhost", "natalia", "root", "advisor_student") or die("Connection failed: " . mysqli_connect_error());
            $query = "SELECT first_name, last_name FROM advisor WHERE advisor_id=$aid;";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<center><h1>Welcome ", $row['first_name']," ", $row['last_name'],"</h1>";
                    echo"<br><a href='schedule_advisor.php?userId=$aid'>Create Schedule</a>";
                    echo"<br><a href='schedule_advisor.php?userId=$aid'>View Schedule</a>";
                    echo"<br><br>Upcoming Appointments: ";
                    echo"</center>" ;
                }
            }
        }else{
            echo"<form action='index.php'>
                <p><a href='advisor_login.html' class='link'>Login as Faculty</a></p>
                <p><a href='student_login.html' class='link'>Login as Student</a></p>
                <br>
            </form>";
        }


    ?>
</body>
</html>