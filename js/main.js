
/***********************************************************
 * Author: Matt Nutsch
 * Date Created: 6-26-2017
 * Last Update: 8-20-2017
 * Description: This is the primary JavaScript file for the app. 
 ***********************************************************/

/*
function setColor(button) 
{	
	document.getElementById(button).style.background-color: #4CAF50;
	return1;
}
*/

function showHome() 
{
	//alert("show home function was called");
	
	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("home").innerHTML = "";
        return;
    } 
	else 
	{
        
		//unhide Home
		document.getElementById('home').style.display = 'block';
		
		//hide everything else
		//document.getElementById('home').style.display = 'none';
		document.getElementById('customers').style.display = 'none';
		document.getElementById('projects').style.display = 'none';
		document.getElementById('tasks').style.display = 'none';
		document.getElementById('time_worked').style.display = 'none';
		document.getElementById('invoices').style.display = 'none';
		document.getElementById('employees').style.display = 'none';
    }
	
}

function showCustomers() 
{
	//alert("show customers function was called");

	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("customersContent").innerHTML = "";
        return;
    } 
	else 
	{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById("customersContent").innerHTML = this.responseText;
            }
        }
		
		//unhide Customers
		document.getElementById('customers').style.display = 'block';
		
		//get the content
        xmlhttp.open("GET", "get_customers.php?user_group_id="+userGroupID, true);
        xmlhttp.send();
		
		//hide everything else
		document.getElementById('home').style.display = 'none';
		//document.getElementById('customers').style.display = 'none';
		document.getElementById('projects').style.display = 'none';
		document.getElementById('tasks').style.display = 'none';
		document.getElementById('time_worked').style.display = 'none';
		document.getElementById('invoices').style.display = 'none';
		document.getElementById('employees').style.display = 'none';

    }
	
}

function showProjects() 
{
	//alert("show projects function was called");
	
	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("projectsContent").innerHTML = "";
        return;
    } 
	else 
	{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById("projectsContent").innerHTML = this.responseText;
            }
        }

		//unhide Projects
		document.getElementById('projects').style.display = 'block';
		
        xmlhttp.open("GET", "get_projects.php?user_group_id="+userGroupID, true);
        xmlhttp.send();
		
		//hide everything else
		document.getElementById('home').style.display = 'none';
		document.getElementById('customers').style.display = 'none';
		//document.getElementById('projects').style.display = 'none';
		document.getElementById('tasks').style.display = 'none';
		document.getElementById('time_worked').style.display = 'none';
		document.getElementById('invoices').style.display = 'none';
		document.getElementById('employees').style.display = 'none';

    }
	
}

function showTasks() 
{
	//alert("show tasks function was called");

	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("tasksContent").innerHTML = "";
        return;
    } 
	else 
	{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById("tasksContent").innerHTML = this.responseText;
            }
        }
		
		//unhide Tasks
		document.getElementById('tasks').style.display = 'block';
		
        xmlhttp.open("GET", "get_tasks.php?user_group_id="+userGroupID, true);
        xmlhttp.send();
		
		//hide everything else
		document.getElementById('home').style.display = 'none';
		document.getElementById('customers').style.display = 'none';
		document.getElementById('projects').style.display = 'none';
		//document.getElementById('tasks').style.display = 'none';
		document.getElementById('time_worked').style.display = 'none';
		document.getElementById('invoices').style.display = 'none';
		document.getElementById('employees').style.display = 'none';

    }
	
}

function showTimeWorked() 
{
	//alert("show timeWorked function was called");

	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("timeWorkedContent").innerHTML = "";
        return;
    } 
	else 
	{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById("timeWorkedContent").innerHTML = this.responseText;
            }
        }
		
		//unhide Time Worked
		document.getElementById('time_worked').style.display = 'block';
		
        xmlhttp.open("GET", "get_time_worked.php?user_group_id="+userGroupID, true);
        xmlhttp.send();
		
		//hide everything else
		document.getElementById('home').style.display = 'none';
		document.getElementById('customers').style.display = 'none';
		document.getElementById('projects').style.display = 'none';
		document.getElementById('tasks').style.display = 'none';
		//document.getElementById('time_worked').style.display = 'none';
		document.getElementById('invoices').style.display = 'none';
		document.getElementById('employees').style.display = 'none';

    }
	
}

function showInvoices() 
{
	//alert("show invoices function was called");

	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("invoicesContent").innerHTML = "";
        return;
    } 
	else 
	{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById("invoicesContent").innerHTML = this.responseText;
            }
        }
		
		//unhide Invoices
		document.getElementById('invoices').style.display = 'block';
		
        xmlhttp.open("GET", "get_invoices.php?user_group_id="+userGroupID, true);
        xmlhttp.send();
		
		//hide everything else
		document.getElementById('home').style.display = 'none';
		document.getElementById('customers').style.display = 'none';
		document.getElementById('projects').style.display = 'none';
		document.getElementById('tasks').style.display = 'none';
		document.getElementById('time_worked').style.display = 'none';
		//document.getElementById('invoices').style.display = 'none';
		document.getElementById('employees').style.display = 'none';

    }
	
}

function showEmployees() 
{
	//alert("show employees function was called");

	var userGroup = document.getElementById('company_select_field');
	var userGroupID = userGroup.options[userGroup.selectedIndex].value;
	
    if (userGroupID.length == 0) 
	{
        document.getElementById("employeesContent").innerHTML = "";
        return;
    } 
	else 
	{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById("employeesContent").innerHTML = this.responseText;
            }
        }
		
		//unhide Employees
		document.getElementById('employees').style.display = 'block';
		
        xmlhttp.open("GET", "get_employees.php?user_group_id="+userGroupID, true);
        xmlhttp.send();
		
		//hide everything else
		document.getElementById('home').style.display = 'none';
		document.getElementById('customers').style.display = 'none';
		document.getElementById('projects').style.display = 'none';
		document.getElementById('tasks').style.display = 'none';
		document.getElementById('time_worked').style.display = 'none';
		document.getElementById('invoices').style.display = 'none';
		//document.getElementById('employees').style.display = 'none';

    }
	
}

//update the content on window load
window.onload = function()
{
	document.getElementById('home').style.display = 'block';
	
	document.getElementById('customers').style.display = 'none';
	document.getElementById('projects').style.display = 'none';
	document.getElementById('tasks').style.display = 'none';
	document.getElementById('time_worked').style.display = 'none';
	document.getElementById('invoices').style.display = 'none';
	document.getElementById('employees').style.display = 'none';

}

//void customer
function voidCustomer(group_id, customer_id) 
{
	//alert("void customers function was called");
	
	var userGroupID = document.getElementById('company_select_field');
	
	var confirmValue = false;
	confirmValue = confirm("Are you sure?");
	
	if(confirmValue == true)
	{
		if (group_id.length == 0) 
		{
			document.getElementById("customersContent").innerHTML = "";
			return;
		} 
		else 
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					document.getElementById("customersContent").innerHTML = this.responseText;
				}
			}
			
			//unhide Customers - this should be unnecessary
			document.getElementById('customers').style.display = 'block';
			
			//get the content
			xmlhttp.open("GET", "void_customer.php?user_group_id="+group_id+"&customer_id="+customer_id, true);
			xmlhttp.send();
			
			//hide everything else - this should be unnecessary
			document.getElementById('home').style.display = 'none';
			//document.getElementById('customers').style.display = 'none';
			document.getElementById('projects').style.display = 'none';
			document.getElementById('tasks').style.display = 'none';
			document.getElementById('time_worked').style.display = 'none';
			document.getElementById('invoices').style.display = 'none';
			document.getElementById('employees').style.display = 'none';

		}
	}
}

//void project
function voidProject(group_id, project_id) 
{
	//alert("void project function was called");

	var userGroupID = document.getElementById('company_select_field');

	var confirmValue = false;
	confirmValue = confirm("Are you sure?");
	
	if(confirmValue == true)
	{
		if (group_id.length == 0) 
		{
			document.getElementById("projectsContent").innerHTML = "";
			return;
		} 
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					document.getElementById("projectsContent").innerHTML = this.responseText;
				}
			}
			
			//unhide Projects - this should be unnecessary
			document.getElementById('projects').style.display = 'block';
			
			//get the content
			xmlhttp.open("GET", "void_project.php?user_group_id="+group_id+"&project_id="+project_id, true);
			xmlhttp.send();
			
			//hide everything else - this should be unnecessary
			document.getElementById('home').style.display = 'none';
			document.getElementById('customers').style.display = 'none';
			//document.getElementById('projects').style.display = 'none';
			document.getElementById('tasks').style.display = 'none';
			document.getElementById('time_worked').style.display = 'none';
			document.getElementById('invoices').style.display = 'none';
			document.getElementById('employees').style.display = 'none';

		}
	}
}

//void task
function voidTask(group_id, task_id) 
{
	//alert("void task function was called");
	var confirmValue = false;
	confirmValue = confirm("Are you sure?");

	var userGroupID = document.getElementById('company_select_field');
	
	if(confirmValue == true)
	{
		if (group_id.length == 0) 
		{
			document.getElementById("tasksContent").innerHTML = "";
			return;
		} 
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					document.getElementById("tasksContent").innerHTML = this.responseText;
				}
			}
			
			//unhide Tasks - this should be unnecessary
			document.getElementById('tasks').style.display = 'block';
			
			//get the content
			xmlhttp.open("GET", "void_task.php?user_group_id="+group_id+"&task_id="+task_id, true);
			xmlhttp.send();
			
			//hide everything else - this should be unnecessary
			document.getElementById('home').style.display = 'none';
			document.getElementById('customers').style.display = 'none';
			document.getElementById('projects').style.display = 'none';
			//document.getElementById('tasks').style.display = 'none';
			document.getElementById('time_worked').style.display = 'none';
			document.getElementById('invoices').style.display = 'none';
			document.getElementById('employees').style.display = 'none';

		}
	}
}

//void time worked
function voidTimeWorked(group_id, time_worked_id) 
{
	//alert("void time worked function was called");

	var userGroupID = document.getElementById('company_select_field');

	var confirmValue = false;
	confirmValue = confirm("Are you sure?");
	
	if(confirmValue == true)
	{
		if (group_id.length == 0) 
		{
			document.getElementById("timeWorkedContent").innerHTML = "";
			return;
		} 
		else
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					document.getElementById("timeWorkedContent").innerHTML = this.responseText;
				}
			}
			
			//unhide Time Worked - this should be unnecessary
			document.getElementById('time_worked').style.display = 'block';
			
			//get the content
			xmlhttp.open("GET", "void_time_worked.php?user_group_id="+group_id+"&time_worked_id="+time_worked_id, true);
			xmlhttp.send();
			
			//hide everything else - this should be unnecessary
			document.getElementById('home').style.display = 'none';
			document.getElementById('customers').style.display = 'none';
			document.getElementById('projects').style.display = 'none';
			document.getElementById('tasks').style.display = 'none';
			//document.getElementById('time_worked').style.display = 'none';
			document.getElementById('invoices').style.display = 'none';
			document.getElementById('employees').style.display = 'none';

		}
	}
}

//open an invoice in a new tab
function openInvoicePDF()
{
	//console.log("DEBUG: openInvoicePDF function called!");

	var invoiceID = document.getElementById('chooseInvoice');
	
	console.log(invoiceID.options[invoiceID.selectedIndex].value);
	
    if (invoiceID.selectedIndex == "")
	{
        alert("Please select an invoice from the drop down menu.");
	}
	else
	{
		window.open("generate_invoice_pdf.php?invoice_id=" + invoiceID.options[invoiceID.selectedIndex].value);
	}
}

//open the time clock widget
function openTimeClock()
{

	var companyID = document.getElementById('company_select_field');
	
	console.log(companyID.value);

	window.open('time_clock_widget.php?userGroup='+companyID.value,'mywindow','menubar=1,resizable=1,width=350,height=250');
}

