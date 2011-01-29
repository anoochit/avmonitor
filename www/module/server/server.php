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
<input type="button" value="+ Add Server" class="submit" id="page-button" onclick="javascript:location.href='/server/add'">
<?php 

// load all service

?>
<table id="table" cellpadding="3" cellspacing="1">
<tr class="table-header">
	<th>ID</th><th width="200px">Name</th>
	<th width="250px">FQDN/IP Address</th>
	<th width="200px">Owner</th>
	<th width="180px">Action</th>	
</tr>
<?php 

// load default services
$observer=new AVServer();
$res=$observer->Find("id > 0 ");

// show item
foreach ($res as $item) {
   if (($item->enable)==false) {
   	   $class="table-row-disable";
   } else {
   	   $class="table-row";
   }
   $ures=$obav->getUserInfoBySession($item->user_id);
?>
<tr class="<?=$class; ?>">
	<td><?=$item->id;?></td>
	<td><?=$item->servername;?></td>
	<td><?=$item->hostname;?></td>
	<td><?=$ures[0]->fullname;?></td>
	<td align="center"> <a href="/server/edit/<?=$item->id;?>">Edit</a> | <a href="/server/delete/<?=$item->id;?>">Delete</a> </td>
</tr>
<?php 
} // for


?>
</table>