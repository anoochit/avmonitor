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
<li  class="selected"><a href="<?=$url;?>/report">Report</a></li>
<li><a href="<?=$url;?>/user">User</a></li>
</ul>
</div>
</div>
<div  id="page-button" class="report-bar">
<form method="get" action="/report/genreport" target="_blank">
<table cellpadding="3" >

<tr>
	<td>Choose Server : </td><td><?=$obav->genServerCombo(); ?></td>
</tr>
<tr>
	<td>Report Type : </td><td><?=$obav->getReportTypeCombo(); ?></td>
</tr>
<tr>
	<td>Date Range : </td>
	<td>
		<!--<label for="from">From</label>-->
		<input type="text" id="from" name="from" size="8" value="<?=date("Y-m-d"); ?>"/>
		<label for="to">to</label>
		<input type="text" id="to" name="to" size="8" value="<?=date("Y-m-d"); ?>"/>
	</td>
</tr>
<tr>
	<td>Inteval : </td><td><?=$obav->getReportIntevalCombo(); ?></td>
</tr>
<tr>
	<td> </td><td><input type="hidden" name="action" value="report"><input class="submit"  type="submit" name="submit" value="Generate Report"></td>
</tr>

</table>
</form>
</div>
<?php 

 /*

SELECT 
     SUM(CASE WHEN l.flag = 1 THEN 1 ELSE 0 END) AS online, 
     SUM(CASE WHEN l.flag = 0 THEN 1 ELSE 0 END) AS offline, 
     SUM(CASE WHEN l.flag = 2 THEN 1 ELSE 0 END) AS offline_attempt,
     COUNT(*) AS total
FROM `log` l 
WHERE monitor_id=5

*/





?>



