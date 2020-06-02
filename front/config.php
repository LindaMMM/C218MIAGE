<?php
error_log("config.php", 0);
$d="";
while(!file_exists($d."index.php"))$d.="../";
define("__DIR_PARENT__",$d);

require __DIR_PARENT__.'src/class/autoloader.php';

@session_cache_limiter('nocache'); 
error_reporting(0);

@session_start();

/*-----------------------------------------------------------------*/
/*LES VARIABLES A MODIFIER :
/*-----------------------------------------------------------------*/

$MYSQL_USER="nitramcroot";	
$MYSQL_PASS="tAeLAU44RUAZyD2uCNh3";
$MYSQL_SERVER="nitramcroot.mysql.db";
$db_login="nitramcroot";
define('DB_DVD', "$MYSQL_SERVER|$MYSQL_USER|$MYSQL_PASS|$db_login");

define("MEDIA_VIDEO", "http://media.nitramadnil.ovh/video/");
define("MEDIA_AFFICHE", "http://media.nitramadnil.ovh/affiche/");
error_log("End-config.php", 0);
?>