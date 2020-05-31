<?php

include("../class/config.php");

$respond = new stdClass();
$respond->code = 0;
$respond->message = "noMessage";
$respond->nextAction = "";
$respond->value = null;


try {

    $type = $_POST['type'];
    if (!isset($type)) {
        return;
    }
   
    if ($type == 'addPanier') {
        $idmovie = $_SESSION['idmovie_selected'];
        if (isset($idmovie))
        {
            array_push($_SESSION['panier'], $idmovie);
            $respond->code = 1;
            $respond->message = "Le film a été ajouté au panier.";
        }
        else{
            $respond->code = -1;
            $respond->message = "L'ajout n'a pas pu être effectué.";
        }
    }

    if ($type == 'delPanier') {
        $idmovie = $_POST['movie'];
        if (isset($idmovie))
        {
            // Use unset() function delete 
            $key = array_search($idmovie, $_SESSION['panier']);
            unset($_SESSION['panier'][$key]); 
            $respond->code = 1;
            $respond->message = "Le film a été supprimé du panier";
        }
        else{
            $respond->code = -1;
            $respond->message = "Le serveur a rencontré une erreur";
        }
    }

    if ($type == 'get') {
        try {
            $respond->code = 1;
            $respond->message = "OK";
            $respond->value =  AbonneService::GetPanier();
        } catch (Exception $ex) {
            $respond->code = -1;
            $respond->message = $ex->message;
            $respond->value = null;
        }
    }
    if ($type == 'viderPanier') {
        $_SESSION['panier'] = array();
        $respond->code = 1;
        $respond->message = "Le panier a été vidé";
    }
    if ($type == 'save') {
        try {

            $message = AbonneService::SavePanier();
            if (strcmp($message,"")==0)
            {
                // on vide le panier
                $_SESSION['panier'] = array();
                $respond->code = 1;
                $respond->message = "Le panier a été enregistré";
            }
            else{
                $respond->code = -1;
                $respond->message = $message;
            }
        } catch (Exception $ex) {
            $respond->code = -1;
            $respond->message = $ex->message;
            $respond->value = null;
        }
    }
    

} 
catch (Exception $e) {
 $respond->code= -5;
 $respond->message= "Le site a rencontré un problème";
}

$myResponsJSON = json_encode($respond,JSON_INVALID_UTF8_IGNORE);
echo $myResponsJSON;	