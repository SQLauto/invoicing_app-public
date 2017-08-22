<?php

/***********************************************************
 * Author: Matt Nutsch
 * Date: 8/13/2017
 * Last Updated: 8-15-2017
 * Description: Generates a PDF document for an invoice. 
 ***********************************************************/
 
//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$headerLeftWidth = 80;
$remitSpacerWidth = 10;
$remitContentWidth = 80;

$headerLabelHeight = 7;
$headerContentHeight = 7;
$headerLabelWidth = 50;
$headerContentWidth = 50;

$bodyLabelHeight = 7;
$bodyContentHeight = 7;
$bodyLabelWidth = 60;
$bodyContentWidth = 60;

$invoiceMessageWidth1 = 20;
$invoiceMessageWidth2 = 80;

$datetime1 = NULL;
$datetime2 = NULL;
$interval = NULL;
$timeElapsed = NULL;

$taxRate = 0.00;		
$extendedPrice = 0.00;
$totalTimeWorked = 0.00;
$totalPrice = 0.00;
$taxAmount = 0.00;
$totalTaxAmount = 0.00;
$totalPriceWithTax = 0.00;

//display information if we are in debugging mode
if($debugging)
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled</strong><br/>";  
    echo "<br/>";
}

//include other files
require_once ('security.php'); //contains database connection functions for basic site interaction
require_once ('database_functions.php'); //contains database connection functions for specific functionality
require('fpdf181/fpdf.php'); //http://www.fpdf.org/

$mySQLConnection = connectToMySQL(); //requires security.php

	if ($_SERVER["REQUEST_METHOD"] == "GET") 
	{
	  //echo "the get was set<br/>";

	  //get values from the web form
	  //sanitize the user input
	  $invoice_id = test_input($_GET["invoice_id"]);

	  //echo "the user group ID is: " . $user_group_id . "<br/>";

	  $pdf = new FPDF();
	  $pdf->AliasNbPages();
	  $pdf->AddPage();
	  
	  $sql = "SELECT * FROM invoice_headers LEFT JOIN customers ON invoice_headers.customer_id = customers.id WHERE invoice_headers.id = '$invoice_id' AND invoice_headers.is_voided = '0' LIMIT 1";
	  
	  $result =  $mySQLConnection->query($sql); //direct SQL method
	  
	  while($row = $result->fetch_array())
	  {
		  $userGroupObject = getUserGroupByID($row[16]);
		  $paymentTermsObject = getPaymentTermsByID($row[17]);
		  
		  $invoiceDate = date_create($row[15]);
		  $dueDate = date_create($row[15]);
		  		  
		  if($paymentTermsObject->vars['use_day_of_month'] == 0)
		  {
			date_add($dueDate, date_interval_create_from_date_string(($paymentTermsObject->vars['due_days_plus'].' days')));
			date_add($dueDate, date_interval_create_from_date_string(($paymentTermsObject->vars['due_months_plus'].' months')));
		  }
		  else
		  {
		    $curMonth = date_format($invoiceDate, 'm');
		    $curYear  = date_format($invoiceDate, 'Y');
			$dueDate = date_create($curYear . "/" . $curMonth . "/" . $paymentTermsObject->vars['due_day_of_month']);
			date_add($dueDate, date_interval_create_from_date_string('1 month'));
		  }
		  
		  $taxRate = $row[13] / 100;
		  
		  $pdf->SetFillColor(255, 255, 255); //white
		  $pdf->SetTextColor(163, 163, 163); //gray
	      $pdf->SetFont('Arial','B',12);
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,$userGroupObject->vars['full_name']); //DEV NOTE: add company name here
		  //
		  $pdf->SetTextColor(0, 0, 0); //black
		  $pdf->SetFont('Arial','',12);
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Invoice Date: ',1,0,'R');
		  $pdf->Cell($headerContentWidth,$headerContentHeight,date_format($invoiceDate, 'm/d/Y'),1,0,'R');
		  $pdf->Ln();
		  
		  $pdf->SetFont('Arial','B',20);
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,'Invoice');
		  //
		  $pdf->SetFont('Arial','',12);
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Due Date: ',1,0,'R');
		  $pdf->SetFillColor(255, 250, 95); //yellow
		  $pdf->Cell($headerContentWidth,$headerContentHeight,date_format($dueDate, 'm/d/Y'),1,0,'R',true);
		  $pdf->SetFillColor(255, 255, 255); //white
		  $pdf->Ln();
		  
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,'');
		  //
		  $pdf->SetFont('Arial','',12);
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Payment Terms: ',1,0,'R');
		  $pdf->Cell($headerContentWidth,$headerContentHeight,$paymentTermsObject->vars['short_name'],1,0,'R');
		  $pdf->Ln();
		  
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,'');
		  //
		  $pdf->SetFont('Arial','',12);
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Invoice #: ',1,0,'R');
		  $pdf->SetFont('Arial','B',12);
		  $pdf->Cell($headerContentWidth,$headerContentHeight,$row[1],1,0,'R');
		  $pdf->Ln();
		  
		  $pdf->Ln();
		  $pdf->Ln();
		  
		  $pdf->SetTextColor(163, 163, 163); //gray
		  $pdf->SetFont('Arial','B',12);
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,'CLIENT DETAILS:');	
		  $pdf->Cell($remitSpacerWidth,$headerLabelHeight,'');
		  $pdf->Cell($remitContentWidth,$headerLabelHeight,'PAY TO:');		  
		  $pdf->Ln();
		  $pdf->SetTextColor(0, 0, 0); //black
		  $pdf->SetFont('Arial','',12);
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,$row[2]);	//customer name
		  $pdf->Cell($remitSpacerWidth,$headerLabelHeight,'');
		  $pdf->Cell($remitContentWidth,$headerLabelHeight,$userGroupObject->vars['remit_name']);
		  $pdf->Ln();
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,$row[3]); //customer street
		  $pdf->Cell($remitSpacerWidth,$headerLabelHeight,'');
		  $pdf->Cell($remitContentWidth,$headerLabelHeight,$userGroupObject->vars['remit_address_street']);
		  $pdf->Ln();
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,$row[4] . ', ' . $row[5] . ', ' . $row[6]);	//customer city, st, zip
		  $pdf->Cell($remitSpacerWidth,$headerLabelHeight,'');
		  $pdf->Cell($remitContentWidth,$headerLabelHeight,$userGroupObject->vars['remit_address_city'] . ", " . $userGroupObject->vars['remit_address_state'] . ", " . $userGroupObject->vars['remit_address_zip']);
		  $pdf->Ln();
		  $pdf->Ln();
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,$row[7]);	
		  $pdf->Cell($remitSpacerWidth,$headerLabelHeight,'');
		  $pdf->Cell($remitContentWidth,$headerLabelHeight,$userGroupObject->vars['remit_phone']);
		  $pdf->Ln();
		  $pdf->Cell($headerLeftWidth,$headerLabelHeight,$row[8]);	
		  $pdf->Cell($remitSpacerWidth,$headerLabelHeight,'');
		  $pdf->Cell($remitContentWidth,$headerLabelHeight,$userGroupObject->vars['remit_email']);
		  
		  $pdf->Ln();
		  $pdf->Ln();
		  
		  $pdf->SetFont('Arial','',10);
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Project ID: ',1);
		  $pdf->Cell($headerContentWidth,$headerContentHeight,$row[12],1);
		  $pdf->Ln();
		  
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Project Name: ',1);
		  $pdf->Cell($headerContentWidth,$headerContentHeight,$row[10],1);
		  $pdf->Ln();
		  
		  $pdf->Cell($headerLabelWidth,$headerLabelHeight,'Project Description: ',1);
		  $pdf->Cell($headerContentWidth,$headerContentHeight,$row[11],1);
		  $pdf->Ln();
		  
	  }
	  
	  $pdf->Ln();
	  
	  $sql2 = "SELECT * FROM invoice_line_items WHERE invoice_header_id = '$invoice_id' AND is_voided = '0'"; //direct SQL method
	  $result2 =  $mySQLConnection->query($sql2); //direct SQL method
	  
	  $pdf->SetFont('Arial','B',9);
	  
	  $pdf->Cell(8,$bodyLabelHeight,'#',1);
      $pdf->Cell(46,$bodyLabelHeight,'Task Name',1);
      $pdf->Cell(20,$bodyLabelHeight,'Hourly Rate',1);
      $pdf->Cell(34,$bodyLabelHeight,'Start Time',1);
      $pdf->Cell(34,$bodyLabelHeight,'Stop Time',1);
      $pdf->Cell(28,$bodyLabelHeight,'Time Worked',1);
      $pdf->Cell(20,$bodyLabelHeight,'Ext. Price',1);
        
	  $pdf->Ln();
	  
	  /*
	  echo "<table style='width:90%'>" . 
	  "<tr>" . 
		"<th>ID</th>" . 
		"<th>Task Name</th>" . 
		"<th>Task Description</th>" . 
		"<th>Employee Name</th>" . 
		"<th>Hourly Rate</th>" . 
		"<th>Start Time</th>" . 
		"<th>Stop Time</th>" . 
	  "</tr>";
	  */
	  
	  $pdf->SetFont('Arial','',9);
	  while($row2 = $result2->fetch_array())
	  {
	  
		$datetime1 = strtotime($row2[2]);
		$datetime2 = strtotime($row2[3]);
		$interval = abs($datetime2 - $datetime1);
		$timeElapsed = round($interval / 60);
		
		$totalTimeWorked = $totalTimeWorked + $timeElapsed;
		
		$extendedPrice = ($row2[7] / 60) * $timeElapsed;
		
		$taxAmount = $extendedPrice * $taxRate;
		$totalTaxAmount = $totalTaxAmount + $taxAmount;
		
		$totalPrice = $totalPrice + $extendedPrice;
		
		$pdf->Cell(8,$bodyLabelHeight,$row2[0],1);
        $pdf->Cell(46,$bodyLabelHeight,$row2[8],1);
        $pdf->Cell(20,$bodyLabelHeight,$row2[7],1);
        $pdf->Cell(34,$bodyLabelHeight,$row2[2],1);
        $pdf->Cell(34,$bodyLabelHeight,$row2[3],1);
        $pdf->Cell(28,$bodyLabelHeight,$timeElapsed . " minutes",1);
        $pdf->Cell(20,$bodyLabelHeight,"$" . round($extendedPrice,2),1);
        
	    $pdf->Ln();

		/*
		echo "<tr><form>" .
		"<td>" . $row2[0] . "</td>" .
		"<td>" . $row2[8] . "</td>" .
		"<td>" . $row2[9] . "</td>" .
		"<td>" . $row2[5] . "</td>" .
		"<td>" . $row2[7] . "</td>" .
		"<td>" . $row2[2] . "</td>" .
		"<td>" . $row2[3] . "</td>" .
		"</form></tr>";
		*/
	  }
	  
	  //tax line
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(8,$bodyLabelHeight,'',1);
      $pdf->Cell(46,$bodyLabelHeight,'Tax',1);
      $pdf->Cell(20,$bodyLabelHeight,'',1);
      $pdf->Cell(34,$bodyLabelHeight,'',1);
      $pdf->Cell(34,$bodyLabelHeight,'',1);
      $pdf->Cell(28,$bodyLabelHeight,'',1);
      $pdf->Cell(20,$bodyLabelHeight,"$" . round($totalTaxAmount,2),1);
	  $pdf->Ln();
	  
	  //total line
	  $totalPriceWithTax = $totalPrice + $totalTaxAmount;
	  $pdf->SetFont('Arial','B',9);
	  $pdf->Cell(8,$bodyLabelHeight,'',1);
      $pdf->Cell(46,$bodyLabelHeight,'Total',1);
      $pdf->Cell(20,$bodyLabelHeight,'',1);
      $pdf->Cell(34,$bodyLabelHeight,'',1);
      $pdf->Cell(34,$bodyLabelHeight,'',1);
      $pdf->Cell(28,$bodyLabelHeight,$totalTimeWorked,1);
      $pdf->Cell(20,$bodyLabelHeight,"$" . round($totalPriceWithTax,2),1);
	  $pdf->Ln();
	  
	  $pdf->SetFont('Arial','I',10);
	  $pdf->SetTextColor(0, 0, 0); //black
	  $pdf->Cell($invoiceMessageWidth1,$headerLabelHeight,$userGroupObject->vars['default_invoice_message_1']);
	  $pdf->SetTextColor(163, 163, 163); //gray
	  $pdf->Cell($invoiceMessageWidth2,$headerLabelHeight,$userGroupObject->vars['default_invoice_message_2']);
	  
	  $pdf->Output();
	}

 
 ?>