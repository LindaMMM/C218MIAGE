<?php

/**
 * user
 *
 * @author lmartin
 */
class Movie implements JsonSerializable
{

    private $mydb = null;
    protected $id = 0;
    protected $note = 0;
    protected $name, $description, $affiche, $video, $realisateur, $producteur = '';
    protected $dateOut = '';
    protected $actif = false;
    protected $categorie = null;
    protected $stock = null;
    protected $genres = [];
    protected $valid = false;

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
            'title' => $this->name,
            'desc' => $this->description,
            'dtOut' => $this->dateOut->format('Y-m-d'),
            'view' => $this->affiche,
            'video' => $this->video,
            'classif' => $this->categorie,
            'genres' => $this->genres,
            'actif' => $this->actif,
            'producteur' => $this->producteur,
            'realisateur' => $this->realisateur,
            'note' => $this->note,
            'stock'=> $this->stock
        );
        return $arrayVar;
    }

    public function isValid()
    {
        return  $this->getValid();
    }

    public function getCountAll($filter)
    {
        if (isset($filter) && !empty($filter)) {

            $query = "SELECT count(*) as count from movie where  (`name` REGEXP ? or `description` REGEXP ? or Realisateur  REGEXP ?  ) order by `name`";

            $result = $this->mydb->fetchAll($query, $filter, $filter, $filter);
        } else {

            $query = "SELECT count(*) as count from movie ";

            $result = $this->mydb->fetchAll($query);
        }
        if ($result && count($result) > 0) {
            return $result[0]->count;
        }

        return 0;
    }

    public function getAll($compteur, $nbligne, $filter, $order)
    {
        if (isset($filter) && !empty($filter) && isset($order) && !empty($order)) {
            $query = "SELECT idMovie, `name`, `description`,  `dateout`, `Realisateur`   from movie where  (`name` REGEXP ? or `description` REGEXP ? or Realisateur  REGEXP ?  )  order by ? limit ?, ?";

            $result = $this->mydb->fetchAll($query, $filter, $filter, $filter, $order, (int) $compteur, (int) $nbligne);
        } else if (isset($filter) && !empty($filter)) {
            $query = "SELECT idMovie, `name`, `description`,  `dateout`, `Realisateur`   from movie where  (`name` REGEXP ? or `description` REGEXP ? or Realisateur  REGEXP ?  ) order by name limit ?, ?";

            $result = $this->mydb->fetchAll($query, $filter, $filter, $filter, (int) $compteur, (int) $nbligne);
        } else if (isset($order) && !empty($order)) {
            $query = "SELECT  idMovie, `name`, `description`,  `dateout`, `Realisateur`   from movie  order by ? limit ?, ?";

            $result = $this->mydb->fetchAll($query, $order, (int) $compteur, (int) $nbligne);
        } else {
            $query = "SELECT  idMovie, `name`, `description`,  `dateout`, `Realisateur`   from movie  order by name limit ?, ?";

            $result = $this->mydb->fetchAll($query, (int) $compteur, (int) $nbligne);
        }
        if ($result && count($result) > 0) {
            return $result;
        }

        return null;
    }
    /**
     *  Recherche des 4 derniers films en base de donnée
     */
    public function getTop4($type)
    {
        try {

            if ($type == 'child') {
                $query = "SELECT `idMovie`,
                `idcategory`,
                `name`,
                `description`,
                `mainview`,
                `dateout`,
                `VideoBO`,
                `Realisateur`,
                `Producteur`,
                `movieActive` FROM `movie` where movieActive = 1 and idcategory = 1 order by idMovie desc limit 4";
            } else if ($type == 'best') {
                $query = "SELECT `idMovie`,
                `idcategory`,
                `name`,
                `description`,
                `mainview`,
                `dateout`,
                `VideoBO`,
                `Realisateur`,
                `Producteur`,
                `movieActive` FROM `movie` where movieActive = 1 order by note desc, idMovie desc limit 4";
            } else {
                $query = "SELECT `idMovie`,
            `idcategory`,
            `name`,
            `description`,
            `mainview`,
            `dateout`,
            `VideoBO`,
            `Realisateur`,
            `Producteur`,
            `movieActive` FROM `movie` where movieActive = 1 order by idMovie desc limit 4";
            }
            $result = $this->mydb->fetchAll($query);
            if ($result && count($result) > 0) {
                return $result;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }

    public function getbyId($id)
    {
        try {

            $query = "SELECT `idMovie`,
            `idcategory`,
            `name`,
            `description`,
            `mainview`,
            `dateout`,
            `VideoBO`,
            `Realisateur`,
            `Producteur`,
            `movieActive`, `note`  FROM `movie` where idMovie = ?";

            $result = $this->mydb->fetchAll($query, $id);
            if ($result && count($result) > 0) {
                $this->setId($result[0]->idMovie);
                $this->name = ($result[0]->name);
                $this->description = ($result[0]->description);
                $this->affiche = ($result[0]->mainview);
                $this->video = ($result[0]->VideoBO);
                $this->realisateur = ($result[0]->Realisateur);
                $this->producteur = ($result[0]->Producteur);
                $this->actif = ($result[0]->movieActive);
                $this->note = ($result[0]->note);
                $this->dateOut = new DateTime($result[0]->dateout);
                $this->categorie = MovieService::GetCategorie($this->mydb, $result[0]->idcategory);
                $this->genres = MovieService::GetGenre($this->mydb, $result[0]->idMovie);
                $this->stock = MovieService::GetMovieStockById($result[0]->idMovie, $this->mydb, );
                $this->valid = true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }

    public function getAllSearch($filter)
    {
        /*select m.* from movie m
inner join movie_has_genre g on g.Movie_idMovie = m.idMovie
where m.idcategory in (1) and (m.name regexp 'te' or m.realisateur regexp 'te' or m.producteur regexp 'te' )
and g.genre_idgenre in (1)*/
        if ($filter->genre != "") {
            if ($filter->search != "") {
                $search =   htmlspecialchars_decode(htmlentities($filter->search, ENT_NOQUOTES, 'UTF-8'));
                $query = "select m.* from movie m
            inner join movie_has_genre g on g.Movie_idMovie = m.idMovie
            where m.idcategory in (?) and (m.name regexp ? or m.realisateur regexp ? or m.producteur regexp ? )
            and g.genre_idgenre in (?)";
                $result = $this->mydb->fetchAll($query, $filter->categorie, $search, $search, $search, $filter->genre);
            } else {
                $query = "select m.* from movie m
            inner join movie_has_genre g on g.Movie_idMovie = m.idMovie
            where m.idcategory in (?) 
            and g.genre_idgenre in (?)";
                $result = $this->mydb->fetchAll($query, $filter->categorie, $filter->genre);
            }
            if ($result && count($result) > 0) {
                return $result;
            }
        } else {
            if ($filter->search != "") {
                $search =   htmlspecialchars_decode(htmlentities($filter->search, ENT_NOQUOTES, 'UTF-8'));
                $query = "select m.* from movie m
            where m.idcategory in (?) and (m.name regexp ? or m.realisateur regexp ? or m.producteur regexp ? )";
                $result = $this->mydb->fetchAll($query, $filter->categorie, $search, $search, $search);
            } else {
                $query = "select m.* from movie m
            where m.idcategory in (?) ";
                $result = $this->mydb->fetchAll($query, $filter->categorie);
            }
            if ($result && count($result) > 0) {
                return $result;
            }
        }
    }

    public function addGenre($value)
    {
        $genre_array = explode(', ', $value->genre );
        if (is_array($genre_array) && count($genre_array) > 0) {
            $queryInsertgenre = " INSERT INTO `movie_has_genre` (`Movie_idMovie`,`genre_idgenre`) VALUES (?, ?)";
            foreach ($genre_array as $gen) {
                
                if (isset($gen)&& $gen!="") {
                    if ($this->mydb->execReturnBool($queryInsertgenre, $this->id, $gen) == false) {
                        return false;
                    }
                }
            }
            return true;
        }
        else {
            return false;
        }
        return false;
    }

    public function clearGenre()
    {
        $querydelete = "DELETE FROM `movie_has_genre` where Movie_idMovie = ? ";
        return ($this->mydb->execReturnBool($querydelete, $this->id) != false) ;
    }
    

    public function add($value)
    {
        $queryInsert = " INSERT INTO `movie` ( `idcategory`, `name`,  `description`,  `mainview`, `dateout`,  `VideoBO`,  `Realisateur`,  `Producteur`,  `movieActive`, `note`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)";
        if ($this->mydb->execReturnBool($queryInsert, $value->idcategory, $value->title, $value->desc, $value->affiche, $value->dateout, $value->video, $value->realisateur, $value->producteur, $value->note ) != false) {
            $this->id= $this->mydb->lastInsertId();

            return $this->addGenre($value);
        }
        return false;

    }

    public function update($value)
    {
        $queryUpdate = " update `movie` set `idcategory` = ?, `name` = ?,  `description` = ?,  `mainview` = ?, `dateout` = ?,  `VideoBO` = ?,  `Realisateur` = ?,  `Producteur` = ? , `note` = ? where idMovie= ?";
        if ($this->mydb->execReturnBool($queryUpdate, $value->idcategory, $value->title, $value->desc, $value->affiche, $value->dateout, $value->video, $value->realisateur, $value->producteur, $value->note , $value->id ) != false) {
            $this->id= $value->id;
            if ($this->clearGenre())
                return $this->addGenre($value);
        }
        return false;
    }
}
