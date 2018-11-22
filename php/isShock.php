<?php
//TODO make this non-specific to shocks and/or put in a folder called compatibility
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Checking if shock partType exists in currentBuild table
$result = $conn->query("SELECT shockID FROM shockbuild;");
$row = $result->fetch_assoc();
$shockId = $row["shockID"];
if(($shockId) && ($shockId != "")){
  echo "shock selected";
}
 ?>
