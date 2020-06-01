<?php
function accueil() {
    require('../src/views/mainFront.php');
}

function login() {
require('../src/views/loginView.php');
}

function register(){
    require('../src/views/registerView.php');
}


function fiche(){
    require('../src/views/ficheView.php');
}

function ficheClient(){
    require('../src/views/ficheClientView.php');
}

function search(){
    require('../src/views/searchView.php');
}

function panier(){
    require('../src/views/panierView.php');
}
