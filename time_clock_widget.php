
<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date Created: 8-18-2017
 * Last Update: 8-20-2017
 * Description: This is the file for the time clock widget.
 ***********************************************************/

include_once('database_functions.php');

?>
<html>

<link type="text/css" rel="stylesheet" href="css/time_clock_widget.css"> <!-- contains styles for the time clock widget. -->

<div class="widget_header">
	<h2>Time Clock</h2>
</div>

<div class="project_select" id="project_select">
Project: 

<?php 
$userGroupID = $_GET["userGroup"];

echo "<select id=\"project_select_field\" onchange=\"loadTasks()\">";

//echo "userGroupID = " . $userGroupID . "<br/>";
$projectArray = NULL;
$projectArray = getProjectsByUserGroup($userGroupID);
//echo "projectArray count = " . count($projectArray) . "<br/>";
for ($x = 1; $x <= count($projectArray); $x++) 
{
	$customerObject = NULL;
	$customerObject = getCustomerByID($projectArray[$x]->vars['customer_id']);
	echo '<option value="' . $projectArray[$x]->vars['id'] . '">' . $customerObject->vars['name'] . " - " . $projectArray[$x]->vars['name'] . '</option>';
}

?>
</select>
</div>
<br/>
<div class="task_select" id="task_select">
</div>
<br/>
<div class="start_stop_wrapper">
	<div class="start_time">
	Start<br/>
	<span id="start_time">00:00:00</span>
	<input type="hidden" id="start_datetime">
	</div>

	<div class="stop_time">
	Stop<br/>
	<span id="stop_time">00:00:00</span>
	<input type="hidden" id="stop_datetime">
	</div>
</div>
<br/>
<br/><br/>
<div class="clock_in_button_div">
	<button type="button" class="clock_in_button" id="clock_in_button" onclick="toggleClockedIn();">Clock In</button>
</div>
<div class="time_worked_counter">
	<span id="time_worked_counter_time">00:00:00</span>
</div>

<script>
var isClockedIn = 0;

//Get the datetime in MySQL format. Based on: https://stackoverflow.com/questions/42862729/convert-date-object-in-dd-mm-yyyy-hhmmss-format
function getDatetime() 
{
  var date = new Date(),
    year = date.getFullYear(),
    month = (date.getMonth() + 1).toString(),
    formatedMonth = (month.length === 1) ? ("0" + month) : month,
    day = date.getDate().toString(),
    formatedDay = (day.length === 1) ? ("0" + day) : day,
    hour = date.getHours().toString(),
    formatedHour = (hour.length === 1) ? ("0" + hour) : hour,
    minute = date.getMinutes().toString(),
    formatedMinute = (minute.length === 1) ? ("0" + minute) : minute,
    second = date.getSeconds().toString(),
    formatedSecond = (second.length === 1) ? ("0" + second) : second;
    return year + "-" + formatedMonth + "-" + formatedDay + " " + formatedHour + ':' + formatedMinute + ':' + formatedSecond;
};

function toggleClockedIn()
{
	console.log("toggleClockedIn called.");

	var clockInButton;
	clockInButton = document.getElementById('clock_in_button');
	
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();

	var datetime = getDatetime();
	
	if(isClockedIn == 0)
	{
		isClockedIn = 1;
		
		clockInButton.innerHTML = "Clock Out";
		
		document.getElementById('start_time').innerHTML = h + ":" + m + ":" + s;
		document.getElementById('start_datetime').value = datetime;
		document.getElementById('stop_time').innerHTML = "00:00:00";
		document.getElementById('stop_datetime').value = "";
		document.getElementById('time_worked_counter_time').innerHTML = "00:00:00";
		
		clearTimer();
		timer();
		
		//DEV NOTE: add code here to insert a new time record into the database with start datetime
	}
	else
	{
		isClockedIn = 0;
		
		clockInButton.innerHTML = "Clock In";
		
		document.getElementById('stop_time').innerHTML = h + ":" + m + ":" + s;
		document.getElementById('stop_datetime').value = datetime;
		
		stopTimer();
		
		logTimeWorked(); 
	}
	
}

//based in part on: https://jsfiddle.net/Daniel_Hug/pvk6p/
var h1 = document.getElementById('time_worked_counter_time');
var seconds = 0; 
var	minutes = 0; 
var	hours = 0;
var t;

function add() 
{
    seconds++;
    if (seconds >= 60) 
	{
        seconds = 0;
        minutes++;
        if (minutes >= 60) 
		{
            minutes = 0;
            hours++;
        }
    }
    
    h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);

    timer();
}

//start the timer
function timer() 
{
    t = setTimeout(add, 1000);
}

//stop the timer
function stopTimer() 
{
    clearTimeout(t);
}

//clear the timer
function clearTimer() 
{
    h1.textContent = "00:00:00";
    seconds = 0; minutes = 0; hours = 0;
}

function loadTasks()
{
	console.log("loadTasks function was called");
	
	var str = null;
	str = document.getElementById("project_select_field").value;
	
	if (str.length == 0) 
	{
        document.getElementById("task_select").innerHTML = "";
        return;
    } 
	else 
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("task_select").innerHTML = this.responseText;
			}
		}
		
		xmlhttp.open("GET", "task_select.php?projectID="+str, true);
		xmlhttp.send();
	}
}

//save the time worked into the database
function logTimeWorked() 
{
	var taskID = null;
	var startTime = null;
	var stopTime = null;
	var userGroupID = null;
	
	taskID = document.getElementById('timeTaskID').value;
	startTime = document.getElementById('start_datetime').value;
	stopTime = document.getElementById('stop_datetime').value;
	userGroupID = <?php echo $userGroupID; ?>;

	console.log("logStartTime function was called");
	console.log("taskID="+taskID);
	console.log("startTime="+startTime);
	console.log("stopTime="+stopTime);
	console.log("userGroupID="+userGroupID);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            console.log(this.responseText);
        }
    }
	
	//create a task
	xmlhttp.open("GET", "add_time_worked.php?timeTaskID="+taskID+"&timeStart="+startTime+"&timeStop="+stopTime+"&timeID="+userGroupID, true);
    xmlhttp.send();
	
}

window.onload = function()
{ 
    loadTasks();
}

</script>

</html>