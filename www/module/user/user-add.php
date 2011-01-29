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
<li><a href="<?=$url;?>/server">Server</a></li>
<li><a href="<?=$url;?>/service">Service</a></li>
<li><a href="<?=$url;?>/report">Report</a></li>
<li class="selected"><a href="<?=$url;?>/user">User</a></li>
</ul>
</div>
</div>
<?php 
	$obuser=new AVUser();
	$obuser->Load("id=".$_SESSION["AVID"]);

	if ($_POST["action"]=="add") {
		header("Location: ".$url."/user");	
	} else {
?>
<!-- form -->
<form method="post" id="form" >
<table cellpadding="3" cellspacing="0" id="page-button">
<tr class="table-row">
	<td>Full Name : </td>
	<td><input type="text" name="fullname" value="<?=$obuser->fullname; ?>"></td>
</tr>
<tr class="table-row">
	<td>Username : </td>
	<td><?=$obuser->login; ?></td>
</tr>
<tr class="table-row">
	<td>Password : </td>
	<td><input type="text" name="password" value=""></td>
</tr>
<tr class="table-row">
	<td>Email : </td>
	<td><input type="text" name="email" value="<?=$obuser->email; ?>"></td>
</tr>
<tr class="table-row">
	<td>Mobile Phone : </td>
	<td><input type="text" name="mobile" value="<?=$obuser->mobile; ?>"></td>
</tr>
<tr class="table-row">
	<td>Google Account : </td>
	<td><input type="text" name="googleaccount" value="<?=$obuser->googleaccount; ?>"></td>
</tr>
<tr class="table-row">
	<td>Google Account Password : </td>
	<td><input type="password" name="googlepassword" value="<?=$obuser->googlepassword; ?>"></td>
</tr>
<tr class="table-row">
	<td> </td>
	<td><input class="submit"  type="submit" name="submit" value="Update"><input type="hidden" name="action" value="edit"></td>
</tr>
<?
	}
?>
