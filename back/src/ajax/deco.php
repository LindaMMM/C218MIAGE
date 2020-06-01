<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("../class/config.php");

    $respond->code=0;
    $respond->message="Login n'est pas valide";
    $respond->nextAction="";
try {
    session_destroy();
    $respond->code = 1;
    $respond->message = "deco ok ";
} catch (Exception $e) {
    $respond->code = -5;
    $respond->message = $e->getMessage();
}

$myResponsJSON = json_encode($respond);
echo $myResponsJSON;
