<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date Created: 6-26-2017
 * Last Update: 8-20-2017
 * Description: This is the primary file for the app. 
 ***********************************************************/

include 'header.php';

?>

<div id="home" style="padding: 0% 5%;">
<h2>Home</h2>

<span id='homeContent'>

<?php
//for debug
//echo("Server Document Root: " . filter_input(INPUT_SERVER,'DOCUMENT_ROOT',FILTER_SANITIZE_STRING) . "<br />"); //$_SERVER['DOCUMENT_ROOT']
//echo("dirname(__FILE__): " . dirname(__FILE__) . "<br />");

//Output the cookie and session info if in debug mode
if (!isset($_SESSION)) 
{
	session_start(); 
}

if (isset($_SESSION["user_id"])) 
{
	echo "You are signed in.<br/><br/>";
	echo "Session data:<br/>";
	echo "Your user ID = " . filter_var($_SESSION["user_id"]) . "<br/>";
	echo "Your user group = " . filter_var($_SESSION["user_group"]) . "<br/>";
	
	if (isset($_COOKIE['user_id'])) 
	{ 
		echo "<br/>";
		echo "Cookie data:<br/>";
		echo "The user ID in your browser cookie = " . filter_var($_COOKIE['user_id']) . "<br/>";
		//echo "Password Hash Cookie = " . filter_var($_COOKIE['password_hash']) . "<br/>";	
	}
}
else
{
	echo "<strong>Sign in with the username 'testing' and the password '12345'.<br/><br/>Click on the menu links to interact with the database.</strong>";
}
?>

</span>
</div>

<div id="customers" style="padding: 0% 5%;">
<h2>Customers</h2>
<span id="customersContent">Please sign in to continue.</span>
</div>

<div id="projects" style="padding: 0% 5%;">
<h2>Projects</h2>
<span id="projectsContent">Please sign in to continue.</span>
</div>

<div id="tasks" style="padding: 0% 5%;">
<h2>Tasks</h2>
<span id="tasksContent">Please sign in to continue.</span>
</div>

<div id="time_worked" style="padding: 0% 5%;">
<h2>Time Worked</h2>
<span id="timeWorkedContent">Please sign in to continue.</span>
</div>

<div id="invoices" style="padding: 0% 5%;">
<h2>Invoices</h2>
<span id="invoicesContent">Please sign in to continue.</span>
</div>

<div id="employees" style="padding: 0% 5%;">
<h2>Current Team Members</h2>
<span id="employeesContent">Please sign in to continue.</span>
</div>
	
</body>

<script>
//add a customer
function addCustomer() 
{
	//alert("add customers function was called");
	
	var custName = document.getElementById("custName").value;
	var custStreet = document.getElementById("custStreet").value;
	var custCity = document.getElementById("custCity").value;
	var custState = document.getElementById("custState").value;
	var custZip = document.getElementById("custZip").value;
	var custPhone = document.getElementById("custPhone").value;
	var custEmail = document.getElementById("custEmail").value;
	var custContact = document.getElementById("custContact").value;
	var custID = document.getElementById("custID").value;
	
	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
	//alert("add_customer.php?custName="+custName+"&custStreet="+custStreet+"&custCity="+custCity+"&custState="+custState+"&custZip="+custZip+"&custPhone="+custPhone+"&custEmail="+custEmail+"&custContact="+custContact+"&custID="+custID);
	
	//custName, custStreet, custCity, custState, custZip, custPhone, custEmail, custContact, custID
	
	//insert the values
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
		//don't display anything
    }
		
	//add the new customer to the database
    xmlhttp.open("GET", "add_customer.php?custName="+custName+"&custStreet="+custStreet+"&custCity="+custCity+"&custState="+custState+"&custZip="+custZip+"&custPhone="+custPhone+"&custEmail="+custEmail+"&custContact="+custContact+"&custID="+custID, true);
    xmlhttp.send();
	
	//**********************************************
	
	//update the values
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById("customersContent").innerHTML = this.responseText;
        }
    }
		
	//get the content
    xmlhttp2.open("GET", "get_customers.php?user_group_id="+userGroupID, true);
    xmlhttp2.send();
}	
		
//add a project
function addProject() 
{
	//alert("add projects function was called");
	
	var projName = document.getElementById("projName").value;
	var projDescription = document.getElementById("projDescription").value;
	var projTaxRate = document.getElementById("projTaxRate").value;
	var projCustomerID = document.getElementById("projCustomerID").value;
	var projID = document.getElementById("projID").value;
		
	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;	
		
	//insert the values
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
		//don't display anything
    }
		
	//add the new customer to the database
    xmlhttp.open("GET", "add_project.php?projName="+projName+"&projDescription="+projDescription+"&projTaxRate="+projTaxRate+"&projCustomerID="+projCustomerID+"&projID="+projID, true);
    xmlhttp.send();
	
	//**********************************************
	
	//update the values
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById("projectsContent").innerHTML = this.responseText;
        }
    }
		
	//get the content
    xmlhttp2.open("GET", "get_projects.php?user_group_id="+userGroupID, true);
    xmlhttp2.send();
	
}

//add a task
function addTask() 
{
	//alert("add tasks function was called");
	
	var taskName = document.getElementById("taskName").value;
	var taskDescription = document.getElementById("taskDescription").value;
	var taskProjectID = document.getElementById("taskProjectID").value;
	var taskID = document.getElementById("taskID").value;
		
	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
		
	//insert the values
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
		//don't display anything
    }
		
	//add the new customer to the database
    xmlhttp.open("GET", "add_task.php?taskName="+taskName+"&taskDescription="+taskDescription+"&taskProjectID="+taskProjectID+"&taskID="+taskID, true);
    xmlhttp.send();
	
	//**********************************************
	
	//update the values
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById("tasksContent").innerHTML = this.responseText;
        }
    }
		
	//get the content
    xmlhttp2.open("GET", "get_tasks.php?user_group_id="+userGroupID, true);
    xmlhttp2.send();
	
}

//add a time worked
function addTime() 
{
	//alert("add time worked function was called");
	
	var timeTaskID = document.getElementById("timeTaskID").value;
	var timeStart = document.getElementById("timeStart").value;
	var timeStop = document.getElementById("timeStop").value;
	var timeID = document.getElementById("timeID").value;
	
	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
		
	//insert the values
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
		//don't display anything
    }
		
	//add the new customer to the database
    xmlhttp.open("GET", "add_time_worked.php?timeTaskID="+timeTaskID+"&timeStart="+timeStart+"&timeStop="+timeStop+"&timeID="+timeID, true);
    xmlhttp.send();
	
	//**********************************************
	
	//update the values
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById("timeWorkedContent").innerHTML = this.responseText;
        }
    }
		
	//get the content
    xmlhttp2.open("GET", "get_time_worked.php?user_group_id="+userGroupID, true);
    xmlhttp2.send();
	
}

//display invoice information
function displayInvoiceInformation() 
{
	var invoiceConcat = document.getElementById("chooseInvoice").value;
	
	//alert('You selected an invoice to view.');
	//alert(invoiceConcat);
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById("invoiceDetail").innerHTML = this.responseText;
        }
    }
	
    xmlhttp.open("GET", "get_invoice_detail.php?invoice_id="+invoiceConcat, true);
    xmlhttp.send();
}

//search for employees
function searchForEmployees() 
{
	//alert("Search called");
	
	var search_term = document.getElementById("search_term").value;
	
	//alert(search_term);
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById("searchResults").innerHTML = this.responseText;
        }
    }
	
    xmlhttp.open("GET", "search_employees.php?search_term="+search_term, true);
    xmlhttp.send();
}

</script>
<script type="text/javascript">
$(document).on('click', "#timeStart", 
    function(){ 
        $.getScript("js/jquery.simple-dtpicker.js", function() 
		{ 
            setTimeout( function() 
			{ 
                $("#timeStart").appendDtpicker(
                {
					"dateFormat": "YYYY-MM-DD h:m:00",
                    "minuteInterval": 1,
                    "closeOnSelected": true,
                    "calendarMouseScroll": false
                }); 
            }, 100);
        });
});
$(document).on('click', "#timeStop", 
    function(){ 
        $.getScript("js/jquery.simple-dtpicker.js", function() 
		{ 
            setTimeout( function() 
			{ 
                $("#timeStop").appendDtpicker(
                {
					"dateFormat": "YYYY-MM-DD h:m:00",
                    "minuteInterval": 1,
                    "closeOnSelected": true,
                    "calendarMouseScroll": false
                }); 
            }, 100);
        });
});
</script>
</html>