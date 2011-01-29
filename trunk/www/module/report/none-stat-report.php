<?php 

// include flash chart library
include ("include/fusionchart/Code/PHP/Includes/FusionCharts.php");

// get server info
$srres=$obav->getServerById($_REQUEST["server_id"]);

?>
<H2 id="page-button">Statistic Summary on <?=$srres[0]->hostname; ?> (from <?=$_REQUEST['from']." to ".$_REQUEST['to']; ?>)</H2>
<?php 
	
	// set sql data for each services - data
	$sql_data=array();
	foreach ($res_service as $item) {
		$sql="SELECT * 
				FROM 	log l , monitor m
				WHERE 
						l.monitor_id=m.id AND
						((l.flag=0) OR (l.flag=1) OR (l.flag=2))  AND 
						m.server_id=".$item->server_id." AND
						m.service_id=".$item->service_id." AND
						l.date BETWEEN date(\"".$_REQUEST['from']."\") AND  date(\"".$_REQUEST['to']."\")
				ORDER BY l.id ASC";
		array_push($sql_data,$sql);
	}
	// set sql data for each services - data for chart
	$sql_chart=array();
	foreach ($res_service as $item) {
		$sql="SELECT * 
				FROM 	log l , monitor m
				WHERE 
						l.monitor_id=m.id AND
						m.server_id=".$item->server_id." AND
						m.service_id=".$item->service_id." AND
						l.date BETWEEN date(\"".$_REQUEST['from']."\") AND  date(\"".$_REQUEST['to']."\")
				ORDER BY l.id ASC";
		array_push($sql_chart,$sql);
	}

	
	// initial data index
	$dataindex=0;
	foreach ($res_service as $item) {
		$svres=$obav->getServiceById($item->service_id);
	
?>
<h3 id="page-button"><?=$svres[0]->name; ?> Monitoring</h3>
<?php 

	// generate xml chart data
	$rs=$db->execute($sql_chart[$dataindex]);
	$strXML  = "<graph bgColor='ececec' yAxisName='service status ~ 1 = up, -1 down' xAxisName='time' yAxisMaxValue='2' yAxisMinValue='-2' zeroPlaneThickness='3' lineColor='00ff00' decimalPrecision='0' showValues='0' showNames='0' showAnchors='0' numdivlines='0' showDivLineValue='0'>";
	if (($rs->recordcount())>0) {
		while (!$rs->EOF) {
			if ($rs->fields['flag']==1) {
				$value=1;
				$text="up";
			} else {
				$value=-1;
				$text="down";
			}
			$strXML .= "<set name='".$rs->fields['date']."-".$rs->fields['time']."' value='".$value."' hoverText='".$text."'/>";
			$rs->MoveNext();
		}
	}     
   	$strXML .= "</graph>";
   //	var_dump(htmlspecialchars($strXML)) ;
   
   	// show chart
   	echo renderChartHTML("../../include/fusionchart/Charts/FCF_Line.swf", "", $strXML, "myNext", 600, 300);

	// show table data
?>
<table id="table" cellpadding="3" cellspacing="1">
<tr class="table-header">
	<th width="200px">Date-Time</th>
	<th width="300px">Status</th>	
</tr>
<?php 
	
	$rs=$db->execute($sql_data[$dataindex]);

	if (($rs->recordcount())>0) {
		while (!$rs->EOF) {
?>
<tr class="table-row">
	<td><?=$rs->fields["date"]; ?> <?=$rs->fields["time"]; ?></td>
	<td>
	<? if (($rs->fields["flag"])==0){
			echo "service down"; 
		} else if (($rs->fields["flag"])==1) {
			echo "service up";
		} else {
			echo "mark as downtime";
		}
	?>
	</td>	
</tr>
<?php 
			$rs->MoveNext();
		} // while
	} else {
?>
<tr class="table-row">
	<td colspan="2" align="center">* no downtime data *</td>	
</tr>
<?php 
	} // if

?>
</table><br><br>
<?php 
		$dataindex++;
	} // foreach
?>
