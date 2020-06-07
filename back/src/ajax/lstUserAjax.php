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

    if ($type == 'listRole') {
        
        $listRole = UserService::GetAllRole($_POST['role']);
        $respond->code = 1;
        $respond->message = "liste des roles";
        $respond->value = json_encode($listRole);
    }

    if ($type == 'list') {
        $role = $_POST['role'];
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
        $user = new UserApp($bd);



        $countTotal = $user->getCountAll("", $role );
        $countfilter = $user->getCountAll($filter, $role);
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

        $result = $user->GetAll($start, $length, $filter, $order,$role);

        $rows = array();
        foreach ($result as $value) {
            $value->DT_RowId = $value->iduser;
            $output['aaData'][] = $value;
        }

        //$output['aaData'] = $result;
        echo json_encode($output);
        return;
    }

    if ($type == 'get') {
        try {
            if (!isset($_POST["id"])) {
                return;
            }
            $id = $_POST["id"];
            $respond->code = 1;
            $respond->message = "OK";
            $respond->value = UserService::GetUserById($id);
        } catch (Exception $ex) {
            $respond->code = -1;
            $respond->message = $ex->message;
            $respond->value = null;
        }
    }

    if ($type == 'add') {
        try {
            if (!isset($_POST["user"])) {
                return;
            }
            $input = $_POST['user'];
            $value = json_decode($input);

            $respond->code = 1;
            if ($value->id != 0) {
                $respond->message = "La mise à jour de l'utilisateur est effectuée";
            } else {
                $respond->message = "L'ajout de l'utilisateur est effectué";
            }
            $respond->value = UserService::AddUser($value);
        } catch (Exception $ex) {
            $respond->code = -1;
            $respond->message = $ex->getMessage();
            $respond->value = null;
        }
    }

    if ($type == 'delete') {
        try {
            $input = $_POST['user'];
            $respond->code = 1;
            $respond->message = "La supression de l'utilisateur est effectuée";
            $value = json_decode($input);
            $respond->value = UserService::DeleteUser($value);
        } catch (Exception $ex) {
            $respond->code = -1;
            $respond->message = $ex->getMessage();
            $respond->value = null;
        }
    }
} catch (Exception $e) {
    $respond->code = -5;
    $respond->message = "Le site a rencontré un problème";
}

$myResponsJSON = json_encode($respond);
echo $myResponsJSON;
