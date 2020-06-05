<?php

function listUser() {
    if (isset($_SESSION["iduser"])) {
        require('./src/viewsback/listUserView.php');
    }
    else{
        require('./src/viewsback/loginView.php');
    }
}

function listmovie() {
    if (isset($_SESSION["iduser"])) {
    require('./src/viewsback/listMovieView.php');
    }
    else{
        require('./src/viewsback/loginView.php');
    }
}

function accueil() {
    if (isset($_SESSION["iduser"])) {
    
        require('./src/viewsback/indexView.php');
    }
    else{
        require('./src/viewsback/loginView.php');
    }
}

function login() {
    require('./src/viewsback/loginView.php');
}


function prepaClient() {
    if (isset($_SESSION["iduser"])) {
    require('./src/viewsback/indexClient.php');
}
    else{
        require('./src/viewsback/loginView.php');
    }
}

function updateClient() {
    if (isset($_SESSION["iduser"])) {
    require('./src/viewsback/indexClient.php');
}
    else{
        require('./src/viewsback/loginView.php');
    }
}

function relanceClient() {
    if (isset($_SESSION["iduser"])) {
    require('./src/viewsback/indexClient.php');
}
    else{
        require('./src/viewsback/loginView.php');
    }
}