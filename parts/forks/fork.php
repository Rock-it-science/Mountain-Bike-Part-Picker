<!DOCTYPE html>
<meta charset="utf-8"/>
<html>
<style>
/* Dropdown Button */
.dropbtn {
    border: none;
    padding: 4px;
    cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #eaeaea}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}
</style>
<body>

<!--Extra invisible p to pass id to js through DOM, also set up SQL connection stuff here too-->
<p id="forkID" style="display: none;">
 <?php
  //Connection stuff
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "mtbpp";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
  }

  //Get ID then echo it
  $id = $_REQUEST["id"];
  echo $id;
 ?>
</p>

<div align="right">
  <button id="back" onclick="back()">Back to build</button>
</div>

<div align="center">
  <h1><a id="fork name" href="
 <?php //Getting manuLink from forks table using id
  $result = $conn->query("SELECT * FROM forks WHERE id=" . $id . ";");
  $row = $result->fetch_assoc();
  $manuf = $row["manufLink"];
  echo $manuf;
 ?>
    ">
    <?php   //Getting fork brand and model name from forks table using id
    $brand = $row["brand"];
    $model = $row["model"];
    echo $brand . " " . $model;
     ?>
  </a></h1>
  <img src="
<?php  //Getting imgLink from forks table using id
  $img = $row["imgLink"];
  echo $img;
 ?>
  " width="500"/>
</div>

<div align="center">
  Fork size:
  <div class="dropdown">
  <button onclick="forkDrop()" class="dropbtn"><a id="t_dropdown-text">Select Travel  &#9660;</a></button>
    <div id="t_Dropdown" class="dropdown-content">
      <?php //Get fork sizes from forks table
        $travelString = $row["travels"];
        $travels = explode(" ", $travelString); //Explode sizesString into an array of available sizes)
        for($i=0; $i<sizeof($travels); $i++){//For every item in sizes, add an opiton in the drop-down for it
          echo "<a onclick=\"travel(&quot;" . $travels[$i] . "&quot;)\">" . $travels[$i] . "</a>";
        }
       ?>
    </div>
  </div>

  <div class="dropdown">
  <button onclick="wheelDrop()" class="dropbtn"><a id="s_dropdown-text">Select Wheel Size  &#9660;</a></button>
    <div id="s_Dropdown" class="dropdown-content">
      <?php //Get compatible wheel sizes from forks table
        $wsizesString = $row["wheelSizes"];
        $wsizes = explode(" ", $wsizesString); //Explode sizesString into an array of available sizes
        for($i=0; $i<sizeof($wsizes); $i++){//For every item in sizes, add an opiton in the drop-down for it
          echo "<a onclick=\"wheelSize(" . $wsizes[$i] . ")\"> " . $wsizes[$i] . "</a>";
        }
      ?>
    </div>
  </div>

  <p id="price" style="display: none;">Price: $3000</p>
  <div>
    <button id="addButton" onclick="add()" style="display: none;">Add to list</button>
  </div>
</div>


<script>

//configurable variables
var forkName = document.getElementById("fork name").innerHTML;
var price = 700;

//TODO Add dynamic pricing
//TODO Add more dropdowns for colour, etc
//TODO Add price management from different websites

  //Back button
  function back(){
    window.location.href="../../index.html";
  }

  //fork size dropdown
  function forkDrop() {
      document.getElementById("t_Dropdown").classList.toggle("show");
  }
  function wheelDrop(){
      document.getElementById("s_Dropdown").classList.toggle("show");
  }

  window.onclick = function(event) {
    // Close the dropdown if the user clicks outside of it
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }

    //if all selections are made, show add to list button
    if((travelSelection != null) && (wheelSizeSelection != null)){
      document.getElementById("addButton").style.display = "block";
  }
}

//dropdown selection functions
var travelSelection, wheelSizeSelection, materialSelection;
function travel(t){
  document.getElementById("t_dropdown-text").innerHTML = t;
  travelSelection = t;
}

function wheelSize(size){
  document.getElementById("s_dropdown-text").innerHTML = String(size);
  wheelSizeSelection = String(size);
}

function add(){
  isFork(function(b){//Callback function to be executed after isfork
    var isf = b;
    if(!isf){ //if there is no fork in currentBuild, then add this one
      console.log("adding fork");
      addRequest = new XMLHttpRequest();
      addRequest.onreadystatechange = function() {
         if (addRequest.status == 200) {
           console.log(addRequest.responseText);
           //addRequest.abort();
           window.location.href="../../index.html";
         }
       };
       addRequest.open("GET","addForkToBuild.php?forkId="+document.getElementById("forkID").innerHTML+"&size="+travelSelection+"&wheelsize="+wheelSizeSelection+"&price="+price,true);
       addRequest.send();
    }
    //if there is a fork selected
    else{
      window.alert("You already have a fork selected!");
    }
  });
}

//Check if fork is in currentBuild
async function isFork(callback){
  var isforkRequest = new XMLHttpRequest();
  let forkPromise = new Promise((resolve, reject) => {
    isforkRequest.onreadystatechange = function check(){
      //console.log("isforkRequest status = " + isforkRequest.status);
      if(isforkRequest.readyState == 4 && isforkRequest.status == 200){
        if(isforkRequest.responseText != ""){
          //Fork is selected
          console.log(isforkRequest.responseText);
          resolve(true);
        }
        else{
          //Fork not selected
          console.log("no fork selected");
          resolve(false);
        }
      }
    };
  });
  isforkRequest.open("GET", "../../php/isPart.php?pt=fork", true);
  isforkRequest.send();
  let b = await forkPromise;
  console.log(b);
  callback(b);
}

</script>

</body>
</html>
