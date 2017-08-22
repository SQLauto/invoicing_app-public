<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date Created: 6/26/2017
 * Date Updated: 8-20-2017
 * Description: This is the header file for the app and contains 
 * user access functionality. 
 ***********************************************************/

// Start the session
if (!isset($_SESSION)) 
{
	session_start(); 
}

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

//display information if we are in debugging mode
if($debugging == 1)
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

//include other files
include_once('security.php'); //functions for interacting with the main_users table
include_once('database_functions.php');

// If the user is not logged AND has a cookie set, then try to automatically log them in
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != '')
{
  $username_input = filter_var($_COOKIE['user_id']);
  $password_input = filter_var($_COOKIE['password_hash']);
  
  //get user data from mysql
  $mySQLConn = connectToMySQL(); //connect to mysql, requires security.php

  //"Querying Database for the username..";
  $singleUserObject = getUser($username_input, $mySQLConn); //output details on a user, requires security.php
  
  //this is the hashed password from the database
  $hashedPassword = $singleUserObject->vars["password"];
  
  //if the password hash from the cookie and the password hash from the database match
  if($password_input == $hashedPassword)   
  {
    //then set the session variables
    $user_id = $singleUserObject->vars["id"];
    $_SESSION["user_id"] = $user_id;
	$user_group = $singleUserObject->vars["user_group"];
	$_SESSION["user_group"] = $user_id;
 	
    //header to reload the signed in home page
    header('Location: index.php');
  }
  else //if not authorized 
  {
    //The password in the cookie is not correct.
	//The user can click the sign in button to sign in manually.
  }
 
}


?>

<!-- HTML -->

<html>
  <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>
Invoicing App
    </title>	
    
	<script type="text/javascript" src="js/main.js"></script> <!-- contains JavaScript functionality for menu and navigation. -->    
    <script type="text/javascript" src="js/sign_in_form.js"></script> <!-- contains JavaScript functionality for sign in. -->    
    <link type="text/css" rel="stylesheet" href="css/sign_in_form.css"> <!-- contains styles for the CSS sign in/sign out modal dialogue box. -->
	<link type="text/css" rel="stylesheet" href="css/main.css"> <!-- contains styles for the page content. -->
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<link type="text/css" href="css/jquery.simple-dtpicker.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery.simple-dtpicker.js"></script>

  </head>
  
  <style>

  </style>
  
</html>

<body>

<div class="header_wrapper" style="min-height: 20%;">
  <div class="header_text">
    <h1>Invoicing App</h1>
	<h3>by Matt Nutsch</h3>
  </div>
  
  <div class="sign_in_out">
  
<?php
//If the user is already signed in according to a session variable
if(isset($_SESSION["user_id"])) 
{
  //then show them the sign out button
  echo("<button class=\"sign_out_button\" onclick=\"document.location.href='sign_out.php'\" style=\"width:auto;\">Sign Out</button>");
}
else
{
  //otherwise show them the sign in button
  echo("<button class=\"sign_in_button\" onclick=\"document.getElementById('id01').style.display='block'\" style=\"width:auto;\">Sign In</button>");
}

//if the user tried to sign in and there was an error
if (isset($_SESSION["signin_error_message"])) 
{
  //get the signin error message
  $signin_error_message = filter_var($_SESSION["signin_error_message"]);
  //get the session variables for error messages
  
  //get the username and password that the user tried
  $signin_wrong_username = filter_var($_SESSION["signin_wrong_username"]);
  $signin_wrong_password = filter_var($_SESSION["signin_wrong_password"]);
  
  echo "<script>"; //Start JavaScript
  echo "var js_signin_error_message = '" . $signin_error_message . "';";
  echo "var js_signin_wrong_username = '" . $signin_wrong_username . "';";
  echo "var js_signin_wrong_password = '" . $signin_wrong_password . "';";
  
  echo "console.log('JS is running');"; 
  
  //on page load (wait until all the other code runs)
  echo "window.onload = function()";
  echo "{";
	echo "console.log(js_signin_error_message);";
	echo "console.log(js_signin_wrong_username);";
	echo "console.log(js_signin_wrong_password);";
	
	//unhide the modal window
	echo "var modal = document.getElementById('id01');";
	echo "modal.style.display = 'block';";
	
	//add the error message to the modal window using javascript
    echo "document.getElementById('error_message_text').innerHTML = '" . $signin_error_message . "';";
  
    //add the username and password entries to the modal window using javascript
	echo "document.getElementById('username_input').value = '" . $signin_wrong_username . "';";
	echo "document.getElementById('password_input').value = '" . $signin_wrong_password . "';";
  
  echo "};";
  
  echo "</script>"; //end the JavaScript
  
  //unset the error message session variables so they don't accidentally show up again
  unset($_SESSION["signin_error_message"]);
  unset($_SESSION["signin_wrong_username"]);
  unset($_SESSION["signin_wrong_password"]);
  
}
?>
  </div>
  
  <div class="profile">
  
	<?php
	//If the user is already signed in according to a session variable
	if(isset($_SESSION["user_id"])) 
	{
	  //then show them the time clock button
	  echo("<button class=\"profile_button\" style=\"display:block;\" onclick=\"window.open('https://www.w3schools.com','mywindow','menubar=1,resizable=1,width=350,height=250');\">Profile</button>");
	}
	else
	{
	  //otherwise show them the time clock button
	  echo("<button class=\"profile_button\" style=\"display:none;\" onclick=\"window.open('https://www.w3schools.com','mywindow','menubar=1,resizable=1,width=350,height=250');\">Profile</button>");
	}
	?>
  
  </div>
  
  <div class="time_clock">
  
	<?php
	//If the user is already signed in according to a session variable
	if(isset($_SESSION["user_id"])) 
	{
	  //then show them the time clock button
	  echo("<button class=\"time_clock_button\" style=\"display:block;\" onclick=\"openTimeClock();\">Time Clock</button>");
	}
	else
	{
	  //otherwise show them the time clock button
	  echo("<button class=\"time_clock_button\" style=\"display:none;\" onclick=\"openTimeClock();\">Time Clock</button>");
	}
	?>
  
  </div>
  
</div>

<div class="company_select">

	<?php
	//If the user is already signed in according to a session variable
	if(isset($_SESSION["user_id"])) 
	{
	  $userGroupArray = getUserGroupsByUserID($_SESSION["user_id"]);
	  $userGroupObject = NULL;
	  echo "<select id='company_select_field'>";
	  for ($i = 1; $i <= count(userGroupArray); $i++) 
	  {
		$userGroupObject = getUserGroupByID($i);
	 	echo "The number is: $x <br>";
		echo '<option value="'. $i . '">' . $userGroupObject->vars['full_name'] . '</option>';
  	  } 
	  echo "</select>";
	}
	?>
</div>

<div class="topnav">
  <a href="javascript:showHome();">Home</a>
  <a href="javascript:showCustomers();">Customers</a>
  <a href="javascript:showProjects();">Projects</a>
  <a href="javascript:showTasks();">Tasks</a>
  <a href="javascript:showTimeWorked();">Time Worked</a>
  <a href="javascript:showInvoices();">Invoices</a>
  <a href="javascript:showEmployees();">Team</a>
</div>

<!-- This div is normally hidden. It appears when the Sign In button is clicked. -->
<div id="id01" class="modal">

  <form class="modal-content animate" method="post" action="sign_in.php">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
          <!-- uncomment this code to add an image on the sign in form -->
          <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->
        </div>

        <div class="container">
          <label><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="user_name" id="username_input" required>

          <label><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" id="password_input" required>
		  
		  <p id="error_message_text" style="color: red;"></p>

          <button type="submit">Login</button>
          <input type="checkbox" checked="checked" name="remember_me"> Remember me
        </div>

        <div class="container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
  </form>
</div>




