<!DOCTYPE html>
<meta charset="utf-8"/>
<html>

<body>
  <h1>Select a Frame</h1>
  <table width="75%" align="center">
    <tr>
      <th>Year</th>
      <th>Part</th>
      <th>Price</th>
      <th>View Part</th>
    </tr>



<?php
  //Connection setup
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "mtbpp";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
  }

  //For every item in frames table, add a row to the table
  $result = $conn->query("SELECT * FROM frames;");
  while($row = $result->fetch_assoc()){
    echo("
    <tr align=\"center\">
      <td>" . $row["year"] . "</td>
      <td>" . $row["brand"]. " " . $row["model"] . "</td>
      <td></td>" //Price row to be implemented later
      . "<td align=\"center\"><button onclick=\"location.href='frame.php?id=" . $row["id"] . "';\">Select</button></td>
    </tr>
    ");
  }
 ?>
 </table>
</body>
</html>
