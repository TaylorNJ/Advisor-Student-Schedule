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
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];

        $conn = mysqli_connect("localhost", "natalia", "root", "termproject") or die("Connection failed: " . mysqli_connect_error());

        $query = "SELECT pass=SHA2('$password', 512) FROM users WHERE first_name='$username';";

    ?>
</body>
</html>