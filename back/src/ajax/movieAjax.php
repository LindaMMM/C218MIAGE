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

    if ($type == 'list') {
        $start = 0;
        $length = 10;
        if (
            isset($_POST['start']) && is_numeric($_POST['start'])
            && is_int($_POST['start'] + 0)
        ) {
            $start = (int) $_POST['start'];
        }
        if (
            isset($_POST['length']) && is_numeric($_POST['length'])
            && is_int($_POST['length'] + 0)
        ) {
            $length = (int) $_POST['length'];
        }
        $filter = $_POST['search']['value'];


        $bd = new Database(DB_DVD);
        $movie = new Movie($bd);

        $countTotal = $movie->getCountAll("");
        $countfilter = $movie->getCountAll($filter);
        $order = '';

        /*Ordre*/
        if (isset($_POST['order']) && is_array($_POST['order']) && isset($_POST['columns']) && is_array($_POST['columns'])) {
            foreach ($_POST['order'] as $od) {
                //commandes
                if (array_key_exists($od['column'], $_POST['columns'])) {
                    $direction = $od['dir'];
                    $col = $_POST['columns'][$od['column']]['data'];
                    $order .= ' ' . $col . ' ' . $direction;
                }
            }
        }
        /*Recherche la liste des connections définis*/
        $output = array(
            "draw" => $_POST['draw'],
            // "iTotalRecords" => $iTotal,
            "iTotalRecords" => $countTotal,
            "iTotalDisplayRecords" => $countfilter,
            "aaData" => array()
        );

        $result = $movie->GetAll($start, $length, $filter, $order);

        $rows = array();
        foreach ($result as $value) {
            $value->DT_RowId = $value->idmovie;
            $output['aaData'][] = $value;
        }

        //$output['aaData'] = $result;
        echo json_encode($output);
        return;
    }

    if ($type == 'top4') {

        $liste = MovieService::GetTop4();
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "Le trop 4 trouvé";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Le serveur ne trouve pas le top 4";
        }
        //echo json_encode($respond);
        //return;
    }

    if ($type == 'child4') {

        $liste = MovieService::GetChild4();
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "Le trop 4 trouvé";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Le serveur ne trouve pas le top 4";
        }
        //echo json_encode($respond);
        //return;
    }

    if ($type == 'best4') {

        $liste = MovieService::GetBest4();
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "Le trop 4 trouvé";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Le serveur ne trouve pas le top 4";
        }
        //echo json_encode($respond);
        //return;
    }
    if ($type == 'listForfait') {

        $liste = MovieService::GetAllForfait();
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "les forfaits ont été trouvé";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Auncun forfait";
        }
        //echo json_encode($respond);
        //return;
    }

    if ($type == 'listCategorie') {

        $liste = MovieService::GetAllCategorie();
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "les catégories ont été trouvé";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Auncun catégorie";
        }
        //echo json_encode($respond);
        //return;
    }


    if ($type == 'listGenre') {

        $liste = MovieService::GetAllGenre();
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "les genres ont était trouvés";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Auncun genre";
        }
        //echo json_encode($respond);
        //return;
    }

    if ($type == 'search') {
        $filter = $_POST['filter'];
        $valfiltre = "";
        if (isset($filter)) {
            $valfiltre = json_decode($filter);
        }

        $liste = MovieService::GetAllMovie($valfiltre);
        if ($liste != false) {
            $respond->code = 1;
            $respond->message = "Films trouvés";
            $respond->value = $liste;
        } else {
            $respond->code = -1;
            $respond->message = "Auncun Film";
        }
    }

    if ($type == 'get') {
        try {
            if (!isset($_POST["id"])) {
                return;
            }
            $idget = $_POST["id"];
            $respond->code = 1;
            $respond->message = "OK";
            $respond->value = MovieService::GetMovieById($idget,null);
        } catch (Exception $ex) {
            $respond->code = -1;
            $respond->message = $ex->message;
            $respond->value = null;
        }
    }
} catch (Exception $e) {
    $respond->code = -5;
    $respond->message = "Le site a rencontré un problème";
}

$myResponsJSON = json_encode($respond, JSON_INVALID_UTF8_IGNORE);
echo $myResponsJSON;
