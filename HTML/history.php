<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: signinfibro.php");
    exit;
}
require_once "config.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
}
?>
 
<!DOCTYPE html>
<html lang="fi">
   <head>
      <title>Historia</title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="stylesheet" href="css/parallax.css" />
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
      <link
         rel="stylesheet"
         href="https://fonts.googleapis.com/css?family=Lato"
         />
      <link
         rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
         />
      <style>
         #chartdiv {
         width: 100%;
         height: 500px;
         }
         table {
         border-collapse: collapse;
         width: 100%;
         color: black;
         font-family: monospace;
         font-size: 15px;
         text-align: left;
         }
         th {
         background-color: gray;
         color: white;
         }
         tr:nth-child(even) {background-color: #f2f2f2}
      </style>
      <!-- Resources -->
      <script src="https://www.amcharts.com/lib/4/core.js"></script>
      <script src="https://www.amcharts.com/lib/4/charts.js"></script>
      <script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
      <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
   </head>
   <body>
      <!-- Navbar (sit on top) -->
      <nav class="w3-top">
         <div class="w3-bar" id="myNavbar">
            <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
            <i class="fa fa-bars"></i>
            </a>
            <a href="inputfibro.php" class="w3-bar-item w3-button">ETUSIVU</a>	
            <a href="inputfibro.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> OSA-ALUEET</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> HISTORIA</a>
            <a href="about.html" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> TIETOA</a>
            <a href="logoutfibro.php" class="w3-bar-item w3-button w3-hide-small w3-right"><i class="fa fa-user"></i> KIRJAUDU ULOS</a>
         </div>
         <!-- Navbar on small screens -->
         <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
            <a href="inputfibro.php" class="w3-bar-item w3-button" onclick="toggleFunction()">OSA-ALUEET</a>
            <a href="#" class="w3-bar-item w3-button" onclick="toggleFunction()">HISTORIA</a>
            <a href="about.html" class="w3-bar-item w3-button" onclick="toggleFunction()">TIETOA</a>
            <a href="logoutfibro.php" class="w3-bar-item w3-button" onclick="toggleFunction()">KIRJAUDU ULOS</a>
         </div>
      </nav>
      <!-- First Parallax Image with Logo Text -->
      <div class="bgimg-1 w3-display-container w3-opacity-min" id="home">
         <div class="w3-display-middle" style="white-space:nowrap;">
            <div class="logo">
               <img id="logohistory" src="w3images/historialogo1n.png" alt="logo"> 
            </div>
         </div>
      </div>
      <div id="chartdiv"></div>
      <table>
      <tr>
         <th>Päivä</th>
         <th>Kommentti</th>
         <th>Osa-alue</th>
      </tr>
  <?php
  // Table Data rendering-------------------------------------------

$link = new mysqli( 'mysql.metropolia.fi', 'jonathac', 'Jonathan1995', 'jonathac' );

if ( $link->connect_errno ) {
  die( "Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error );
}
// Fetch the data
$query = "
SELECT  timestamp, comment, type
FROM diaryentry  
WHERE userId = {$_SESSION["id"]} AND comment <> ''
ORDER BY timestamp";
$result = $link->query( $query );

// All good?
if ( $result-> num_rows > 0 ) {
  while ( $row = $result->fetch_assoc() ) {
    echo "<tr><td>". $row["timestamp"] ."</td><td>". $row["comment"] ."</td><td>". $row["type"] ."</td></tr>";
  }
  echo "</table>";
}
else {
  echo "0 result";
}
  
  $link-> close();
  
  



  //HTML---------------------------------------
  ?>
</table>
</div>
<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">
   <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
   <div class="w3-xlarge w3-section">
      <i class="fa fa-facebook-official w3-hover-opacity"></i>
      <i class="fa fa-instagram w3-hover-opacity"></i>
      <i class="fa fa-snapchat w3-hover-opacity"></i>
      <i class="fa fa-pinterest-p w3-hover-opacity"></i>
      <i class="fa fa-twitter w3-hover-opacity"></i>
      <i class="fa fa-linkedin w3-hover-opacity"></i>
   </div>
   <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>
<script>
   // Modal Image Gallery
   function onClick(element) {
     document.getElementById("img01").src = element.src;
     document.getElementById("modal01").style.display = "block";
     var captionText = document.getElementById("caption");
     captionText.innerHTML = element.alt;
   }
   
   // Change style of navbar on scroll
   window.onscroll = function() {
     myFunction();
   };
   function myFunction() {
     var navbar = document.getElementById("myNavbar");
     if (
       document.body.scrollTop > 100 ||
       document.documentElement.scrollTop > 100
     ) {
       navbar.className =
         "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";
     } else {
       navbar.className = navbar.className.replace(
         " w3-card w3-animate-top w3-white",
         ""
       );
     }
   }
   
   // Used to toggle the menu on small screens when clicking on the menu button
   function toggleFunction() {
     var x = document.getElementById("navDemo");
     if (x.className.indexOf("w3-show") == -1) {
       x.className += " w3-show";
     } else {
       x.className = x.className.replace(" w3-show", "");
     }
   }
</script>
<script>
 // Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
//parse JSON
//var pain_JSON = JSON.parse('data_pain.php');
//console.log (pain_JSON);
// Set up data source
//series2.data = [
//dataSource.url ="data_sleep.php"
//];
// Create axes
//var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
//categoryAxis.dataFields.category = "timestamp";
// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.minGridDistance = 50;
dateAxis.renderer.grid.template.location = 0.5;
dateAxis.startLocation = 0.5;
dateAxis.endLocation = 0.5;


// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series1 = chart.series.push(new am4charts.LineSeries());
series1.dataFields.valueY = "level";
series1.dataFields.dateX = "timestamp";
series1.name = "Kipu";
series1.strokeWidth = 3;
series1.tensionX = 0.7;
series1.bullets.push(new am4charts.CircleBullet());
series1.data = <?php 
$type = "Kipu";
include('data.php');
echo $out;
 ?>;
var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "level";
series2.dataFields.dateX = "timestamp";
series2.name = "Uni";
series2.strokeWidth = 3;
series2.tensionX = 0.7;
series2.bullets.push(new am4charts.CircleBullet());
series2.data = <?php 
$type = "Uni";
include('data.php');
echo $out;
 ?>;
var series3 = chart.series.push(new am4charts.LineSeries());
series3.dataFields.valueY = "level";
series3.dataFields.dateX = "timestamp";
series3.name = "Väsymys";
series3.strokeWidth = 3;
series3.tensionX = 0.7;
series3.bullets.push(new am4charts.CircleBullet());
series3.data = <?php 
$type = "Väsynys";
include('data.php');
echo $out;
 ?>;
var series4 = chart.series.push(new am4charts.LineSeries());
series4.dataFields.valueY = "level";
series4.dataFields.dateX = "timestamp";
series4.name = "Stressi";
series4.strokeWidth = 3;
series4.tensionX = 0.7;
series4.bullets.push(new am4charts.CircleBullet());
series4.data = <?php 
$type = "Stressi";
include('data.php');
echo $out;
 ?>;
var series5 = chart.series.push(new am4charts.LineSeries());
series5.dataFields.valueY = "level";
series5.dataFields.dateX = "timestamp";
series5.name = "Liikunta";
series5.strokeWidth = 3;
series5.tensionX = 0.7;
series5.bullets.push(new am4charts.CircleBullet());
series5.data = <?php 
$type = "Liikunta";
include('data.php');
echo $out;
 ?>;
/*
series2.data = [
chart.dataSource.url ="data_sleep.php"
];
var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "level";
series2.dataFields.categoryX = "timestamp";
series2.name = "sleep";
series2.strokeWidth = 3;
series2.tensionX = 0.7;
series2.bullets.push(new am4charts.CircleBullet());

chart.dataSource.url ="data_fatigue.php";
var series3 = chart.series.push(new am4charts.LineSeries());
series3.dataFields.valueY = "level";
series3.dataFields.categoryX = "timestamp";
series3.name = "fatigue";
series3.strokeWidth = 3;
series3.tensionX = 0.7;
series3.bullets.push(new am4charts.CircleBullet());
*/
// Add legend
chart.legend = new am4charts.Legend();
console.log(chart);
    </script>
    
</body>
</html>