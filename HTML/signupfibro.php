
<?php

require_once "config.php";
//setting empty variables
$username = $password = $confirm_password = "";
//incase wrong data variables
$usernameerror = $passworderror = $confirmpassworderror = "";

if($_SERVER["REQUEST_METHOD"]=="POST") {

    if(empty(trim($_POST["username"]))) {
        $usernameerror= "Please enter username";
    } else {
        // Prepare a select statement
        $sql = "SELECT userId FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($connection, $sql)){
            

            // Bind variables to statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $usernameerror = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $passworderror = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $passworderror = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirmpassworderror = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($passworderror) && ($password != $confirm_password)){
            $confirmpassworderror = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($usernameerror) && empty($passworderror) && empty($confirmpassworderror)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: /~jonathac/signinfibro.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($connection);
    

    }



//----------------------------------------------------------------------
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($usernameerror)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $usernameerror; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($passworderror)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $passworderror; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($passworderror)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $passworderror; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="/~jonathac/inputfibro.php">Login here</a>.</p>
        </form>
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
<form action="/~jonathac/php/testdatabase.php" method="post" class="forms">
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


</html>-->