<?php
$d="";
while(!file_exists($d."inde.php"))$d.="../";
define("__DIR_PARENT__",$d);

require __DIR_PARENT__ . 'src/class/autoload.php';

@session_cache_limiter('nocache'); 
error_reporting(0);

@session_start();

/*-----------------------------------------------------------------*/
/*LES VARIABLES A MODIFIER :
/*-----------------------------------------------------------------*/

$MYSQL_USER="root";	
$MYSQL_PASS="Mys@ql2020";
$MYSQL_SERVER="localhost";
$db_login="dvdtech";
define('DB_DVD', "$MYSQL_SERVER|$MYSQL_USER|$MYSQL_PASS|$db_login");

?>