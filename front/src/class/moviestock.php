<?php
/**
 * user
 *
 * @author lmartin
 */
 class MovieStock implements JsonSerializable {

    private $mydb = null;
    protected $id, $idmovie = 0; 
    protected $refproduct='';
    protected $nbstock, $nbwait, $nbsend =0;
    protected $valid=false;
 
    public function __construct($dbb){
        $this->setMydb($dbb);
    }
  
  function __call($m,$p) {
          $v = strtolower(substr($m,3));
          if (!strncasecmp($m,'get',3) && !in_array($v,$this->private))
          {
              return $this->$v;
          }
          if (!strncasecmp($m,'set',3) && !in_array($v,$this->private)) 
          {
              $this->$v = $p[0];
          }
  }
  
  public function jsonSerialize()
  {
      $arrayVar = array(
        'id' => $this->id,
        'idmovie' => $this->idmovie,
        'refproduct' => $this->refproduct,
        'nbstock' => $this->nbstock,
        'nbwait' => $this->nbwait,
        'nbsend' => $this->nbsend,
      );
      return $arrayVar;
  }
  
	public function isValid()
	{
		return  $this->getValid();
    }
   
    public function getbyIdMovie($id){
        try {
            
            $query = "SELECT `idstockMovie`,
            `idMovie`,
            `refProduit`,
            `nbStock`,
            `nbwaitSend`,
            `nbSend`  FROM `stockmovie` where idMovie = ?";
      
            $result = $this->mydb->fetchAll($query, $id);
            if ($result && count($result) > 0) {
              $this->id= ($result[0]->idstockMovie);
              $this->refproduct= ($result[0]->refProduit);
              $this->nbstock = ($result[0]->nbStock);
              $this->nbwaitSend = ($result[0]->nbwaitSend);
              $this->nbsend = ($result[0]->nbSend);
              $this->valid = true;
            }
          } catch (Exception $e) {
            echo $e->getMessage();
          }
      
          return;
    }

    public function add($value){
        
        $queryInsert = " INSERT INTO `stockmovie` (`idMovie`, `refProduit`, `nbStock`, `nbwaitSend`, `nbSend`)  VALUES ( ?, ?, ?, 0, 0)";
        if ($this->mydb->execReturnBool($queryInsert, $value->idMovie, $value->refProduit, $value->nbStock ) != false) {
            $this->id= $this->mydb->lastInsertId();
            return true;
        }
        return false;
    }

    public function consomme(){
        if($this->nbstock > 1)
        {
         $this->nbwait++;
         $this->nbstock--;
         return true;
        }
        return false;
    }
    
    public function send(){
        if($this->nbwait>1)
        {
        $this->nbwait--;
        $this->nbsend++;
        return true;
        }
        return false;
   }
   
   public function comeback(){
    if($this->nbsend>1)
    {
    $this->nbstock++;
    $this->nbsend--;
    }
    return false;
    }
    
    public function update($value){
        $queryInsert = " UPDATE `stockmovie`  SET `nbStock` = ?, `nbwaitSend` = ?,   `nbSend` = ?  WHERE `idstockMovie` = ?";
        if ($this->mydb->execReturnBool($queryInsert, $value->nbstock,  $value->nbwait, $value->nbsend, $value->id ) != false) {
            return true;
        }
        return false;
    }
}
