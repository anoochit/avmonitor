<?php

require_once('include/adodb5/adodb.inc.php');
require_once('include/adodb5/adodb-active-record.inc.php');

$dbhost="localhost";
$dbname="avmonitor";
$dbusername="root";
$dbpassword="monalisa";

$url="http://mon.redline.net";

$template="default";

$smtp_host="localhost";
$smtp_port="25";

$admin_name="Monitoring Administrator";
$admin_email="admin@mon.redlinesoft.net";

$crontab_inteval=5;

$db = &ADONewConnection('mysql');
$db->PConnect($dbhost,$dbusername,$dbpassword,$dbname);

//$db->debug=1;

if (!$db) die("Connection failed");

ADOdb_Active_Record::SetDatabaseAdapter($db);

require 'include/avmon/class.avmon.php';
require 'include/avmon/class.user.php';
require 'include/avmon/class.server.php';
require 'include/avmon/class.service.php';
require 'include/avmon/class.monitor.php';
require 'include/avmon/class.log.php';


session_start();







?>
