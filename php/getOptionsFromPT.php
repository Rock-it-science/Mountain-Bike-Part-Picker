<?php
//Use id passed from call to get frome name
$partType = $_REQUEST["pt"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}
//Setting up variables
$tableString = $partType . "Build";
$optionsString = $partType . "Options";

//Getting name from part table
$response = $conn->query("SELECT $optionsString FROM $tableString;");
if($row = $response->fetch_assoc()){
  echo $row["$optionsString"];
}
 ?>
