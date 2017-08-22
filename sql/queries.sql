#Matt Nutsch
#CS340
#database interaction queries

#add_customer.php
#inserts a new customer record
#This is used when adding a new customer through the Customers tab.
#$sql = "INSERT INTO customers " . 
#	"(name, address_street, address_city, address_state, address_zip, phone, email, contact_name, user_group_id)" .
#	"VALUES ('" . $insertName .  "','" . $insertAddressStreet .  "','" . $insertAddressCity .  "','" . $insertAddressState .  "','" . $insertAddressZip .  "','" . $insertPhone .  "','" . $insertEmail .  "','" . $insertContactName .  "','" . $insertUserGroupID .  "')";

INSERT INTO customers (name, address_street, address_city, address_state, address_zip, phone, email, contact_name, user_group_id) VALUES ('[$insertName','[$insertAddressStreet','[$insertAddressCity','[$insertAddressState','[$insertAddressZip','[$insertPhone','[$insertEmail','[$insertContactName','[$insertUserGroupID');

	
#add_project.php
#inserts a new project record
#This is used when adding a new project through the Projects tab.
#$sql = "INSERT INTO projects " . 
#	"(name, description, tax_rate, customer_id, user_group_id)" .
#	"VALUES ('" . $insertName .  "','" . $insertDescription .  "','" . $insertTaxRate .  "','" . $insertCustomerID .  "','" . $insertUserGroupID .  "')";

INSERT INTO projects (name, description, tax_rate, customer_id, user_group_id) VALUES ('[$insertName]','[$insertDescription]','[$insertTaxRate]','[$insertCustomerID]','[$insertUserGroupID]');

	
#add_task.php
#inserts a new task
#This is used to add a new record in the Tasks tab.
#$sql = "INSERT INTO tasks " . 
#	"(name, description, project_id, user_group_id)" .
#	"VALUES ('" . $insertName .  "','" . $insertDescription .  "','" . $insertProjectID .  "','" . $insertUserGroupID .  "')";

INSERT INTO tasks (name, description, project_id, user_group_id) VALUES ('[$insertName]','[$insertDescription]','[$insertProjectID]','[$insertUserGroupID]');
	

#add_time_worked.php
#inserts a new time worked entry
#This is used to add a new record in the Time Worked tab.
#$sql = "INSERT INTO time_worked " . 
#	"(task_id, start_time, stop_time, user_group_id)" .
#	"VALUES ('" . $insertTaskID .  "','" . $insertStart .  "','" . $insertStop .  "','" . $insertUserGroupID .  "')";

INSERT INTO time_worked (task_id, start_time, stop_time, user_group_id) VALUES ('[$insertTaskID]','[$insertStart]','[$insertStop]','[$insertUserGroupID]');
	
	
#delete_customer.php query # 1
#deletes an entry from the database
#This is used to delete a record in the Customers tab.
#$sql2 = "DELETE FROM customers WHERE id = '$customer_id'"; //direct SQL method

DELETE FROM customers WHERE id = '[$customer_id';
	  

#delete_customer.php query # 2
#displays customers from the database after the deletion
#This is used to list records in the Customers tab when refreshing after deleting a record.
#$sql = "SELECT * FROM customers WHERE user_group_id = '$user_group_id'"; //direct SQL method
	
SELECT * FROM customers WHERE user_group_id = '[$user_group_id]';


#get_customers.php
#displays customers from the database
#This is used to list records in the Customers tab during the initial page load.
#$sql = "SELECT * FROM customers WHERE user_group_id = '$user_group_id'"; //direct SQL method
	
SELECT * FROM customers WHERE user_group_id = '[$user_group_id]';

	
#get_projects.php
#displays projects from the database
#This is used to list records in the Projects tab.
#$sql = "SELECT * FROM projects WHERE user_group_id = '$user_group_id'"; //direct SQL method

SELECT * FROM projects WHERE user_group_id = '[$user_group_id]';


#get_tasks.php
#displays tasks from the database
#This is used to list records in the Tasks tab.
#$sql = "SELECT * FROM tasks WHERE user_group_id = '$user_group_id'"; //direct SQL method

SELECT * FROM tasks WHERE user_group_id = '[$user_group_id]';


#get_time_worked.php
#displays time worked records from the database
#This is used to list records in the Time Worked tab.
#$sql = "SELECT * FROM time_worked WHERE user_group_id = '$user_group_id'"; //direct SQL method

SELECT * FROM time_worked WHERE user_group_id = '[$user_group_id]';


#get_invoices.php query # 1
#displays invoice header information where a time worked record exists
#This is used in a <select> drop down for the user to select a project to generate an invoice..
#$sql = "SELECT * " .
#		"FROM time_worked " .
#		"LEFT JOIN tasks ON time_worked.task_id = tasks.id " .
#		"LEFT JOIN projects ON tasks.project_id = projects.id " .
#		"LEFT JOIN customers ON projects.customer_id = customers.id " .
#		"WHERE time_worked.user_group_id = '$user_group_id'" .
#		"GROUP BY customers.name, projects.name;"; //direct SQL method

SELECT * 
FROM time_worked 
LEFT JOIN tasks ON time_worked.task_id = tasks.id 
LEFT JOIN projects ON tasks.project_id = projects.id 
LEFT JOIN customers ON projects.customer_id = customers.id 
WHERE time_worked.user_group_id = '[$user_group_id]'
GROUP BY customers.name, projects.name;


#get_invoices.php query # 2
#displays invoice header information.
#This is used in a <select> drop down for the user to choose invoice records.
#$sql = "SELECT * FROM invoice_headers WHERE user_group_id = '$user_group_id'"; //direct SQL method

SELECT * FROM invoice_headers WHERE user_group_id = '[$user_group_id]';

#get_employees.php 
#displays employees on the same team
#This is used to display the content on the initial employees tab.
#$sql = "SELECT * FROM employees WHERE user_group = '$user_group_id'"; //direct SQL method

SELECT * FROM employees WHERE user_group = '[$user_group_id]';


#get_invoice_detail.php query # 1
#displays invoice header information on a selected invoice
#This is used to display detailed invoice information when the user selects a specific invoice.
#$sql = "SELECT * FROM invoice_headers WHERE id = '$invoice_id'"; //direct SQL method

SELECT * FROM invoice_headers WHERE id = '[$invoice_id]';


#get_invoice_detail.php query # 2
#displays invoice line item information on a selected invoice
#This is used to display detailed invoice information when the user selects a specific invoice.
#$sql2 = "SELECT * FROM invoice_line_items WHERE invoice_header_id = '$invoice_id'"; //direct SQL method

SELECT * FROM invoice_line_items WHERE invoice_header_id = '[$invoice_id]';


#security.php query # 1
#inserts a new record into the employee table
#This will be used when a new user account is created.
#$sql = "INSERT INTO $table_name (username, employee_name, employee_title, email, password, last_logged, start_date, is_active, require_password_reset, hourly_rate, user_group)VALUES ('$username', '$employee_name', '$employee_title', '$email', '$password', '$last_logged', '$start_date', '$is_active', '$require_password_reset', '$hourly_rate', '$user_group')";

INSERT INTO employees (username, employee_name, employee_title, email, password, last_logged, start_date, is_active, require_password_reset, hourly_rate, user_group)VALUES ('[$username]', '[$employee_name]', '[$employee_title]', '[$email]', '[$password]', '[$last_logged]', '[$start_date]', '[$is_active]', '[$require_password_reset]', '[$hourly_rate]', '[$user_group]');


#security.php query # 2
#updates a record in the employee table by user ID
#This will be used when editing something about the user account, such as a password or email address.
#$sql = "UPDATE $table_name SET `username` = '$username', `employee_name` = '$employee_name', `employee_title` = '$employee_title', `email` = '$email', `password` = '$password', `last_logged` = '$last_logged', `start_date` = '$start_date', `is_active` = '$is_active', `require_password_reset` = '$require_password_reset', `hourly_rate` = '$hourly_rate', `user_group` = '$user_group' WHERE `id` = '$id';";

UPDATE employees SET `username` = '[$username]', `employee_name` = '[$employee_name]', `employee_title` = '[$employee_title]', `email` = '[$email]', `password` = '[$password]', `last_logged` = '[$last_logged]', `start_date` = '[$start_date]', `is_active` = '[$is_active]', `require_password_reset` = '[$require_password_reset]', `hourly_rate` = '[$hourly_rate]', `user_group` = '[$user_group]' WHERE `id` = '[$id]';
  

#security.php query # 3
#updates a record in the employee table by username
#This will be used when editing something about the user account, such as a password or email address.
#$sql = "UPDATE $table_name SET `username` = '$username', `employee_name` = '$employee_name', `employee_title` = '$employee_title', `email` = '$email', `password` = '$password', `last_logged` = '$last_logged', `start_date` = '$start_date', `is_active` = '$is_active', `require_password_reset` = '$require_password_reset', `hourly_rate` = '$hourly_rate', `user_group` = '$user_group' WHERE `username` = '$username';";

UPDATE employees SET `username` = '[$username]', `employee_name` = '[$employee_name]', `employee_title` = '[$employee_title]', `email` = '[$email]', `password` = '[$password]', `last_logged` = '[$last_logged]', `start_date` = '[$start_date]', `is_active` = '[$is_active]', `require_password_reset` = '[$require_password_reset]', `hourly_rate` = '[$hourly_rate]', `user_group` = '[$user_group]' WHERE `username` = '[$username]';
  

#security.php query # 4
#deletes a record from the employee table by ID
#This was primarily used for debugging during development.
#$sql = "DELETE FROM employees WHERE id=$id"; //direct SQL method

DELETE FROM employees WHERE id=[$id];


#security.php query # 5
#selects the user by id
#This is used when signing the customer in using a browser cookie and the "Remember Me" sign in feature.
#$sql = "SELECT * FROM $table_name WHERE id = '$userID' LIMIT 1"; 

SELECT * FROM employees WHERE id = '[$userID]' LIMIT 1;


#security.php query # 6
#selects the user by username
#This is used when signing the customer in using the sign in form.
#$sql = "SELECT * FROM $table_name WHERE username = '$username' LIMIT 1";

SELECT * FROM employees WHERE username = '[$username]' LIMIT 1;


#security.php query # 7
#selects all users
#This was primarily used for debugging during development.
#$sql = "SELECT * FROM $table_name";

SELECT * FROM employees;


#search_employees.php
#selects users which are similar to the search term
#This is used for searching for users of the application to invite to a team.

SELECT * FROM employees WHERE CONCAT(username,employee_name,employee_title) LIKE '%[matt]%' LIMIT 5;
