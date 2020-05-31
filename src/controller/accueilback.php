<?php

function listUser() {
    if (isset($_SESSION["iduser"])) {
        require(__DIR_PARENT__ .'src/viewsback/listUserView.php');
    }
    else{
        require(__DIR_PARENT__ .'src/viewsback/loginView.php');
    }
}

function listmovie() {
    if (isset($_SESSION["iduser"])) {
    require(__DIR_PARENT__ .'src/viewsback/listMovieView.php');
    }
    else{
        require(__DIR_PARENT__ .'src/viewsback/loginView.php');
    }
}

function accueil() {
    if (isset($_SESSION["iduser"])) {
    require(__DIR_PARENT__ .'src/viewsback/indexView.php');
}
    else{
        require(__DIR_PARENT__ .'src/viewsback/loginView.php');
    }
}

function login() {
    require(__DIR_PARENT__ .'src/viewsback/loginView.php');
}


function prepaClient() {
    if (isset($_SESSION["iduser"])) {
    require(__DIR_PARENT__ .'src/viewsback/mainFront.php');
}
    else{
        require(__DIR_PARENT__ .'src/viewsback/loginView.php');
    }
}

function updateClient() {
    if (isset($_SESSION["iduser"])) {
    require(__DIR_PARENT__ .'src/viewsback/mainFront.php');
}
    else{
        require(__DIR_PARENT__ .'src/viewsback/loginView.php');
    }
}

function RelanceClient() {
    if (isset($_SESSION["iduser"])) {
    require(__DIR_PARENT__ .'src/viewsback/mainFront.php');
}
    else{
        require(__DIR_PARENT__ .'src/viewsback/loginView.php');
    }
}