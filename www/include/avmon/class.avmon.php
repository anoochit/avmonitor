<?php 

class AVMon {

	/**
	 * 
	 * check session for authrntication
	 */
	function isAuthen(){
		global $url;
		if ((!isset($_SESSION['AVID'])) OR ($_SESSION['AVID']<=0)) {
			header("Location: ".$url."/signin");
		}
	}
	
	/**
	 * 
	 * check login and password for authentication
	 * @param $user
	 * @param $pass
	 */
	function getAuthen($user,$pass) {
		$obuser=new AVUser();
		$obuser->Load("login LIKE '".$user."' AND password LIKE '".sha1($pass)."' AND enable=1 ");
		if ((count($obuser))==1) {
			return true;			
		} else {
			return false;
		} 
		
	}
	
	/**
	 * 
	 * load user info ny login
	 * @param $user
	 */
	function getUserInfoByLogin($user) {
		$obuser=new AVUser();
		$res=$obuser->Find("login = '".$user."'");
		return $res;
	}
	
	
	/**
	 * 
	 * load user info ny login
	 * @param $user
	 */
	function getUserInfoBySession($session) {
		$obuser=new AVUser();
		$res=$obuser->Find("id = '".$session."'");
		return $res;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param $id
	 */
	function getServiceById($id) {
		$observice=new AVService();
		$res=$observice->Find("id = '".$id."'");
		return $res;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	function getServerById($id) {
		$observer=new AVServer();
		$res=$observer->Find("id = '".$id."'");
		return $res;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	function getLastMonitor($id) {
		$oblog=new AVLog();
		$oblog->Load("monitor_id=".$id." ORDER BY id DESC LIMIT 1");
		return $oblog;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $email
	 */
	function getUserInfoByEmail($email) {
		$obuser=new AVUser();
		$obuser->Load("email='".$email."' LIMIT 1");
		return $obuser;
	}
	
	
	function genServerCombo() {
		$observer=new AVServer();
		$res=$observer->Find("enable=1 ORDER BY servername ASC");
	
		echo "<select name=\"server_id\">";
		foreach ($res as $item) {
			echo "<option value=\"".$item->id."\">".$item->servername." (".$item->hostname.")";			
		}
		echo "</select>";
	}

	function genServiceCombo() {
		$observer=new AVService();
		$res=$observer->Find("id > 0");
	
		echo "<select name=\"service_id\">";
		foreach ($res as $item) {
			echo "<option value=\"".$item->id."\">".$item->name."  (".$item->port.")";			
		}
		echo "</select>";
	}
	
	function genOwnerCombo() {
		$observer=new AVUser();
		$res=$observer->Find("id > 0");
	
		echo "<select name=\"user_id\">";
		foreach ($res as $item) {
			echo "<option value=\"".$item->id."\">".$item->fullname." ";			
		}
		echo "</select>";
	}
	
	function getReportTypeCombo(){
		?>
		<select name="type">
			<option value="state" >Statistic Summary</option>
			<option value="downtime" >Statistic Summary of Downtime</option>
		</select>
		<?php 
	}
	
	function getReportIntevalCombo() {
		?>
		<select name="inteval">
			<option value="none" > -- None -- </option>
			<!-- <option value="daily" >Daily</option>
			<option value="weekly" >Weekly</option>  
			<option value="monthly" >Monthly</option>
			<option value="yearly" >Yearly</option>-->
		</select>
		<?php
	}
	
function sendMassMail($subject,$body,$cname,$emailto) {
	global $smtp_host,$smtp_port,$admin_name,$admin_email;
	include_once("include/phpmailer/class.phpmailer.php");
	
	$mail = new phpmailer();
	$mail->CharSet="utf-8";
	$mail->IsHTML(true);
	$mail->Host= $smtp_host;
	$mail->Port= $smtp_port;
	$mail->Mailer="smtp";
	$mail->From=$admin_email;
	$mail->FromName=$admin_name;
	$mail->Subject=$subject;
	$mail->Body="<html><body>".stripcslashes($body)."</body></html>";
	$mail->AddAddress($emailto,$cname);
	$result=$mail->Send();
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	return $result;
}

function ConvertMinutes2Hours($Minutes)
{
    if ($Minutes < 0)
    {
        $Min = Abs($Minutes);
    }
    else
    {
        $Min = $Minutes;
    }
    $iHours = Floor($Min / 60);
    $Minutes = ($Min - ($iHours * 60)) / 100;
    $tHours = $iHours + $Minutes;
    if ($Minutes < 0)
    {
        $tHours = $tHours * (-1);
    }
    $aHours = explode(".", $tHours);
    $iHours = $aHours[0];
    if (empty($aHours[1]))
    {
        $aHours[1] = "00";
    }
    $Minutes = $aHours[1];
    if (strlen($Minutes) < 2)
    {
        $Minutes = $Minutes ."0";
    }
    $tHours = $iHours .":". $Minutes;
    return $tHours;
}	


}


?>
