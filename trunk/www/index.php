<?php

	require 'config.php';
	$obav=new AVMon();
	
	
	$ocreq=split("/",$_REQUEST['q']);
	
	include "template/".$template."/header.php";

	// 2nd level 
	if ((file_exists("module/".$ocreq[0]."/".$ocreq[0]."-".$ocreq[1].".php")) AND ($ocreq[0]!="") AND ($ocreq[1]!="")) {
		include "module/".$ocreq[0]."/".$ocreq[0]."-".$ocreq[1].".php";
	} else if ((file_exists("module/".$ocreq[0]."/".$ocreq[0].".php")) AND ($ocreq[0]!="")) {
		include "module/".$ocreq[0]."/".$ocreq[0].".php";
	} else {
		header("Location: ".$url."/dashboard");
	}
	
	include "template/".$template."/footer.php"; 

?>