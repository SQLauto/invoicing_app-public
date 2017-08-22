<?php

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
{
  echo "The current Linux user is: ";
  echo exec('whoami');
  echo "<br/>";
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled</strong><br/>";  
  echo "Start time: ";
  echo(date("Y-m-d H:i:s",$t));
  echo "<br/>";
}

// Start the session
session_start();

//debug, check the session
$user_id = "";
if(isset($_SESSION["user_id"]))
{
  $user_id = $_SESSION["user_id"];
  if($debugging == 1)
  {
    echo "session ID is set<br/>";
  }
}

if($debugging == 1)
{
  echo "<br/>";
  echo "The user_id is: " . $user_id;
  echo "<br/>";
}

//clear the cookie
//deleting cookies by setting expiration to past time
$res = setcookie('user_id', '', time() - 3600);
$res = setcookie('password_hash', '', time() - 3600);

//clear the session variables
session_unset(); 
session_destroy(); 

if($debugging == 1)
{
  echo "The user is signed out";
}

//debug, check the session
$user_id = "";
if(isset($_SESSION["user_id"]))
{
  $user_id = $_SESSION["user_id"];
  if($debugging == 1)
  {
    echo "session ID is set<br/>";
  }
}

if($debugging == 1)
{
  echo "<br/>";
  echo "The user_id is: " . $user_id;
  echo "<br/>";
}

//redirect the user to the home page
header('Location: index.php');
?>