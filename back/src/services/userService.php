<?php

/**
 * UserService
 *
 * @author lmartin
 */

 class UserService  {

    public static function Check($email,$pwd)
    {
        $bd= new Database(DB_DVD);
        $user= new UserApp($bd);
        $user->getbyLogin($email);
        $user->checkPwd($pwd);
		return $user;
    }
    
    public static function DeleteUser($user_val)
    {
        $bd= new Database(DB_DVD);
        $user= new UserApp($bd);
        $user->delete($user_val->id);
       
        return $user;
    }
    
    public static function AddUser($user_val)
    {
        $bd= new Database(DB_DVD);
        $user= new UserApp($bd);
        if ($user_val->id==0)
        {
             $user->add($user_val);
             return $user;
        }
        else {
            $user->getbyId($user_val->id);
            $user->update($user_val);
            return $user;
        }       
    }

    public static function GetUserById($id)
    {
        $bd= new Database(DB_DVD);
        $user= new UserApp($bd);
        $user->getbyId($id);
        $user->getRoles();
        return $user;
    }

    public static function GetAllRole($typeRole)
    {
        $bd= new Database(DB_DVD);
        $role= new RoleApp($bd);
        if(isset($typeRole)&& strcmp($typeRole,'back')==0)
        {
            return  $role->GetAllBackOffice();
        }
        return  $role->GetAll();
    }
    
    public static function getClientbyIdUser($id,$dbb){
        if (isset($dbb))
        {
            $clt= new Client($dbb);
        }
        else
        {
            $bd= new Database(DB_DVD);
            $clt= new Client($bd);
        }
        $clt->getbyIdUser($id);
        return $clt;
    }
    
    /**
     * CreateClient
     *
     * @param  mixed $client
     * @return boolean 
     */
    public static function CreateClient($client){
        $bd= new Database(DB_DVD);
        $clt= new Client($bd);
        $user= new UserApp($bd);
        if ($bd->beginTransaction())
        {
            $user_val = new stdClass();
            $user_val->email = $client->email;
            $user_val->firstname = $client->firstname;
            $user_val->lastname =  $client->lastname;
            $user_val->pwd =  $client->pwd;
            $user_val->roles =  'client';
            if ($user->add($user_val))
            {
                $client->iduser= $user->getId();
                if ($clt->add($client)){
                    if ($bd->commit())
                        return true;
                }
            }
            $bd->rollBack();
        }
        return  false;
    }
    
}
