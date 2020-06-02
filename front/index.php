<?php
try{
   
    require_once "./src/class/config.php";
    require('./src/controller/accueil.php');
    date_default_timezone_set('Europe/Paris');
    
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch($page){
            case "login":
                login();
            break;
            case "acceuil":
                accueil();
            break;
            case "panier":
                panier();
            break;
            case "search":
                if (isset($_GET['val']))
                {
                    $_SESSION['search']=$_GET['val'];
                }
                search();
            break;
            case "ficheclient":
                ficheClient();
            break;
            case "fiche":
                // fiche du film
                if (isset($_GET['nb']))
                {
                    $nb = $_GET['nb'];
                    $id = substr ($nb,7);
                    $_SESSION['idmovie_selected']=$id;
                    fiche();
                }
                else{
                    accueil();
                }
            break;
            case "register":
                register();
            break;
            
            case "child":
                child();
            break;

            case "best":
                best();
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
}
catch(Exception $e)
{
    error_log("[Index.php]"+$e->getMessage(), 0);
}

?>