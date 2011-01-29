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
<input type="button" value="+ Add User" class="submit" id="page-button" onclick="javascript:location.href='/user/add'">
<?php 

// load all 

?>
<table id="table" cellpadding="3" cellspacing="1">
<tr class="table-header">
	<th>ID</th><th width="200px">Name</th>
	<th width="250px">Login</th>
	<th width="200px">E-Mail</th>
	<th width="180px">Action</th>	
</tr>
<?php 
	$obuser=new AVUser();
	$ures=$obuser->Find("id > 0 AND enable=1 ");
	
	foreach ($ures as $item) {
?>
<tr class="table-row">
	<td><?=$item->id;?></td>
	<td><?=$item->fullname;?></td>
	<td><?=$item->login;?></td>
	<td><?=$item->email;?></td>
	<td align="center"> <a href="/user/edit/<?=$item->id; ?>">Edit</a> 
<?php 
	// check is user id > 1
	if (($item->id) > 1) {
?>
	| <a href="/user/delete/<?=$item->id;?>">Delete</a> </td>
<?php 
	} // if
?>
</tr>
<?php 		
	} // for
	
?>
</table>