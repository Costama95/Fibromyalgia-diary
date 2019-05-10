<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: signinfibro.php");
    exit;
}
require_once "config.php";

$_SESSION['id']= $userId;
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>

<!doctype html>
<html lang="fi">
<title>HYTE Projekti</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/parallax.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
<body>

<!-- Navbar (sit on top) -->
<nav class="w3-top">
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
    <a href="#home" class="w3-bar-item w3-button">Hello, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</a>
    <a href="#kipu" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> SOVELLUS</a>
	<a href="historia.html" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> HISTORIA</a>
    <a href="about.html" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> TIETOA</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red">
      <i class="fa fa-search"></i>
    </a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="#kipu" class="w3-bar-item w3-button" onclick="toggleFunction()">SOVELLUS</a>
	<a href="historia.html" class="w3-bar-item w3-button" onclick="toggleFunction()">HISTORIA</a>
    <a href="tietoa.html" class="w3-bar-item w3-button" onclick="toggleFunction()">TIETOA</a>
    <a href="#" class="w3-bar-item w3-button">SEARCH</a>
  </div>
</nav>

<!-- Background Image with Logo Text -->
<div class="bgimg-1 w3-display-container w3-opacity-min" id="home">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <span class="w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity">FIBROMYALGIA-PÄIVÄKIRJA<br></span>
	<!-- Fastnavigation to pain etc. -->
	<div class="fastnav">
    <a href="#kipu" class="w3-bar-item w3-button" onclick="toggleFunction()">KIPU</a>
	<a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">VÄSYMYS</a>
    <a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">UNI</a>
	<a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">LIIKUNTA</a>
	<a href="" class="w3-bar-item w3-button" onclick="toggleFunction()">STRESSI</a>
  	</div>
  </div>
</div>

<!--Form-->
<div class="form-style-5" style="text-align: center" id="kipu">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>
<fieldset>
	<legend><span class="number">1</span> Kipu</legend>
		<div class="slidecontainer" style="text-align: center">
  			<input type="range" min="1" max="5" value="1" class="slider" id="myRange">
  			<p>Value: <span id="demo"></span></p>
		</div>
	<textarea name="field3" placeholder="Lisätietoa"></textarea>
	<label for="job">Paikka?</label>
	<select id="job" name="field4">
	<optgroup label="Kivun paikka">
  		<option value="olkapaa">Olkapää</option>
  		<option value="testi1">Testi</option>
  		<option value="testi2">Testi</option>
  		<option value="testi3">Testi</option>
  		<option value="testi4">Testi</option>
  		<option value="testi5">Testi</option>
 		 <option value="muu">Muu</option>
	</optgroup>
	<optgroup label="Testi">
  		<option value="testi6">Testi</option>
  		<option value="testi7">Testi</option>
  		<option value="testi8">Testi</option>
 		 <option value="testi9">Testi</option>
  		<option value="testi10">Testi</option>
 		 <option value="muu2">Muu</option>
	</optgroup>
	</select>      
</fieldset>
<fieldset>
<legend><span class="number">2</span> Placeholder</legend>
<textarea name="field3" placeholder="Testi"></textarea>
</fieldset>
<input type="submit" value="Lähetä" />
</form>
</div>
	
<!--Form ends-->


<div class="w3-row w3-center w3-dark-grey w3-padding-16">
  <div class="w3-quarter w3-section">
    <span class="w3-xlarge"></span>
  </div>
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
// Slidecontainer
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
	output.innerHTML = slider.value;

	slider.oninput = function() {
  	output.innerHTML = this.value;
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}

// Change style of navbar on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
    var navbar = document.getElementById("myNavbar");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";
    } else {
        navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white", "");
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

</body>
</html>
