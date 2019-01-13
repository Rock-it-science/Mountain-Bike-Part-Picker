<?php
/*
- This script moves id of drivetrain and drivetrain options to currentBuild
*/

echo("addToBuild started");

//TODO update when userId system is implemented
$userId = 0;

//TODO make a function that does all these automatically
$drivetrainId = $_REQUEST["drivetrainId"];
$price = $_REQUEST["price"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

//Adding to drivetrainbuild table, TODO make this dependant on userId
$result = $conn->query("UPDATE drivetrainBuild SET drivetrainID=$drivetrainId, drivetrainPrice=$price WHERE userID=0;");

echo($result);

$conn->close();
?>
