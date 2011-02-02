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
<li><a href="<?=$url;?>/monitor">Monitor</a></li>
<li class="selected"><a href="<?=$url;?>/server">Server</a></li>
<li><a href="<?=$url;?>/service">Service</a></li>
<li><a href="<?=$url;?>/report">Report</a></li>
<li><a href="<?=$url;?>/user">User</a></li>
</ul>
</div>
</div>
<?php 
	if ($_POST["action"]=="add") {
		$observer=new AVServer();
		$observer->servername=$_POST["servername"];
		$observer->hostname=$_POST["hostname"];
		$observer->enable=1;
		$observer->user_id=$_POST["user_id"];
		$observer->Save();
		header("Location: ".$url."/server");	

	} else {
?>
<!-- form -->
<form method="post" id="addserver" >
<table cellpadding="3" cellspacing="0" id="page-button">
<tr class="table-row">
	<td>Server Name</td>
	<td width="300px"><input type="text" name="servername"></td>
</tr> 
<tr class="table-row">
	<td>Hostname </td>
	<td width="600px"><input type="text" name="hostname"> (FQDN or IP Address)</td>
</tr> 
<tr class="table-row">
	<td>Owner </td>
	<td width="600px"><?=$obav->genOwnerCombo(); ?></td>
</tr> 
<tr class="table-row">
	<td> </td>
	<td><input class="submit"  type="submit" name="submit" value="Add"><input type="hidden" name="action" value="add"></td>
</tr>
</table>
<?
	}
?>

