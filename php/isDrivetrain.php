<?php
//TODO make this non-specific to drivetrains and/or put in a folder called compatibility
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Checking if drivetrain partType exists in currentBuild table
$result = $conn->query("SELECT drivetrainID FROM drivetrainbuild;");
$row = $result->fetch_assoc();
$drivetrainId = $row["drivetrainID"];
if(($drivetrainId) && ($drivetrainId != "")){
  echo "drivetrain selected";
}
 ?>
