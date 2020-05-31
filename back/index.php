<?php

require_once "../src/class/config.php";
require('../src/controller/accueilback.php');
date_default_timezone_set('Europe/Paris');

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch($page){
        case "login":
            login();
        break;
        case "users":
            listuser();
        break;
        case "movies":
            listmovie();
        break;
        case "prepa":
            prepaClient();
        break;
        case "update":
            updateClient();
        break;
        case "relance":
            RelanceClient();
        break;
        default:
            accueil();
    }
    
    return;
}
else{
    accueil();
    return;
}
?>