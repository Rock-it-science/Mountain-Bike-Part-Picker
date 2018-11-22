<?php
/*
- This script moves id of shock and shock options to currentBuild
*/

echo("addToBuild started");

//TODO update when userId system is implemented
$userId = 0;

//TODO make a function that does all these automatically
$shockId = $_REQUEST["shockId"];
$price = $_REQUEST["price"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

//Adding to shockbuild table, TODO make this dependant on userId
$result = $conn->query("UPDATE shockBuild SET shockID=$shockId, shockPrice=$price WHERE userID=0;");

echo($result);

$conn->close();
?>
