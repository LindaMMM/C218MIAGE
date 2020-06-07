<?php
/**
 * user
 *
 * @author lmartin
 */
 class RoleApp implements JsonSerializable {

    private $mydb = null;
    protected $id = 0; 
    protected $code,$name='';
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
        'code' => $this->code,
        'name' => $this->name,
      );
      return $arrayVar;
  }
  
  
	
		
	public function isValid()
	{
		return  $this->getValid();
    }
    
    public function getAll()
    {
        $query="SELECT code, name FROM role_app";
        $result = $this->mydb->fetchAll($query);

        if ($result && count($result)> 0 )
        {
            return $result;
        }
        
        return null;
    }

    public function GetAllBackOffice()
    {
        $query="SELECT code, name FROM role_app where code <> 'CLI'";
        $result = $this->mydb->fetchAll($query);

        if ($result && count($result)> 0 )
        {
            return $result;
        }
        
        return null;
    }
    
    
    public function delete($value){

    }
    
    public function add($value){
        
    }

    public function update($value){
        
    }


}
