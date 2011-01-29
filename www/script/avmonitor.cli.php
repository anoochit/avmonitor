#!/usr/bin/php
<?php 

/* must config first */
$pwd="/home/xavier/project/avmon/www/"; // base path for cli script
$incattm="n"; // notify include all attempt
/* must config first */

require $pwd."/config.php";

$obav=new AVMon();

// load monitor
$rs = &$db->Execute('SELECT mo.id as mid,mo.*,sv.*,sr.*,ur.fullname,ur.mobile,ur.email as emailadd,ur.googleaccount,ur.googlepassword FROM monitor mo,service sv,server sr,user ur WHERE mo.service_id=sv.id AND mo.server_id=sr.id AND sr.enable=1 AND sr.user_id=ur.id AND mo.enable=1');

while (!$rs->EOF) {

	// start monitoring check hostname, service, port
	$monitorid=$rs->fields['mid'];
	$hostname=$rs->fields['hostname'];
	$service=$rs->fields['name'];
	$port=$rs->fields['port'];
	$port_option=$rs->fields['port_option'];
	$owner=$rs->fields['fullname'];
	$emailaddress=$rs->fields['emailadd'];
	$email=$rs->fields['email'];
	$sms=$rs->fields['sms'];	
	$gusername=$rs->fields['googleaccount'];
	$gpassword=$rs->fields['googlepassword'];

	if ($service=="ICMP") {
		// use icmp methods
		$resmon=icmp($hostname);
	} else {
		// use socket methods
		if ($port_option!="") $port=$port_option;
		$resmon=tcpsocket($hostname,$port);
	}
	
	// prepare data for log 
	if ($resmon==true) {
		$result="[OK]";
		$flag="1";
	} else {
		$result="[FAIL]";
		$flag="0";
	}

	// set log message
	$datetime=date("Y-m-d H:i:s");
	$date=date("Y-m-d");
	$time=date("H:i:s");
	$logmsg=$datetime."\t".$service."\t".$hostname."\t".$result."\n";
	$handle = fopen($pwd."/script/monitor.log", "a+");
	fputs ($handle, $logmsg);
	fclose($handle);

	// check last log
	$oblog=$obav->getLastMonitor($monitorid);
	if ((count($oblog)) >0) {
		// check attemp if last flag is 0 or 2 then set flag to 2
		if (((($oblog->flag)=="0") OR (($oblog->flag)=="2"))) {
			$flag="2";
		} 
	}

	// set log to database
	$oblog=new AVLog();
	$oblog->date=$date;
	$oblog->time=$time;
	$oblog->monitor_id=$monitorid;
	$oblog->flag=$flag;
	$oblog->Save();
	

	// set notification to email and sms
	if ($resmon==false) {
		
		if (($incattm=="y") AND ($flag=="2")) {
			// notification to email
			if ($email==true) {
				// replace string
				$body=file_get_contents($pwd."/script/email.message.txt");
				$body=ereg_replace("%OWNER%",$owner,$body);
				$body=ereg_replace("%SERVICE%",$service,$body);
				$body=ereg_replace("%HOSTNAME%",$hostname,$body);
				$body=nl2br($body);
				sendmassmail("[AV Monitoring]",$body,$owner,$emailaddress);
			} 
			
			// notification to sms
			if ($sms==true) {
				// send sms via google calendar
				if (($gusername!=null) AND ($gpassword!=null)) {
					send_sms( $gusername, $gpassword , "Cannot connect to ".$service." at ".$hostname." the service may down, please check!" ,"Cannot connect to ".$service." at ".$hostname." the service may down, please check!");
				}
			}
		} 

		if ($flag=="0") {
			// notification to email
			if ($email==true) {
				// replace string
				$body=file_get_contents($pwd."/script/email.message.txt");
				$body=ereg_replace("%OWNER%",$owner,$body);
				$body=ereg_replace("%SERVICE%",$service,$body);
				$body=ereg_replace("%HOSTNAME%",$hostname,$body);
				$body=nl2br($body);
				sendmassmail("[AV Monitoring]",$body,$owner,$emailaddress);
			} 
			
			// notification to sms
			if ($sms==true) {
				// send sms via google calendar
				if (($gusername!=null) AND ($gpassword!=null)) {
					send_sms( $gusername, $gpassword , "Cannot connect to ".$service." at ".$hostname." the service may down, please check!" ,"Cannot connect to ".$service." at ".$hostname." the service may down, please check!");
				}
			}			
		}
		
	}
	
	// move next record
	$rs->MoveNext();
}
$rs->Close(); 

// function

function tcpsocket($hostname,$port) {
	$fp = @fsockopen($hostname, $port, $errno, $errstr, 30);
	if (!$fp) {
    	$res=false;
	} else {
   		$res=true;
	}
	return $res;
}

function icmp($hostname) {
	$ping_ex = @exec("ping -c 3 ".$hostname, $ping_result, $pr);
	if (count($ping_result) > 1){
		$res=true;
	} else{
		$res=false;
	}
	return $res;
}

function sendmassmail($subject,$body,$cname,$emailto) {
	global $smtp_host,$smtp_port,$pwd;
	
	include_once($pwd."/include/phpmailer/class.phpmailer.php");
	
	$mail = new phpmailer();
	$mail->CharSet="utf-8";
	$mail->IsHTML(true);
	$mail->Host= $smtp_host;
	$mail->Port= $smtp_port;
	$mail->Mailer="smtp";
	$mail->From="anuchit@redlinesoft.net";
	$mail->FromName="AVMoniorting System";
	$mail->Subject=$subject;
	$mail->Body="<html><body>".stripcslashes($body)."</body></html>";
	$mail->AddAddress($emailto,$cname);
	$result=$mail->Send();
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	return $result;
}

function send_sms( $param_google_username , $param_google_password,$param_title,$param_content ,$param_startdate='' , $param_enddate =''){
	global $pwd;
 	/**
	 * @Include Zend_Loader
	 */
	require_once  "Zend/Loader.php";
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

?>
