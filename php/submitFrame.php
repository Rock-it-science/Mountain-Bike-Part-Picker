<?php
//Add part to database from given data and create a new page for it

//Getting variables from URL
$brand = $_REQUEST["brand"];
$model = $_REQUEST["model"];
$year = $_REQUEST["year"];

//SQL setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Get highest id from frames table (highest id equals number of rows)
$result1 = $conn->query("SELECT id FROM frames;");
$rows = $result1->fetch_assoc();
$id = sizeof($rows)+1;//Add one since id of new part will be the largest id already in table + 1

$conn->query("INSERT INTO frames VALUES (" . $id . ", \"" . $brand . "\", \"" . $model . "\", " . $year . ");");
header('Location: /submit_success.html');
 ?>
