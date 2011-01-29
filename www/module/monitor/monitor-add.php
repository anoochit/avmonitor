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
		if ($_POST["action"]=="add") {
			
			$observer=new AVMonitor();
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
	<td width="300px"><?=$obav->genServerCombo(); ?></td>
</tr>
<tr class="table-row">
	<td>Service : </td>
	<td><?=$obav->genServiceCombo(); ?></td>
</tr>
<tr class="table-row">
	<td>Port (Option) : </td>
	<td><input type="text" name="port_option" size="6"></td>
</tr>
<tr class="table-row">
	<td valign="top">Notification : </td>
	<td><input type="checkbox" name="email"  checked> E-Mail <br><input type="checkbox" name="sms" checked> SMS </td>
</tr>
<tr class="table-row">
	<td> </td>
	<td><input class="submit"  type="submit" name="submit" value="Add"><input type="hidden" name="action" value="add"></td>
</tr>
</table>
</form>
<?
		} // if action

?>
