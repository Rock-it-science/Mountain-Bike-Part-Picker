<?php
//Check if a given part is currently in build by checking if the partTypeID is not null
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$partType = $_REQUEST["pt"];
$tableString = $partType . "Build";
$idString = $partType . "ID";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Checking if frame partType exists in currentBuild table
$result = $conn->query("SELECT $idString FROM $tableString;");
$row = $result->fetch_assoc();
$id = $row["$idString"];
if($id && ($id != 0)){
  echo "part selected";
}
 ?>
