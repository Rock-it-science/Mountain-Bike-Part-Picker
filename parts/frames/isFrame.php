<?php
//TODO make this non-specific to frames and/or put in a folder called compatibility
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Checking if frame partType exists in currentBuild table
$result = $conn->query("SELECT partType FROM currentBuild;");
if($result->num_rows > 0){
  echo "You can only have one frame selected at a time";
}
 ?>
