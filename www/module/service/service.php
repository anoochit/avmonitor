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
<li class="selected"><a href="<?=$url;?>/service">Service</a></li>
<li><a href="<?=$url;?>/report">Report</a></li>
<li><a href="<?=$url;?>/user">User</a></li>
</ul>
</div>
</div>
<?php 

// load all service

?>
<table id="table" cellpadding="3" cellspacing="1">
<tr class="table-header">
	<th>ID</th>
	<th width="200px">Name</th>
	<th width="180px">Default Port</th>
	<!-- <th width="180px">Action</th>  -->	
</tr>
<?php 
	
// load default services
$observice=new AVService();
$res=$observice->Find("id >0 ");

// show item
foreach ($res as $item) {

?>
<tr class="table-row">
	<td><?=$item->id;?></td>
	<td><?=$item->name;?></td>
	<td align="center"><?=$item->port;?></td>
<?php 
	// if id over 8 show
	if (($item->id)>8) {
?>
	<!-- <td align="center"><a href="">Edit</a> | <a href="">Delete</a></td>  -->
<?php 
	} else {
?>
	<!-- <td></td>  -->
<?
	}
?>
</tr>
<?php 
	
} // for
?>
</table>