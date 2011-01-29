<?php 

// check authentication
$obav->isAuthen();

// load menu 

$res=$obav->getUserInfoBySession();

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
<?php 
	$obuser=new AVUser();
	$obuser->Load("id=".$ocreq[2]);
	$obuser->enable=0;
	$obuser->Save();
	header("Location: ".$url."/user");
?>
