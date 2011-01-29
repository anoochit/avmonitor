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
<li class="selected"><a href="<?=$url;?>/dashboard">Dashboard</a></li>
<li><a href="<?=$url;?>/monitor">Monitor</a></li>
<li><a href="<?=$url;?>/server">Server</a></li>
<li><a href="<?=$url;?>/service">Service</a></li>
<li><a href="<?=$url;?>/report">Report</a></li>
<li><a href="<?=$url;?>/user">User</a></li>
</ul>
</div>
</div>

<table cellpadding="5" cellspacing="0" id="page-button">
<tr class="table-row">
	<th width="200px">System</th>
	<td><? echo shell_exec('uname -a'); ?></td>
</tr>
<tr class="table-row">
	<th>Server Name</th>
	<td><?=$_SERVER["SERVER_NAME"]; ?></td>
</tr>
<tr class="table-row">
	<th>Server Software</th>
	<td><?=$_SERVER["SERVER_SOFTWARE"]; ?></td>
</tr>
<tr class="table-row">
	<th>Uptimes</th>
	<td>
	<?php 
		$data = shell_exec('uptime');
		$uptime = explode(' up ', $data);
		$uptime = explode(',', $uptime[1]);
		$uptime = $uptime[0].', '.$uptime[1];
		echo $uptime;
  	?>
	</td>
</tr>
<tr class="table-row">
	<td colspan="2"><hr size="1"> </td>
</tr>
<tr class="table-row">
	<th>Server Registered</th>
	<td>
		<?php 

			$observer=new AVServer();
			$res=$observer->Find(" enable=1 ");
			echo count($res)." Machine(s)";
		?>
	</td>
</tr>
<tr class="table-row">
	<th>Service Monitored</th>
	<td>
		<?php 
			$observice=new AVMonitor();
			$res=$observice->Find(" enable=1 ");
			echo count($res)." Service(s)";
		?>
	</td>
</tr>
<tr class="table-row">
	<th>Lastest Monitored</th>
	<td>
		<?php 
			$observice=new AVLog();
			$res=$observice->Find(" id >0 ORDER BY id DESC LIMIT 1");
			echo $res[0]->date." ".$res[0]->time;
		?>
	</td>
</tr>
</table>
