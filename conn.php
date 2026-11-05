<?php

$username = "root";
$password = 'claritaz@321';
$hostname = "localhost";

//connection to the database
$dbhandle = mysqli_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";


$con = mysqli_connect($hostname, $username, $password, "villgro_vital_mis");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Database Connection Successfully";
}

mysqli_close($con);
?>
