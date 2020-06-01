<?php
include("../class/config.php");

$respond = new stdClass();
$respond->code = 0;
$respond->message = "email n'est pas valide";
function searchRole($arr, $val){
    $result = false;
    foreach ($arr as $value){
        $code =$value->codRole;
        if(strcmp($code,$val)==0)
        {
            $result = true;
        }
    }
    return $result;
};

try {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $view = $_POST['view'];

    if (!isset($email)) {
        $respond->code = -1;
        $respond->message = "Aucune saisie";
        echo json_encode($respond);
        return;
    }


    $user = UserService::Check($email, $pwd);
    if ($user->isValid()) {
        $respond->code = 1;
        $respond->message = "Login ok ";
        $_SESSION["email"] = $email;
        $_SESSION["iduser"] = $user->getId();
        $_SESSION["user_roles"] = $user->getRoles();
        $_SESSION['ismanager'] = false;
        $_SESSION['isadmin'] = false;
        if (isset($view)) {
            if (strcmp($view, 'front') == 0) {
                if (searchRole($_SESSION["user_roles"], "CLI")) {
                    // connexion d'un client
                    $_SESSION['panier'] = array();
                    $_SESSION['client'] =  json_encode($user->getClient());
                }
                else{
                    unset($_SESSION["iduser"]);
                    unset($_SESSION["user_roles"]);
        
                    $respond->code = -1;
                    $respond->message = "Ce compte n'est pas valide.";
                }
            } 
            else if (strcmp($view, 'back') !== 0) {
                
                if (searchRole($_SESSION["user_roles"], "ADM")) { 
                    $_SESSION['isadmin'] = true;
                }

                if (searchRole($_SESSION["user_roles"], "MNG")) { 
                    $_SESSION['ismanager'] = true;
                }

                if (!$_SESSION['ismanager'] && !$_SESSION['ismanager']) {
                    unset($_SESSION["iduser"]);
                    unset($_SESSION["user_roles"]);
        
                    $respond->code = -1;
                    $respond->message = "Ce compte n'est pas valide.";
                }
            } 
            else {
                unset($_SESSION["iduser"]);
                unset($_SESSION["user_roles"]);
                $respond->code = -1;
                $respond->message = "Une erreur serveur est apparue.";
            }
        } else {
            unset($_SESSION["iduser"]);
            unset($_SESSION["user_roles"]);
            $respond->code = -1;
            $respond->message = "Une erreur serveur est apparue.";
        }
    } else {
        /* le mot de passe n'est pas valide*/
        $respond->code = -2;
        $respond->message = "Votre Login ou mot de passe ne sont pas correctes";
    }
} catch (Exception $e) {
    $respond->code = -5;
    $respond->message = "Le site a rencontré un problème";
}

$myResponsJSON = json_encode($respond);
echo $myResponsJSON;
