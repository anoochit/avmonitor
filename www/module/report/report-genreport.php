<?php 

// check authentication
$obav->isAuthen();

// load menu 

$res=$obav->getUserInfoBySession($_SESSION['AVID']);

?>
<!-- <div id="header">
<div id="dashboard-menu"><br></div>
<div id="dashboard-header"></div>
<div id="nav-menu"> -->
<!--<ul>
<li><a href="<?=$url;?>/dashboard">Dashboard</a></li>
<li><a href="<?=$url;?>/monitor">Monitor</a></li>
<li><a href="<?=$url;?>/server">Server</a></li>
<li><a href="<?=$url;?>/service">Service</a></li>
<li  class="selected"><a href="<?=$url;?>/report">Report</a></li>
<li><a href="<?=$url;?>/user">User</a></li>
</ul>-->
<!-- </div>
</div> -->
<?php
/*
	echo "<pre>";
	var_dump(split("&",$_SERVER[QUERY_STRING]));
	echo "</pre>";
*/
	// check server monitor for services items
	$obmon=new AVMonitor();
	$res_service=$obmon->Find("server_id=".$_REQUEST["server_id"]." AND enable=1 ORDER BY service_id ASC");
	
	// check report type
	if ($_REQUEST['type']=="state") {
		// select raw statistic
		
		switch ($_REQUEST['inteval']) {
			case "none"	:
				require "none-stat-report.php";
				break;
			case "daily" :
				require "daily-stat-report.php";
				break;
			case "weekly" :
				require "weekly-stat-report.php";
				break;
			case "monthly" :
				require "monthly-stat-report.php";
				break;
			case "yearly" :
				require "yearly-stat-report.php";
				break;				
		}
		
		/*
		$sql_array=array();		
		foreach ($res_service as $item) {
			$sqltxt="SELECT * 
				FROM 	log l , monitor m
				WHERE 
						l.monitor_id=m.id AND
						((l.flag=0) OR (l.flag=2)) AND 
						m.server_id=".$item->server_id." AND
						m.service_id=".$item->service_id." AND
						l.".$range." 
				ORDER BY l.id ASC";
			array_push($sql_array,$sqltxt);		
		}
		*/
				 
	} else {
		// select summary
	switch ($_REQUEST['inteval']) {
			case "none"	:
				require "none-sumary-report.php";
				break;
			case "daily" :
				require "daily-sumary-report.php";
				break;
			case "weekly" :
				require "weekly-sumary-report.php";
				break;
			case "monthly" :
				require "monthly-sumary-report.php";
				break;
			case "yearly" :
				require "yearly-sumary-report.php";
				break;				
		}
	}
	

?>
