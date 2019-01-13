<?php
//Add part to database from given data and create a new page for it

//Getting variables from URL
$brand = $_REQUEST["brand"];
$model = $_REQUEST["model"];
$year = $_REQUEST["year"];
$travel = $_REQUEST["travels"];
$wheelSize = $_REQUEST["wheelSize"];
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

//Get highest id from forks table (highest id equals number of rows)
$result1 = $conn->query("SELECT id FROM forks;");
$id = mysqli_num_rows($result1)+1;//Add one since id of new part will be the largest id already in table + 1


//Converting arrays to strings (keeping specific format for sql table)
$travelString = $travel[0];
for($i=1; $i<sizeof($travel); $i++){
  $travelString .= " " . $travel[$i];
}

$wheelSizeString = $wheelSize[0];
for($i=1; $i<sizeof($wheelSize); $i++){
  $wheelSizeString .= " " . $wheelSize[$i];
}

//Put new fork into SQL table
$result2 = $conn->query("INSERT INTO forks VALUES (" . $id . ", \"" . $brand . "\", \"" . $model . "\", " . $year . ", \"" . $travelString . "\", \"" . $wheelSizeString . "\", \"" . $manufLink . "\", \"" . $imgLink . "\");");
if(!$result2){failure();}
else{success();}

function success(){
  header('Location: /submit_success.html');
}

function failure(){
  echo "Something went wrong";
}
 ?>
