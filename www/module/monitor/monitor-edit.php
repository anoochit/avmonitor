<?php 

// check authentication
$obav->isAuthen();

// load menu 

$res=$obav->getUserInfoBySession($_SESSION['AVID']);

?>
<div id="header">
<div id="dashboard-menu">Loged in as <a href="<?=$url;?>/preference"><?=$res[0]->fullname; ?></a> | <a href="<?=$url;?>/signout">SignOut</a></div>
<div id="dashboard-header"></div>
<div id="nav-menu">
<ul>
<li><a href="<?=$url;?>/dashboard">Dashboard</a></li>
<li class="selected"><a href="<?=$url;?>/monitor">Monitor</a></li>
<li><a href="<?=$url;?>/server">Server</a></li>
<li><a href="<?=$url;?>/service">Service</a></li>
<li><a href="<?=$url;?>/report">Report</a></li>
<li><a href="<?=$url;?>/user">User</a></li>
</ul>
</div>
</div>
<?

		$observer=new AVMonitor();
		$observer->Load("id=".$ocreq[2]);

		if ($_POST["action"]=="edit") {
			$observer->server_id=$_POST["server_id"];
			$observer->service_id=$_POST["service_id"];
			$observer->port_option=$_POST["port_option"];
			if ($_POST["email"]=="on") {
				$email="1";
			} else {
				$email="0";
			}
			$observer->email=$email;
			if ($_POST["sms"]=="on") {
				$sms="1";
			} else {
				$sms="0";
			}
			$observer->sms=$sms;
			$observer->enable=1;
			$observer->Save();
			header("Location: ".$url."/monitor");	

		} else {
?>
<!-- form -->
<form method="post" >
<table cellpadding="3" cellspacing="0" id="page-button" class="form">
<tr class="table-row">
	<td>Server : </td>
	<?	 $svres=$obav->getServerById($observer->server_id); ?>
	<td width="300px"><?=$svres[0]->servername; ?><input type="hidden" name="server_id" value="<?=$observer->server_id; ?>"></td>
</tr>
<tr class="table-row">
	<td>Service : </td>
	<?	 $srres=$obav->getServiceById($observer->service_id); ?>
	<td><?=$srres[0]->name; ?><input type="hidden" name="service_id" value="<?=$observer->service_id; ?>"></td>
</tr>
<tr class="table-row">
	<td>Port (Option) : </td>
	<td><input type="text" name="port_option" size="6" value="<?=$observer->port_option; ?>"></td>
</tr>
<tr class="table-row">
	<td valign="top">Notification : </td>
	<? 
		if (($observer->sms)==1) {
			$sms="checked";
		} 
		if (($observer->email)==1) {
			$email="checked";
		} 
		
	?>
	<td><input type="checkbox" name="email"  <?=$email; ?>> E-Mail <br><input type="checkbox" name="sms" <?=$sms; ?>> SMS </td>
</tr>
<tr class="table-row">
	<td> </td>
	<td><input class="submit"  type="submit" name="submit" value="Update"><input type="hidden" name="action" value="edit"></td>
</tr>
</table>
</form>
<?
		} // if action

?>
