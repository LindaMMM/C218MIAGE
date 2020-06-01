<?php

/**
 * user
 *
 * @author lmartin
 */
class Client implements JsonSerializable
{

    private $mydb = null;
    protected $id, $idUser, $idforfait = 0;
    protected $adress, $codPostal, $ville, $pays, $mobile = '';
    protected $datestop = '';
    protected $valid = false;
    protected $user = null;

    public function __construct($dbb)
    {
        $this->setMydb($dbb);
    }

    function __call($m, $p)
    {
        $v = strtolower(substr($m, 3));
        if (!strncasecmp($m, 'get', 3) && !in_array($v, $this->private)) {
            return $this->$v;
        }
        if (!strncasecmp($m, 'set', 3) && !in_array($v, $this->private)) {
            $this->$v = $p[0];
        }
    }

    public function jsonSerialize()
    {
        $arrayVar = array(
            'id' => $this->id,
            'user' => $this->user,
            'idforfait' => $this->idforfait,
            'adress' => $this->adress,
            'codpostal' => $this->codPostal,
            'ville' => $this->ville,
            'pays' => $this->pays,
            'phone' => $this->mobile,
        );
        return $arrayVar;
    }
    public function getbyIdUser($id)
    {
        try {

            $query = "SELECT `idClient`,`iduser`, `idForfait`,`adresse`, `codePostal`, `ville`, `Pays`, `mobileNum`, `dateEnd`  FROM `client` where `iduser` =?";

            $result = $this->mydb->fetchAll($query, $id);
            if ($result && count($result) > 0) {
                $this->id = ($result[0]->idClient);
                $this->idforfait = ($result[0]->idForfait);
                $this->idUser = ($result[0]->iduser);
                $this->adress = ($result[0]->adresse);
                $this->codPostal = ($result[0]->codePostal);
                $this->ville = ($result[0]->ville);
                $this->pays = ($result[0]->Pays);
                $this->mobile = ($result[0]->mobileNum);
                $this->datestop = ($result[0]->dateEnd);
                $this->valid = true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }


    public function getbyId($id)
    {
        try {

            $query = "SELECT `idClient`,`iduser`, `idForfait`,`adresse`, `codePostal`, `ville`, `Pays`, `mobileNum`, `dateEnd`  FROM `client` where `idClient` =?";

            $result = $this->mydb->fetchAll($query, $id);
            if ($result && count($result) > 0) {
                $this->id = ($result[0]->idClient);
                $this->idforfait = ($result[0]->idForfait);
                $this->idUser = ($result[0]->iduser);
                $this->adress = ($result[0]->adresse);
                $this->codPostal = ($result[0]->codePostal);
                $this->ville = ($result[0]->ville);
                $this->pays = ($result[0]->Pays);
                $this->mobile = ($result[0]->mobileNum);
                $this->datestop = ($result[0]->dateEnd);
                $this->valid = true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }

    public function isValid()
    {
        return  $this->getValid();
    }


    public function getAll()
    {
        $query = "SELECT `idClient`,`iduser`, `idForfait`,`adresse`,`codePostal`, `ville`, `Pays`, `mobileNum`, `dateEnd`  FROM `client` ";
        $result = $this->mydb->fetchAll($query);
        if ($result && count($result) > 0) {
            return $result;
        }

        return null;
    }


    public function delete($id)
    {
        $query = "delete from `client` where `idClient` = ?";
        return $this->mydb->execReturnBool($query, $id);
    }

    public function add($value)
    {
        $daynull = date("0000-00-00 00:00:00");
        $queryInsert = " INSERT INTO `client` ( `iduser`, `idForfait`, `adresse`, `codePostal`, `ville`, `Pays`, `mobileNum`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($this->mydb->execReturnBool($queryInsert, $value->iduser, $value->forfait, $value->adress ,$value->codpostal,$value->ville,$value->pays, $value->phone ) != false) {
            $this->id= $this->mydb->lastInsertId();
            return true;
        }
        return false;
    }

    public function update($value)
    {
        $queryInsert = " Update `client` set  `iduser` = ? , `idForfait`=?, `adresse`=?, `codePostal`=?, `ville`=?, `Pays`=?, `mobileNum`=? where `idClient` = ?";
        if ($this->mydb->execReturnBool($queryInsert, $value->iduser, $value->idforfait, $value->adresse ,$value->codpostal,$value->ville,$value->pays, $value->mobile,$value->id ) != false) {
            return true;
        }
        return false;
    }
}
