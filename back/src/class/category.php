<?php
/**
 * user
 *
 * @author lmartin
 */
 class Category implements JsonSerializable {

    private $mydb = null;
    protected $id = 0; 
    protected $name,$image='';
    protected $age='';
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
        'name' => $this->name,
         'image' => $this->image,
         'age' => $this->age
      );
      return $arrayVar;
  }
  
  
	
	public function getbyId($id)
    {
        try 
        {
        
            $query="SELECT `idcategory`,`Name`, `image`,`age` FROM `category` where `idcategory` =?";

        

        $result = $this->mydb->fetchAll($query,$id);
        if ($result && count($result)> 0 )
        {
            $this->id=($result[0]->idcategory);
            $this->name=($result[0]->Name);
            $this->image=($result[0]->image);
            $this->age=($result[0]->age);
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
    
 
    public function getAll()
    {
        $query="SELECT `idcategory` as id,`Name` as name, `image`,`age` FROM `category` ";
        $result = $this->mydb->fetchAll($query);
        if ($result && count($result)> 0 )
        {
            return $result;
        }
        
        return null;
    }
    
    
    public function delete($id){

    }
    
    public function add($value){
        
    }

    public function update($value){
        
    }


}
