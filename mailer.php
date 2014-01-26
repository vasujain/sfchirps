<?php
/**
 * Created by PhpStorm.
 * User: vasujain
 * Date: 1/21/14
 * Time: 6:17 PM
 */

$adminEmail = "vasu.jain@yahoo.com";
$formsDirectory = "forms/";

init();

/**
 * Initialize the email Data object
 */
function init() {
	$httpReferer = $_SERVER['HTTP_REFERER'];
	$emailData = new stdClass();
	$emailData->twitterhandle = $_POST['twitterhandle'];
	$emailData->name = $_POST['name'];
	$emailData->email = $_POST['email'];
	date_default_timezone_set('America/Los_Angeles');
	$emailData->date = date("Y-m-d H:i:s T");  	// 2001-03-10 17:16:18 PDT(the MySQL DATETIME format)
	$emailData->message = $_POST['message'];
	$emailData->headers = 'From: WVJ-SFSU Web Forms <forms@windowsvj.com>' . "\r\n";
	$emailData->subject = 'SFChirps - Notification' ;

	session_start();
	if(!isset($emailData)) {
		$_SESSION['message'] = "Form submit failed ! Please check the form entries!";
		header('Location: '. $httpReferer) ;
		exit;
	}
	sendEmail($emailData);
	addToCSV($emailData);
	$_SESSION['message'] = "Form submitted successfully. We will contact you soon !";
	header('Location: '. $httpReferer) ;
}

/**
 * Send an email to admin for every form request
 */
function sendEmail($emailData) {
	global $adminEmail;
	$emailData->message = wordwrap($emailData->message, 70, "\r\n");

	$message = 		"Twitter Handle: " . $emailData->twitterhandle. "\r\n"
				. 	"Name: " . $emailData->name . "\r\n"
				. 	"Email: " . $emailData->email . "\r\n"
				. 	"Date: " . $emailData->date . "\r\n"
				. 	"Message: " . $emailData->message . "\r\n";

	$sendMail = mail($adminEmail, $emailData->subject, $message, $emailData->headers);
	if(!$sendMail) {
		mail($adminEmail, "[ERROR] " . $emailData->formPrefix .  "Error unexpected mail() fail\n", $emailData->message);
	}
}

/**
 * Create a CSV in the formsDirectory for every form request
 */
function addToCSV($emailData) {
	global $adminEmail, $formsDirectory;
	$csvFileName = date("Y") . ".csv";

	$fileHandle = fopen($formsDirectory . $csvFileName, 'a');
	if(!$fileHandle) {
		mail($adminEmail, "[ERROR] " . $emailData->formPrefix .  "Error Opening " . $csvFileName, $csvFileName);
		exit;
	}
	$addToCSV = fputcsv($fileHandle, array($emailData->name,$emailData->email,$emailData->date, $emailData->subject, $emailData->message));
	if(!$addToCSV) {
		mail($adminEmail, "[ERROR] Error Adding Content to CSV", $emailData->message);
		exit;
	}
	fclose($fileHandle);
}
