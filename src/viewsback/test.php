<?php 
include("../class/config.php");
include("./vendor/autoload.php");
phpinfo();
echo("test");
try{
echo DB_DVD;
$bd = new Database(DB_DVD);
echo "database";
$user = new UserApp($bd);
echo 'liste';

$countTotal = $user->getCountAll("");
$countfilter = $user->getCountAll($filter);

echo 'count';
}
catch(Exception $e){
    echo $e->getMessage();
}