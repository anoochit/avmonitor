<?php 

$srres=$obav->getServerById($_REQUEST["server_id"]);

?>
<H2 id="page-button">Daily statistic  monitoring on <?=$srres[0]->hostname; ?> (<?=$_REQUEST['from']." - ".$_REQUEST['to']; ?>)</H2>
<?php 

	list($y,$m,$d)=split("-",$_REQUEST['from']);
	

?>