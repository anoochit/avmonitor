<?php

function send_sms( $param_google_username , $param_google_password,$param_title,$param_content ,$param_startdate='' , $param_enddate =''){
 	/**
	 * @Include Zend_Loader
	 */
	require_once 'Zend/Loader.php';
 	/**
	 * @Load Zend_Gdata
	 */
	Zend_Loader::loadClass('Zend_Gdata');
 	/**
	 * @Load Zend_Gdata_AuthSub
	 */
	Zend_Loader::loadClass('Zend_Gdata_AuthSub');
 	/**
	 * @Load Zend_Gdata_ClientLogin
	 */
	Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
 	/**
	 * @Load Zend_Gdata_HttpClient
	 */
	Zend_Loader::loadClass('Zend_Gdata_HttpClient');
 	/**
	 * @Load Zend_Gdata_Calendar
	 */
	Zend_Loader::loadClass('Zend_Gdata_Calendar');
 
	// Parameters for ClientAuth authentication
	$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
	$user = $param_google_username ;
	$pass =$param_google_password ;
 
	// Create an authenticated HTTP client
	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
 
	// Create an instance of the Calendar service
	$service = new Zend_Gdata_Calendar($client);
 
	// Create a new entry using the calendar service's magic factory method
	$event= $service->newEventEntry();
 
	// Populate the event with the desired information
	// Note that each attribute is crated as an instance of a matching class
	$event->title = $service->newTitle( $param_title );
 
	//$event->where = array($service->newWhere("Mountain View, California"));
	$event->content = $service->newContent( $param_content );
 
	// Set the date using RFC 3339 format.
    if($param_startdate == '' || $param_enddate == '' ){
			$startDate = date( "Y-m-d" );//"2009-01-15";
			$startTime = date( "H:i" , strtotime("+2 minutes") );
			$endDate = date( "Y-m-d" );
			$endTime = date( "H:i" , strtotime("+2 minutes") );
	}else{
			$startDate = substr($param_startdate,0,10);
			$startTime = substr($param_startdate,11,5);
			$endDate = substr($param_enddate,0,10);
			$endTime = substr($param_enddate,11,5);
	}
	$tzOffset = "+07";
	
	$when = $service->newWhen();
	$when->startTime = "{$startDate}T{$startTime}:00.000{$tzOffset}:00";
	$when->endTime = "{$endDate}T{$endTime}:00.000{$tzOffset}:00";
 
	// Create a new reminder object. It should be set to send an email
	// to the user 10 minutes beforehand.
	$reminder = $service->newReminder();
	$reminder->method = "sms";
	$reminder->minutes = "1";
 
	$when->reminders = array($reminder);
 
	$event->when = array($when);
 
	// Upload the event to the calendar server
	// A copy of the event as it is recorded on the server is returned
	if ($newEvent = $service->insertEvent($event)){
 
		return true ;
	}else{
 
		return false;
	}
 
}

/*
$sms_status = send_sms( $_GET['username'] , $_GET['password'] , $_GET['title'] ,$_GET['msg'] ,$_GET['startdate'] ,$_GET['enddate'] );
if($sms_status){
echo "OK";
}
*/


?>
