<?php

function accueil() {
    $_SESSION['page']='accueil'; 
    require('./src/views/mainfront.php');
}

function child() {
    $_SESSION['page']='child'; 
    require('./src/views/mainfront.php');
}

function best() {
    $_SESSION['page']='best'; 
    require('./src/views/mainfront.php');
}

function login() {
require('./src/views/loginView.php');
}

function register(){
    require('./src/views/registerView.php');
}


function fiche(){
    require('./src/views/ficheView.php');
}

function ficheClient(){
    require('./src/views/ficheClientView.php');
}

function search(){
    require('./src/views/searchView.php');
}

function panier(){
    require('./src/views/panierView.php');
}
