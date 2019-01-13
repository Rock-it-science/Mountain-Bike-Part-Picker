<?php
//Add part to database from given data and create a new page for it

//Getting variables from URL
$brand = $_REQUEST["brand"];
$model = $_REQUEST["model"];
$year = $_REQUEST["year"];
$manufLink = $_REQUEST["manuf"];
$imgLink = $_REQUEST["img"];

//SQL setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mtbpp";
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}

//Get highest id from shocks table (highest id equals number of rows)
$result1 = $conn->query("SELECT id FROM shocks;");
$id = mysqli_num_rows($result1)+1;//Add one since id of new part will be the largest id already in table + 1

//Put new shock into SQL table
$result2 = $conn->query("INSERT INTO shocks VALUES (" . $id . ", \"" . $brand . "\", \"" . $model . "\", " . $year . ", \"" . $manufLink . "\", \"" . $imgLink . "\");");
if(!$result2){failure();}
else{success();}

function success(){
  header('Location: /submit_success.html');
}

function failure(){
  echo "Something went wrong";
}
 ?>
