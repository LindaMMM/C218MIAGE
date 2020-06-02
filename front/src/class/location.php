<?php

/**
 * user
 *
 * @author lmartin
 */
class Location implements JsonSerializable
{
    private $mydb = null;
    protected $idclient, $id = 0 ;
    protected $datelocation;
    protected $film = array();
    protected $valid = false;
    
    public function __construct($dbb)
    {
        $this->datelocation = date("Y-m-d");
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
            'idClient' => $this->idClient,
            'datelocation' => $this->datelocation,
            'film' => $this->film
        );
        return $arrayVar;
    }

    // retourne les films dans le paniers
    public function getPanier()
    {
        $listeFilm = array();
        try {
            foreach ($_SESSION['panier'] as $value) {
                //commandes
                if (isset($value)) {
                    $valFilm = new stdClass();

                    // get film 
                    $valFilm->film = MovieService::GetMovieById($value, $this->mydb);
                    // get stock
                    $valFilm->stock = MovieService::GetMovieStockById($value, $this->mydb);
                    // ok or not 
                    $valFilm->valid =  $valFilm->stock->getNbstock() > 0;
                    array_push($listeFilm, $valFilm);
                }
            }
        } catch (Exception $e) {
        }

        return $listeFilm;
    }

    public function getbyId($id)
    {
        try {

            $query = "SELECT `idlocation`, `dateLocation`, `Client_idClient` FROM `location` where idlocation=?";

            $result = $this->mydb->fetchAll($query, $id);
            if ($result && count($result) > 0) {
                $this->id = ($result[0]->idlocation);
                $this->idclient = ($result[0]->Client_idClient);
                $this->image = ($result[0]->dateLocation);
                $this->film = $this->getfilms();
                $this->valid = true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }

    private function getfilms()
    {
        try {
            $query = "SELECT st.idMovie , m.name as title, `dateSend`, `datecomeback`, `daterealcomeback`
                FROM `stockmovie_has_location` l 
                inner join stockmovie st on st.idstockMovie = l.stockMovie_idstockMovie
                inner join movie m on m.idMovie = st.idMovie
                where l.location_idlocation=?";

            $result = $this->mydb->fetchAll($query, $this->id);
            if ($result && count($result) > 0) {
                return $result;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }


    public function isValid()
    {
        return  $this->getValid();
    }


    public function getAllbyIdClient($idClient)
    {
        $query = "SELECT `idlocation`, `dateLocation`, `Client_idClient` FROM `location` where `Client_idClient` = ?";
        $result = $this->mydb->fetchAll($query,$idClient);
        if ($result && count($result) > 0) {
            return $result;
        }
        return null;
    }

    public function checkClient($Client){
        try{
            if ($Client->idforfait != null)
            {
                $forfait = new Forfait($this->mydb);
                $forfait->getbyId($Client->idforfait);
            
                // lecture de nombre de film en cours de location
                $count = intval($this->countLocationByIdClient($Client->id));

                $countlocationPossible =  intval($forfait->getNbfilm()) - $count ;

                return count($_SESSION['panier'])< $countlocationPossible;
            }
        }
        catch (Exception $e) {
        }
        return false;
    }
    public function countLocationByIdClient($idClient){
        $query = "SELECT count(*) as count  from location l 
        inner join stockmovie_has_location s on l.idlocation = s.location_idlocation
        where l.Client_idClient = ? and s.datecomeback is null";

        $result = $this->mydb->fetchAll($query,$idClient);
    
        if ($result && count($result) > 0) {
            return $result[0]->count;
        }
        return 152;
    }

    public function add($Client)
    {
        $queryInsert = " INSERT INTO `location` ( `dateLocation`, `Client_idClient`) VALUES (now(), ?)";
        if ($this->mydb->execReturnBool($queryInsert, $Client->id ) != false) {
            $this->id= $this->mydb->lastInsertId();
            $this->addFilms($Client->id);
            return true;
        }
        return false;
    }

    public function addFilms($idClient)
    {    

        $queryInsert = " INSERT INTO `stockmovie_has_location`  (`stockMovie_idstockMovie`, `location_idlocation`) VALUES (?, ?)";   
        foreach ($_SESSION['panier'] as $value) {
            //commandes
            if (isset($value)) {

                // get stock
                $stock = MovieService::GetMovieStockById($value, $this->mydb);
                if ($stock->consomme() && $stock->update($stock))
                {
                    if ($this->mydb->execReturnBool($queryInsert,  $stock->getId(), $this->id ) == false) {   
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
        }
        return true;
    }


    
}
