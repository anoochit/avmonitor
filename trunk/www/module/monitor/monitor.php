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
<?php 

// load all service

?>
<input type="button" value="+ Add Monitoring Service" class="submit" id="page-button" onclick="javascript:location.href='/monitor/add'">

<table id="table" cellpadding="3" cellspacing="1">
<tr class="table-header">
	<th>ID</th>
	<th width="200px">Name</th>
	<th width="100px">Service</th>
	<th width="100px">EMAIL</th>
	<th width="100px">SMS</th>
	<th width="200px">Last Monitored</th>
	<th width="80px">Status</th>
	<th width="180px">Action</th>	
</tr>
<?php 

// load default services
$observer=new AVMonitor();
$res=$observer->Find("id > 0 AND enable=1 ORDER BY server_id,service_id ");

// show item
foreach ($res as $item) {
	// get info
	$ssres=$obav->getServerById($item->server_id);
	$svres=$obav->getServiceById($item->service_id);
	// get last log
	$oblog=$obav->getLastMonitor($item->id);
	if (($oblog->flag)==1) {
		$status="<div id=\"online\">online</div>";
	} else if ((($oblog->flag)==0) OR (($oblog->flag)==2)) {
		$status="<div id=\"offline\">offline</div>";
	} 
	
	
	if (($oblog->flag)==null) {
		$status="<div id=\"waiting\">waiting</div>";
	}
?>
<tr class="table-row">
	<td><?=$item->id;?></td>
	<td><?=$ssres[0]->servername;?></td>
	<td align="center"><?=$svres[0]->name;?></td>
	<td align="center">
	<? 
			if (($item->email)=="1") {
				echo "Yes";
			} else {
				echo "No";
			}
	?>
	</td>
	<td align="center">
	<? 
			if (($item->sms)=="1") {
				echo "Yes";
			} else {
				echo "No";
			}
	?>
	</td>
	<td><?=$oblog->date; ?> <?=$oblog->time; ?></td>
	<td align="center"><?=$status; ?></td>
	<td align="center"><a href="/monitor/edit/<?=$item->id;?>">Edit</a> | <a href="/monitor/delete/<?=$item->id;?>">Delete</a></td>
</tr>
<?php 
}
?>
</table>
