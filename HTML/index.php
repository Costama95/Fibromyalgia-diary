<?php
//force secure connetion
require_once('secure.php');
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: signinfibro.php");
    exit;
}
require_once "config.php";
//warning message create
$warningmessage= "Tallenna";

$exist=array();
//1. run select query to see if we already have values.
//if exist feed array ADD IDs (entryId)!!!
//else, default
$exist["pain_level"]=1;
$exist["pain_info"]="";



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $link = mysqli_connect('mysql.metropolia.fi', 'jonathac', 'Jonathan1995', 'jonathac' );
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$_SESSION['today']=date("Y-m-d");

// Fetch the data
$query = "
SELECT entryId
FROM diaryentry  
WHERE userId = {$_SESSION["id"]} AND timestamp = '{$_SESSION['today']}'
";
$result = mysqli_query($link,$query);
// check if input for today exist
if (mysqli_num_rows($result)!=0) {
	$warningmessage = 'You have already entered information for today';
	echo "<script type='text/javascript'>alert('$warningmessage');</script>";

}else {



    // if not exist (no IDs)
    $sql = "INSERT INTO diaryentry (level, timestamp, type, comment, userId, bodypart) VALUES (?, ?, ?, ?, ?, ?)";
    // else there is existing values
    //$sql = "UPDATE `diaryentry` SET `comment` = ?, level = ?, bodyp... WHERE `diaryentry`.`entryId` = ?";
    if ($stmt = mysqli_prepare($link,$sql)) {
      mysqli_stmt_bind_param($stmt, "isssii", $_level, $date, $_type, $_info, $userId, $_location);
    //set parameters
    $date = date('Y-m-d');
    $userId = $_SESSION['id'];

    //here loop foreach "pain", "sleep", "stress",...
    $type=array("Kipu","Uni", "Väsymys", "Stressi", "Liikunta");
    foreach($type as $ty){
      $_level = (int)$_POST[$ty.'_slider'];
      $_type = $ty;
      $_info = $_POST[$ty.'_info'];
      if($ty=="Kipu"){
        $_location = (int)$_POST['Kipu_location'];
      }else{
        $_location = null;
      }
      //if exist, inject id
      

      


      if(mysqli_stmt_execute($stmt)){
        $success = "Records inserted successfully.";
    } else{
        echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
    } 
  }
  //end loop
} else{
  echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
}

// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($link); 
}
}

    
    
  



  
  //INSERT INTO `diaryentry` (`level`, `timestamp`, `type`, `comment`, `userId`, `bodypart`) VALUES ('3', '2019-04-09', 'kipu', 'radiate', '14', '1');

    //INSERT INTO `diaryentry` (`level`, `timestamp`, `type`, `comment`, `userId`, `bodypart`) VALUES ('$level', '$currenttime', '$type', '$text', '$userId', '$bodypart');
//'". $_SESSION['id'] ."'
    // Fetch the data



?>

<!doctype html>
<html lang="fi">
   <title>Fibromyalgiapäiväkirja</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/parallax.css">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <body>
      <!-- Navbar (sit on top) -->
      <nav class="w3-top">
         <div class="w3-bar" id="myNavbar">
            <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
            <i class="fa fa-bars"></i>
            </a>
            <a href="#home" class="w3-bar-item w3-button">ETUSIVU</a>
            <a href="#home" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> OSA-ALUEET</a>
            <a href="history.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> HISTORIA</a>
            <a href="about.html" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> TIETOA</a>
            <a href="logoutfibro.php" class="w3-bar-item w3-button w3-hide-small w3-right"><i class="fa fa-user"></i> KIRJAUDU ULOS</a>
         </div>
         <!-- Navbar on small screens -->
         <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
            <a href="#home" class="w3-bar-item w3-button" onclick="toggleFunction()">OSA-ALUEET</a>
            <a href="history.php" class="w3-bar-item w3-button" onclick="toggleFunction()">HISTORIA</a>
            <a href="about.html" class="w3-bar-item w3-button" onclick="toggleFunction()">TIETOA</a>
            <a href="logoutfibro.php" class="w3-bar-item w3-button" onclick="toggleFunction()">KIRJAUDU ULOS</a>
         </div>
      </nav>
      <!-- Background and logo -->
      <div class="bgimg-1 w3-display-container w3-opacity-min" id="home">
         <div class="w3-display-middle" style="white-space:nowrap;">
            <div class="logo">
               <img id="logo" src="w3images/Logo12n.png" alt="logo">
            </div>
         </div>
         <!--circlemenu -->
         <div class="circlemenu">
            <ul>
               <li><a href="#line1" class="w3-bar-item w3-button"><span>Kipu</span></a>
               </li>
               <li><a href="#line2" class="w3-bar-item w3-button"><span>Väsymys</span></a>
               </li>
               <li><a href="#line3" class="w3-bar-item w3-button"><span>Uni</span></a>
               </li>
               <li><a href="#line4" class="w3-bar-item w3-button"><span>Liikunta</span></a>
               </li>
               <li><a href="#line5" class="w3-bar-item w3-button"><span>Stressi</span></a>
               </li>
            </ul>
         </div>
      </div>
      <!--Form-->
      <div class="bgimg-1 w3-display-container w3-opacity-min" id="kipu">
         <div class="fullpaincontainer">
            <div class="form-style-5" style="text-align: center">
               <img id="line1" src="w3images/line1.png" alt="viiva">
               <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">
                  <fieldset>
                     <legend><span class="number">1</span> Kipu</legend>
                     <div class="slidecontainer" style="text-align: center">
                        <input type="range" min="1" max="5" value="1" class="slider" id="myRange" name="Kipu_slider">
                        <div class="degree"><p>Aste: <span id="demo"></span></p></div>
                        <img id="img01" src="w3images/face1.PNG" alt="kipuasteikko">
                     </div>
                     <textarea name="Kipu_info" placeholder="Tähän voit kirjoittaa vapaasti päiväkirjamerkintöjä..."></textarea>
                     <label for="location">Kivun paikka</label>
                     <select id="location" name="Kipu_location">
                        <optgroup label="Kivun paikka">
                           <option value="1">Niska</option>
                           <option value="2">Yläselkä</option>
                           <option value="3">Alaselkä</option>
                           <option value="4">Olkapää</option>
                           <option value="5">Kyynärpää</option>
                           <option value="6">Ranne</option>
                           <option value="7">Kädet, muu</option>
                           <option value="8">Käsien lihakset</option>
                           <option value="9">Lonkka</option>
                           <option value="10">Polvi</option>
                           <option value="11">Nilkka</option>
                           <option value="12">Jalat, muu</option>
                           <option value="13">Jalkojen lihakset</option>
                           <option value="14">Muu</option>
                        </optgroup>
                     </select>
                  </fieldset>
                  <img id="line2" src="w3images/line1.png" alt="viiva">
                  <fieldset>
                     <legend><span class="number" id="vasymys">2</span> Väsymys</legend>
                     <div class="slidecontainer" style="text-align: center">
                        <input type="range" min="1" max="5" value="1" class="slider" id="myRange2" name="Väsymys_slider">
                        <div class="degree"><p>Aste: <span id="demo2"></span></p></div>
                        <img id="img02" src="w3images/face1.PNG" alt="kipuasteikko">
                     </div>
                     <textarea name="Väsymys_info" placeholder="Tähän voit kirjoittaa vapaasti päiväkirjamerkintöjä..."></textarea>
                  </fieldset>
                  <img id="line3" src="w3images/line1.png" alt="viiva">
                  <fieldset>
                     <legend><span class="number" id="uni">3</span> Uni</legend>
                     <div class="slidecontainer" style="text-align: center">
                        <input type="range" min="1" max="5" value="1" class="slider" id="myRange3" name="Uni_slider">
                        <div class="degree"><p>Aste: <span id="demo3"></span></p></div>
                        <img id="img03" src="w3images/erittainhyva.PNG" alt="kipuasteikko">
                     </div>
                     <br>
                     <textarea name="Uni_info" placeholder="Tähän voit kirjoittaa vapaasti päiväkirjamerkintöjä..."></textarea>
                  </fieldset>
                  <img id="line4" src="w3images/line1.png" alt="viiva">
                  <fieldset>
                     <legend><span class="number" id="liikunta">4</span> Liikunta</legend>
                     <div class="slidecontainer" style="text-align: center">
                        <input type="range" min="1" max="5" value="1" class="slider" id="myRange4" name="Liikunta_slider">
                        <div class="degree"><p>Aste: <span id="demo4"></span></p></div>
                        <img id="img04" src="w3images/hyvinkevyt.PNG" ; alt="kipuasteikko">
                     </div>
                     <br>
                     <textarea name="Liikunta_info" placeholder="Tähän voit kirjoittaa vapaasti päiväkirjamerkintöjä..."></textarea>
                  </fieldset>
                  <img id="line5" src="w3images/line1.png" alt="viiva">
                  <fieldset>
                     <legend><span class="number" id="stressi">5</span> Stressi</legend>
                     <div class="slidecontainer" style="text-align: center">
                        <input type="range" min="1" max="5" value="1" class="slider" id="myRange5" name="Stressi_slider">
                        <div class="degree"><p>Aste: <span id="demo5"></span></p></div>
                        <img id="img05" src="w3images/face1.PNG" alt="kipuasteikko">
                     </div>
                  </fieldset>
                  <textarea name="Stressi_info" placeholder="Tähän voit kirjoittaa vapaasti päiväkirjamerkintöjä..."></textarea>
                  <input type="submit" value="Tallenna"/>
               </form>
            </div>
         </div>
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
         <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a>
         </p>
      </footer>

<script>
   // Slidecontainer
   var slider = document.getElementById("myRange");
   var output = document.getElementById("demo");
   	output.innerHTML = slider.value;
   
   	slider.oninput = function() {
     	output.innerHTML = this.value;
   		if(slider.value >= 1 && slider.value < 2)
   			document.getElementById("img01").src="w3images/face1.PNG";
   			else if(slider.value >= 2 && slider.value < 3)
   				document.getElementById("img01").src = src="w3images/face2.PNG";
   			else if(slider.value >= 3 && slider.value < 4)
   				document.getElementById("img01").src = src="w3images/face3.PNG";
   			else if(slider.value >= 4 && slider.value < 5)
   				document.getElementById("img01").src = src="w3images/face4.PNG";
   			else if(slider.value >= 5 && slider.value < 6)
   				document.getElementById("img01").src = src="w3images/face5.PNG";
   	}
   // Slidecontainer 2
   var slider2 = document.getElementById("myRange2");
   var output2 = document.getElementById("demo2");
   	output2.innerHTML = slider2.value;
   
   	slider2.oninput = function() {
     	output2.innerHTML = this.value;
   		if(slider2.value >= 1 && slider2.value < 2)
   			document.getElementById("img02").src = "w3images/face1.PNG";
   			else if(slider2.value >= 2 && slider2.value < 3)
   				document.getElementById("img02").src = "w3images/face2.PNG";
   			else if(slider2.value >= 3 && slider2.value < 4)
   				document.getElementById("img02").src = "w3images/face3.PNG";
   			else if(slider2.value >= 4 && slider2.value < 5)
   				document.getElementById("img02").src = "w3images/face4tired.PNG";
   			else if(slider2.value >= 5 && slider2.value < 6)
   				document.getElementById("img02").src = "w3images/face5tired.PNG";
   	}
   // Slidecontainer 3
   var slider3 = document.getElementById("myRange3");
   var output3 = document.getElementById("demo3");
   	output3.innerHTML = slider3.value;
   
   	slider3.oninput = function() {
     	output3.innerHTML = this.value;
   		if(slider3.value >= 1 && slider3.value < 2)
   			document.getElementById("img03").src = "w3images/erittainhyva.PNG";
   			else if(slider3.value >= 2 && slider3.value < 3)
   				document.getElementById("img03").src = "w3images/hyva.PNG";
   			else if(slider3.value >= 3 && slider3.value < 4)
   				document.getElementById("img03").src = "w3images/keskimaarainen.PNG";
   			else if(slider3.value >= 4 && slider3.value < 5)
   				document.getElementById("img03").src = "w3images/huono.PNG";
   			else if(slider3.value >= 5 && slider3.value < 6)
   				document.getElementById("img03").src = "w3images/erittainhuono.PNG";
   	}
   // Slidecontainer 4
   var slider4 = document.getElementById("myRange4");
   var output4 = document.getElementById("demo4");
   	output4.innerHTML = slider4.value;
   
   	slider4.oninput = function() {
     	output4.innerHTML = this.value;
   		if(slider4.value >= 1 && slider4.value < 2)
   			document.getElementById("img04").src = "w3images/hyvinkevyt.PNG";
   			else if(slider4.value >= 2 && slider4.value < 3)
   				document.getElementById("img04").src = "w3images/kevyt.PNG";
   			else if(slider4.value >= 3 && slider4.value < 4)
   				document.getElementById("img04").src = "w3images/hiemanraskas.PNG";
   			else if(slider4.value >= 4 && slider4.value < 5)
   				document.getElementById("img04").src = "w3images/raskas.PNG";
   			else if(slider4.value >= 5 && slider4.value < 6)
   				document.getElementById("img04").src = "w3images/hyvinraskas.PNG";
   	}
   // Slidecontainer 5
   var slider5 = document.getElementById("myRange5");
   var output5 = document.getElementById("demo5");
   	output5.innerHTML = slider5.value;
   
   	slider5.oninput = function() {
     	output5.innerHTML = this.value;
   		if(slider5.value >= 1 && slider5.value < 2)
   			document.getElementById("img05").src="w3images/face1.PNG";
   			else if(slider5.value >= 2 && slider5.value < 3)
   				document.getElementById("img05").src="w3images/face2.PNG";
   			else if(slider5.value >= 3 && slider5.value < 4)
   				document.getElementById("img05").src="w3images/face3.PNG";
   			else if(slider5.value >= 4 && slider5.value < 5)
   				document.getElementById("img05").src="w3images/face4.PNG";
   			else if(slider5.value >= 5 && slider5.value < 6)
   				document.getElementById("img05").src="w3images/face5.PNG";
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
