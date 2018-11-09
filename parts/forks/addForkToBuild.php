<?php
/*
- This script moves id of frame and frame options to currentBuild
*/

echo("addToBuild started");

//TODO update when userId system is implemented
$userId = 0;

//TODO make a function that does all these automatically
$forkId = $_REQUEST["forkId"];
$price = $_REQUEST["price"];
$travel = $_REQUEST["travel"];
$wheelsize = $_REQUEST["wheelsize"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}
//Frame options string
$options = $travel . " " . $wheelsize;

//Adding part to forkBuild table
//If there is already a row for this userId, append to it rather than trying to add a new line
//$checkRow = $conn->query("SELECT * FROM forkBuild WHERE userId=0;");

//Adding to forkbuild table, TODO make this dependant on userId
$result = $conn->query("UPDATE forkBuild SET forkID=$forkId, forkOptions='$options', forkPrice=$price WHERE userID=0;");

//Worry about userId stuff later
/*if($checkRow->fetch_assoc()){
  $result = $conn->query("UPDATE currentBuild SET frameId=$frameId, frameOptions='$options' WHERE userId=0;");
}
else{
  $result = $conn->query("INSERT INTO currentBuild VALUES ($userId, $frameId, '$options');");
}
*/
echo($result);

$conn->close();

//currentBuild columns: userId, frameId, frameOptions, framePrice
//frames columns: id, brand, model;
?>
