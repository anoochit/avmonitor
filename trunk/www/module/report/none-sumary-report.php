<?php 

// include flash chart library
include ("include/fusionchart/Code/PHP/Includes/FusionCharts.php");

// get server info
$srres=$obav->getServerById($_REQUEST["server_id"]);

?>
<H2 id="page-button">Statistic Summary of Downtime on <?=$srres[0]->hostname; ?> (from <?=$_REQUEST['from']." to ".$_REQUEST['to']; ?>)</H2>
<?php 
	
	$sql_array=array();
	foreach ($res_service as $item) {
		$sql="SELECT 
					SUM(CASE WHEN l.flag = 1 THEN 1 ELSE 0 END) AS online,
					SUM(CASE WHEN l.flag = 0 THEN 1 ELSE 0 END) AS offline,
					SUM(CASE WHEN l.flag = 2 THEN 1 ELSE 0 END) AS offline_attemp
				FROM 	log l , monitor m
				WHERE 
						l.monitor_id=m.id AND
						m.server_id=".$item->server_id." AND
						m.service_id=".$item->service_id." AND
						l.date BETWEEN date(\"".$_REQUEST['from']."\") AND  date(\"".$_REQUEST['to']."\")
				ORDER BY l.id ASC";
		array_push($sql_array,$sql);
	} // for each
	
	$dataindex=0;

	foreach ($res_service as $item) {
		// get services name
		$svres=$obav->getServiceById($item->service_id);
?>
<h3 id="page-button"><?=$svres[0]->name; ?> Monitoring</h3>
<?php 

	//gen xml data
		$rsx=$db->execute($sql_array[$dataindex]);
		$strXML="<graph bgColor='ececec'  showPercentageInLabel='1' showNames='1' showValue='0' decimalPrecision='0' pieSliceDepth='30'  pieRadius='100'>";		
		if (($rsx->recordcount())>0) {
			while (!$rsx->EOF) {
				$strXML.="<set name='up' value='".$rsx->fields[0]."' isSliced='1'/>";
				$strXML.="<set name='down' value='".($rsx->fields[1]+$rsx->fields[2])."' isSliced='1'/>";
				$rsx->MoveNext();
			} // while	
		}
		$strXML.="</graph>";
		
		// show chart
   		echo renderChartHTML("../../include/fusionchart/Charts/FCF_Pie2D.swf", "", $strXML, "myNext", 600,300);
   	
		// gen data table
		
		
?>

<table id="table" cellpadding="3" cellspacing="1">
<tr class="table-header">
	<!--<th width="150px">Online</th>-->
	<th width="150px">Frequency of Downtime</th>
	<!--<th width="200px">Offline re-check</th>-->
	<th width="350px">Approximate downtime (Hrs)</th>	
</tr>
<?php 
	$rs=$db->execute($sql_array[$dataindex]);
	
	if (($rs->recordcount())>0) {
		while (!$rs->EOF) {
			
?>
<tr class="table-row">
	<!--<td align="center"><?=$rs->fields[0]; ?></td>-->
	<td align="center"><?=$rs->fields[1]; ?></td>	
	<!--<td align="center"><?=$rs->fields[2]; ?></td>-->
	<td align="center"><?=$obav->ConvertMinutes2Hours((($rs->fields[1])*$crontab_inteval)+(($rs->fields[2])*$crontab_inteval)); ?></td>
</tr>
<?php 
			$rs->MoveNext();
		} // while
	} else {
?>
<tr class="table-row">
	<td colspan="2" align="center">* no down time data *</td>	
</tr>
<?php 
	} // if count

?>
</table><br><br>
<?php 
		$dataindex++;
		
	} // for each
?>
