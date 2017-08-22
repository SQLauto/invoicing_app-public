use invoicingapp;

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `employee_name` varchar(64) NOT NULL,
  `employee_title` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_logged` datetime DEFAULT NULL,
  `start_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `require_password_reset` tinyint(1) NOT NULL DEFAULT '0',
  `hourly_rate` DOUBLE DEFAULT NULL,
  `user_group` int(11) NOT NULL,
  is_voided tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
insert into `employees` (username,employee_name,email,start_date,password,user_group,employee_title,hourly_rate)
values
('mnutsch','Matt Nutsch','nutschm@oregonstate.edu','2017-03-09','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','1','Project Lead','100.00'),
('testing','John Doe','anonymous@oregonstate.edu','2017-03-09','$2y$10$pq0aXSGGEAmy6LEwnBcplOabFhK83g7ETZdnDEg9xdHFtSZC2sa7S','1','Code Monkey','35.00');


DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64),
address_street VARCHAR(32),
address_city VARCHAR(32),
address_state VARCHAR(32),
address_zip VARCHAR(64),
phone VARCHAR(64),
email VARCHAR(64),
contact_name VARCHAR(64),
created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
user_group_id INT(6),
payment_terms_id INT(6),
is_voided tinyint(1) NOT NULL DEFAULT '0'
);
insert into `customers` (name,address_street,address_city,address_state,address_zip,phone,email,contact_name,created_date,user_group_id,payment_terms_id)
values
('Acme Corp','135 Odd Street','Fort Worth','TX','76137','555-135-7913','noreply@email.com','Odd John','2017-01-03','1','1'),
('Jones Co','246 Even Blvd.','Fort Worth','TX','76137','555-246-8024','noreply@email.com','Even Joe','2016-02-04','1','1');


DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64),
description VARCHAR(512),
tax_rate VARCHAR(32),
customer_id VARCHAR(64),
created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
user_group_id INT(6),
is_voided tinyint(1) NOT NULL DEFAULT '0'
);
insert into `projects` (name,description,tax_rate,customer_id,user_group_id)
values
('New Acme Corp Website','Make a new website.','6.60','1','1'),
('Revamp Jones Co API','Rewrite an API.','6.60','2','1');


DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64),
description VARCHAR(512),
project_id VARCHAR(64),
created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
user_group_id INT(6),
is_voided tinyint(1) NOT NULL DEFAULT '0'
);

insert into `tasks` (name,description,project_id,user_group_id)
values
('Set up Wordpress','Install awesome theme.','1','1'),
('Update Ubuntu server','Use version 16.04.','2','1');


DROP TABLE IF EXISTS `time_worked`;

CREATE TABLE `time_worked` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
task_id VARCHAR(64),
start_time TIMESTAMP,
stop_time TIMESTAMP,
user_group_id INT(6),
invoice_id INT(6) DEFAULT NULL,
employee_id INT(6),
created_date TIMESTAMP,
is_voided tinyint(1) NOT NULL DEFAULT '0'
);

insert into `time_worked` (task_id,start_time,stop_time,user_group_id,employee_id)
values
('1','2017-03-10 12:00:01','2017-03-10 13:00:01','1','1'),
('2','2017-03-10 12:00:01','2017-03-10 13:00:01','1','1'),
('1','2017-03-11 12:00:01','2017-03-10 13:00:01','1','1'),
('2','2017-03-11 12:00:01','2017-03-10 13:00:01','1','1');


DROP TABLE IF EXISTS `invoice_headers`;

CREATE TABLE `invoice_headers` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
invoice_number VARCHAR(64),
customer_name VARCHAR(512),
address_street VARCHAR(64),
address_city VARCHAR(32),
address_state VARCHAR(32),
address_zip VARCHAR(32),
phone VARCHAR(32),
email VARCHAR(32),
contact_name VARCHAR(32),
project_name VARCHAR(32),
project_description VARCHAR(32),
project_id VARCHAR(32),
tax_rate VARCHAR(32),
customer_id VARCHAR(32),
created_date TIMESTAMP,
user_group_id INT(6),
payment_terms_id INT(6),
is_voided tinyint(1) NOT NULL DEFAULT '0'
);

insert into `invoice_headers` (invoice_number,customer_name,address_street,address_city,address_state,address_zip,phone,email,contact_name,project_name,project_description,project_id,tax_rate,customer_id,user_group_id, payment_terms_id)
values
('10001','Acme Corp','135 Odd Street','Fort Worth','TX','76137','555-135-7913','noreply@email.com','Odd John','New Acme Corp Website','Make a new website.','1','6.60','1','1','1'),
('10002','Jones Co','246 Even Blvd','Fort Worth','TX','76137','555-246-8024','noreply@email.com','Even Joe','Revamp Jones Co API','Rewrite an API.','2','6.60','2','1','1');


DROP TABLE IF EXISTS `invoice_line_items`;

CREATE TABLE `invoice_line_items` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
invoice_header_id INT(6),
start_time TIMESTAMP,
stop_time TIMESTAMP,
task_id VARCHAR(32),
employee_name VARCHAR(64),
employee_title VARCHAR(64),
hourly_rate VARCHAR(32),
task_name VARCHAR(64),
task_description VARCHAR(64),
created_date TIMESTAMP,
is_voided tinyint(1) NOT NULL DEFAULT '0'
);

insert into `invoice_line_items` (invoice_header_id,start_time,stop_time,task_id,employee_name,employee_title,hourly_rate,task_name,task_description,created_date)
values
('1','2017-03-10 12:00:01','2017-03-10 13:00:01','1','Matt Nutsch','Project Lead','100.00','Set up Wordpress','Install awesome theme.','2017-03-11 21:42:30'),
('2','2017-03-10 12:00:01','2017-03-10 13:00:01','2','Matt Nutsch','Project Lead','100.00','Update Ubuntu server','Use version 16.04.','2017-03-11 21:42:30');


DROP TABLE IF EXISTS `user_groups`;

CREATE TABLE `user_groups` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(64),
short_name VARCHAR(32),
default_payment_terms INT(6), 
remit_name VARCHAR(64),
remit_address_street VARCHAR(64),
remit_address_city VARCHAR(64),
remit_address_state VARCHAR(32),
remit_address_zip VARCHAR(16),
remit_phone VARCHAR(32),
remit_email VARCHAR(64),
default_invoice_message_1 VARCHAR(64),
default_invoice_message_2 VARCHAR(64),
created_date TIMESTAMP,
is_voided tinyint(1) NOT NULL DEFAULT '0'
);

insert into `user_groups` (full_name, short_name, default_payment_terms, remit_name, remit_address_street, remit_address_city, remit_address_state, remit_address_zip, remit_phone, remit_email, default_invoice_message_1, default_invoice_message_2, is_voided)
values 
('Nutsch Consulting', 'Nutsch Consulting', 1, 'Matthew Nutsch', '5712 Rio Grande Drive', 'Haltom City', 'TX', '76137', '253-961-2914', 'matt@nutschconsulting.com', 'Thank you!', 'It is a pleasure working with you.', 0);


DROP TABLE IF EXISTS `payment_terms`;

CREATE TABLE `payment_terms` (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
long_name VARCHAR(64),
short_name VARCHAR(16),
due_days_plus INT(6),
due_months_plus INT(6),
due_day_of_month INT(6),
use_day_of_month BOOLEAN NOT NULL DEFAULT '0',
created_date TIMESTAMP,
is_voided TINYINT(1) NOT NULL DEFAULT '0'
);

insert into `payment_terms` (long_name, short_name, due_days_plus, due_months_plus, due_day_of_month, use_day_of_month, is_voided)
values
('10 Days', '10 Days', 10, 0, 0, 0, 0);
insert into `payment_terms` (long_name, short_name, due_days_plus, due_months_plus, due_day_of_month, use_day_of_month, is_voided)
values
('30 Days', '30 Days', 30, 0, 0, 0, 0);
insert into `payment_terms` (long_name, short_name, due_days_plus, due_months_plus, due_day_of_month, use_day_of_month, is_voided)
values
('1 Month', '1 Month', 0, 1, 0, 0, 0);
insert into `payment_terms` (long_name, short_name, due_days_plus, due_months_plus, due_day_of_month, use_day_of_month, is_voided)
values
('Net 15th', 'Net 15th', 0, 0, 15, 1, 0);
