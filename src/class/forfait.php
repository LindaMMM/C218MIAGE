<?php
/**
 * user
 *
 * @author lmartin
 */
 class Forfait implements JsonSerializable {

    private $mydb = null;
    protected $id = 0; 
    protected $name;
    protected $nbfile = 0;
    protected $price = 0.0;
    protected $actif = true;
	protected $valid =false;
 
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
        'name' => $this->name,
         'price' => $this->price,
         'nbfilm' => $this->nbfile
      );
      return $arrayVar;
  }
  
  
	
	public function getbyId($id)
    {
        try 
        {
            $query = "SELECT `idForfait`, `name`, `nbfile`, `Price`, `active` FROM `forfait` where `idForfait` = ?";
        
        $result = $this->mydb->fetchAll($query,$id);
        if ($result && count($result)> 0 )
        {
            $this->id=($result[0]->idForfait);
            $this->name=($result[0]->name);
            $this->nbfile=($result[0]->nbfile);
            $this->price=($result[0]->Price);
            $this->actif=($result[0]->active);
            $this->valid = true;
        }
       
        }  
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        
        return ;
    }

	public function isValid()
	{
		return  $this->getValid();
    }
    
 
    public function getAll($actif=true)
    {
        $query = "SELECT `idForfait`, `name`, `nbfile`, `Price`, `active` FROM `forfait` where `active` = ?";
        $result = $this->mydb->fetchAll($query,$actif);
        if ($result && count($result)> 0 )
        {
            return $result;
        }

        return null;
    }
    
    public function delete($id){

    }
    
    public function add($value){

        $queryInsert = "INSERT INTO `forfait` ( `name`, `nbfile`, `Price`, `active`) VALUES (?, ?, ? , ? ,1)";
        $count = $this->mydb->execReturnBool($queryInsert,$value->name,$value->nbfilm,$value->price);
        if ($count === true)
        {
            $this->id = $this->mydb->lastInsertId();
            return true;
        }
        return false;
    }

    public function update($value){
        $queryUpdate= "update `forfait` set `active` = ? where idForfait = ? ";
        return ($this->mydb->execReturnBool($queryUpdate,$value->active,$value->id));
    }
}
