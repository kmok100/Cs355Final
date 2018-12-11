<?php
//Below is copy and paste to show errors on white page
// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
ini_set('display_errors', 'On');
ini_set('html_errors', 0);

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// other php code
include("config.php");
session_start();

// connect to the database

$message="";
$username = "";
$email = ""; 

if (isset($_POST['register']))
{
  // receive all input values from the form
  $username = $_POST['username'];
  $password_1 = $_POST['password1'];
  $password_2 = $_POST['password2'];
  
  
  $email = $_POST['email'];
  $name = $_POST['name'];
  $gender = $_POST['gender'];  //M,F,O
  $age = $_POST['age'];
  $weight = $_POST['weight'];
  $height = $_POST['height'];
  $bmi = $weight * 703 / ($height * $height);
  $joined = date("Y-m-d");
  //birthday is formatted into correct db format
  $birthday = $_POST['birthday']; 
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  //Change below to match our db
  $user_check_query = "SELECT * FROM user WHERE Username='$username' OR email='$email' ";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($password_1 != $password_2) 
  {
	  echo ("The two passwords do not match");
  }
  else if ($user) // if user exists
  { 
    if ($user['username'] === $username)
    {
      echo("Username already exists. Try a new one");
    }

  }
  else
  {
    //remove echo below to hide username and password
    echo $username . " " . $password_1;
    //Change below to match our db
  	$query = "INSERT INTO user (email, username, password, name, gender, age, weight, height, joined, bmi, currentWeight, birthdate) 
  			  VALUES('$email', '$username', '$password_1', '$name', '$gender', '$age', '$weight', '$height', '$joined', '$bmi', '$weight', '$birthday')";
         
  	mysqli_query($conn, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
    //Echo below redirects to info.html. Uncomment out later
    //echo '<script>window.location.href = "info.html";</script>';
    
  }
}
?>

<html>
<head>
<title>Register (WIP)</title>
<style>
#frmRegistration { 
	padding: 20px 60px;
	background: #B6E0FF;
	color: #555;
	display: inline-block;
	border-radius: 4px; 
}
.field-group { 
	margin:15px 0px; 
}
.input-field {
	padding: 8px;width: 200px;
	border: #A3C3E7 1px solid;
	border-radius: 4px; 
}
.form-submit-button {
	background: #65C370;
	border: 0;
	padding: 8px 20px;
	border-radius: 4px;
	color: #FFF;
	text-transform: uppercase; 
}
.member-dashboard {
	padding: 40px;
	background: #D2EDD5;
	color: #555;
	border-radius: 4px;
	display: inline-block;
	text-align:center; 
}
.logout-button {
	color: #09F;
	text-decoration: none;
	background: none;
	border: none;
	padding: 0px;
	cursor: pointer;
}
.error-message {
	text-align:center;
	color:#FF0000;
}
.demo-content label{
	width:auto;
}
</style>
</head>
<body>
<div>
<div style="display:block;margin:0px auto;">
<form action="" method="post" id="frmRegistration">
  <div class="field-group">
		<div><label for="login">Username</label></div>
		<div><input name="username" type="text" class="input-field" maxlength="45" required></div>
	</div>
	<div class="field-group">
		<div><label for="login">Password</label></div>
		<div><input name="password1" type="password" class="input-field" maxlength="45" required> </div>
	</div>
  <div class="field-group">
		<div><label for="login">Re-enter Password</label></div> 
		<div><input name="password2" type="password" class="input-field" maxlength="45" required> </div>
  </div> 
	<div class="field-group">
		<div><label for="login">Email</label></div>
		<div><input name="email" type="text" class="input-field" placeholder="username@email.com" oninvalid="setCustomValidity('Please enter a valid email address.')" oninput="setCustomValidity('')" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$" required maxlength="45">
  </div>
	<div class="field-group">
		<div><label for="login">Name</label></div>
		<div><input name="name" type="text" class="input-field" maxlength="45" required> </div>
	</div>
  <div id="Gender">
        <select name='gender' >
          <option disabled selected value>Gender</option>
          <option value='M'>Male</option>
          <option value='F'>Female</option>
          <option value='O'>Other</option>
        </select>
  </div>
  <div class="field-group">
		<div><label for="login">Age</label></div> <!-- int(11)?-->
		<div><input name="age" type="number" class="input-field" pattern="[0-9]+" min="0" max="100" required></div>
	</div>
  <div class="field-group">
		<div><label for="login">Weight</label></div> <!-- int(11)?-->
		<div><input name="weight" type="number" class="input-field" min="0" max="400" pattern="^\d*(\.\d{0,2})?$" step="0.01" maxlength="5" required> </div>
	</div>
	<div class="field-group">
		<div><label for="login">Height</label></div> <!-- might need to change.db uses varchar(45). Is this in inches? Or mix of both?-->
		<div><input name="height" type="number" class="input-field" min="0" max="100" pattern="^\d*(\.\d{0,2})?$" step="0.01" max="3" required> </div>
	</div>
  <div class="field-group">
	  <div><label for="login">Birthday</label></div>
		<div><input name="birthday" type="date" class="input-field" required></div>
	</div>
  <div><input type="submit" name="register" value="Register" class="form-submit-button" ></span></div>
</div>       
</form>
</div>
</div>
</body></html>
