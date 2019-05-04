<?php
// Initialize the session
require_once('secure.php');
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: inputfibro.php");
    exit;
}
//INSERT INTO `diaryentry` (`entryId`, `level`, `timestamp`, `type`, `comment`, `userId`, `bodypart`) VALUES (NULL, '3', '2019-04-09', 'kipu', 'radiate', '14', '1');
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT userId, username, password FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){   
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $userId, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                      
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $userId;
                            $_SESSION["username"] = $username;                            
                            //echo "what? $userId";
                            // Redirect user to welcome page
                            header("location: inputfibro.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($connection);
}
?>
 
<!DOCTYPE html>
<html lang="fi">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login</title>
	<link rel="stylesheet" href="../HTML/css2/bootstrap.min.css">
	<link rel="stylesheet" href="../HTML/css2/animate.css">
	<link rel="stylesheet" href="../HTML/css2/login.css">
</head>

<body>
	<div class="container">
		<div class="logo">
			<img id="logo" src="../HTML/w3images/Logo12n.png" alt="logo">
		</div>
		<section>
			<div id="container_demo">
				<div id="wrapper">
					<div id="login" class="animate form">
						<h2>Kirjaudu sisään</h2>
						<p>Syötä käyttäjätunnus ja paina Kirjaudu -nappia.</p>
						<form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post">
							<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
								<label>Käyttäjätunnus</label>
								<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
								<span class="help-block">
									<?php echo $username_err; ?>
								</span>
							</div>
							<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
								<label>Salasana</label>
								<input type="password" name="password" class="form-control">
								<span class="help-block">
									<?php echo $password_err; ?>
								</span>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-lg btn-link" value="Kirjaudu">
							</div>
							<p>Oletko vailla tunnuksia? <a href="signupfibro.php">Luo käyttäjä nyt!</a>.</p>
						</form>
					</div>
		</section>
		</div>
		</div>
	</div>
</body>
</html>





<!--<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<title>Test PHP form</title>
	<style> 
	
	
	</style>
</head>
<body>
<form action="/~jonathac/php/sign_in.php" method="post" class="forms">
  <div class="formusername">
    <label for="username">Username </label>
    <input type="text" name="username" id="username" required>
</div>
<div class="formpassword">
    <label for ="password"> Password </label>
    <input type="text" name="password" id="password" required>
    <div class="submit">
    <input type="submit" value="Login">
  </div>
</form>


/*session_start();
if ( ! empty( $_POST ) ) {
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Getting submitted user data from database
        $con = new mysqli("localhost", "root", "Password1234", "fibrotest");
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();
    	$user = $result->fetch_object();
    		
    	// Verify user password and set $_SESSION
    	if ( password_verify( $_POST['password'], $user->password ) ) {
    		$_SESSION['user_id'] = $user->ID;
    	}
    }
}
//$_SESSION['userID']= $userId;


?>
</body>
</html>*/