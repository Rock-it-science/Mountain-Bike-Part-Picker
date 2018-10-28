<?php
//TODO make this non-specific to forks and/or put in a folder called compatibility
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Checking if fork partType exists in currentBuild table
$result = $conn->query("SELECT forkId FROM forkBuild;");
$row = $result->fetch_assoc();
$forkId = $row["forkId"];
if(($forkId) && ($forkId != "")){
  echo "fork selected";
}
 ?>
