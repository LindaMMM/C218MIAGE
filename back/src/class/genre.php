<?php

class Genre implements JsonSerializable
{

  private $mydb = null;
  protected $id = 0;
  protected $name = '';
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
      'name' => $this->name
    );
    return $arrayVar;
  }

  public function getAll()
  {
    try {

      $query = "SELECT idgenre as id, name  FROM genre ";

      $result = $this->mydb->fetchAll($query);
      if ($result && count($result) > 0) {
        return $result;
      }
    } catch (Exception $e) {
    }

    return null;
  }

  public function getbyid($id)
  {
    try {

      $query = "SELECT idgenre, name  FROM genre where idgenre = ?";

      $result = $this->mydb->fetchAll($query, $id);
      if ($result && count($result) > 0) {
        $this->setId($result[0]->idgenre);
        $this->setName($result[0]->name);
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

  public function getMovieGenre($idMovie){
    try {

      $query = "SELECT g.idgenre, g.name  FROM  genre g 
      inner join movie_has_genre m on m.genre_idgenre = g.idgenre
      where  m.Movie_idMovie  = ? ";

      $result = $this->mydb->fetchAll($query, $idMovie);
      if ($result && count($result) > 0) {
        return $result;
      }
    } catch (Exception $e) {
    }

    return null;
  }
}
