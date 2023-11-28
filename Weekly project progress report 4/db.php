<?php
$servername = "13.58.185.172";
$username = "mahendra";
$password = "Vardhan2233";
$dbname = "car_leasing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//echo "Signup Success.Proceed to login.";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <p>Please click the button below to log in:</p>
    <a href="index.html"> Login </a>
    
</body>
</html>
