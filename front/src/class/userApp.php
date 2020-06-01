<?php

/**
 * user
 *
 * @author lmartin
 */
class UserApp implements JsonSerializable
{

    private $mydb = null;
    protected $id = 0;
    protected $email, $pwd, $firstname, $lastname = '';
    protected $pwdtmp = false;
    protected $roles = [];
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
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
            'email' => $this->email,
            'pwdtmp' => $this->pwdtmp,
            'roles' => $this->roles
        );
        return $arrayVar;
    }

    public function getbyId($id)
    {
        try {

            $query = "SELECT iduser, firstName, lastName, pwd, email, user_pwd_tmp  FROM user_app where  iduser=?";

            $result = $this->mydb->fetchAll($query, $id);
            if ($result && count($result) > 0) {
                $this->setId($result[0]->iduser);
                $this->setFirstName($result[0]->firstName);
                $this->setLastName($result[0]->lastName);
                $this->setPwd($result[0]->pwd);
                $this->setEmail($result[0]->email);
                $this->pwdtmp = ($result[0]->user_pwd_tmp);
                $this->valid = true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }


    public function getbyLogin($email)
    {
        try {

            $query = "SELECT iduser, firstName, lastName, pwd, email, user_pwd_tmp FROM user_app where  email=?";

            $result = $this->mydb->fetchAll($query, $email);
            if ($result && count($result) > 0) {
                $this->setId($result[0]->iduser);
                $this->setFirstName($result[0]->firstName);
                $this->setLastName($result[0]->lastName);
                $this->setPwd($result[0]->pwd);
                $this->setEmail($result[0]->email);
                $this->pwdtmp = ($result[0]->user_pwd_tmp);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return;
    }

    public function checkPwd($pwd)
    {

        if ($this->id == '') {
            $this->setValid(false);
        } else if ($this->pwdtmp && strcmp($this->pwd, $pwd) == 0) {

            $this->setValid(true);
            return true;
        } else if (!$this->pwdtmp && password_verify($pwd, $this->pwd)) {
            $this->setValid(true);
            return true;
        }
        return false;
    }

    public function isValid()
    {
        return  $this->getValid();
    }

    public function getCountAll($filter)
    {
        if (isset($filter) && !empty($filter)) {

            $query = "SELECT count(*) as count from user_app where  (email REGEXP ? or firstName REGEXP ? or lastName  REGEXP ?  ) order by firstname";

            $result = $this->mydb->fetchAll($query, $filter, $filter, $filter);
        } else {

            $query = "SELECT count(*) as count from user_app ";

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
            $query = "SELECT iduser, firstName, lastName,  email  FROM user_app where  (firstName REGEXP ? or lastName REGEXP ? or email REGEXP ?  ) order by ? limit ?, ?";

            $result = $this->mydb->fetchAll($query, $filter, $filter, $filter, $order, (int) $compteur, (int) $nbligne);
        } else if (isset($filter) && !empty($filter)) {
            $query = "SELECT iduser, firstName, lastName,  email  FROM user_app where  (email REGEXP ? or lastName REGEXP ? or firstName REGEXP ?  ) order by firstName limit ?, ?";

            $result = $this->mydb->fetchAll($query, $filter, $filter, $filter, (int) $compteur, (int) $nbligne);
        } else if (isset($order) && !empty($order)) {
            $query = "SELECT iduser, firstName, lastName,  email  FROM user_app order by ? limit ?, ?";

            $result = $this->mydb->fetchAll($query, $order, (int) $compteur, (int) $nbligne);
        } else {
            $query = "SELECT iduser, firstName, lastName,  email  FROM user_app  order by firstName limit ?, ?";

            $result = $this->mydb->fetchAll($query, (int) $compteur, (int) $nbligne);
        }
        if ($result && count($result) > 0) {
            return $result;
        }

        return null;
    }

    public function getRoles()
    {
        $query = "SELECT r.code as codRole  FROM role_app r
        inner join user_has_role ur on ur.idrole= r.idrole
        where ur.iduser = ?";
        $_id = intval($this->id);
        $result = $this->mydb->fetchAll($query, $_id);
        $this->roles = $result;
        return $result;
    }

    public function delete($id)
    {
    }

    public function add($value)
    {
        if ($this->testEmail($value->email)) {
            $pwdcrypt = password_hash($value->pwd, PASSWORD_DEFAULT);
            $query = "INSERT INTO `user_app` (`firstName`, `lastName`, `email`, `pwd`, `user_pwd_tmp`) VALUES (?, ?, ?, ?, 0)";
            $count = $this->mydb->execReturnBool($query,$value->firstname,$value->lastname, $value->email ,$pwdcrypt );
            if ($count === true)
            {
                $this->id = $this->mydb->lastInsertId();
                return $this->insertRole($value->roles);
            }
            
        }
    }

    public function update($value)
    {

    }

    public function testEmail($email)
    {
        $query = "SELECT count(*) as count from user_app where  email=? ";

        $result = $this->mydb->fetchAll($query, $email);
        if ($result != false) {
            return ($result[0]->count == 0);
        }
        return false;
    }

    public function clearRole(){
        return  $this->mydb->execReturnBool("delete from `user_has_role` where `iduser` = ?", $this->id);
    }

    public function insertRole($roles){
        $queryInsert = "INSERT INTO `user_has_role` (`idrole`, `iduser`) VALUES (?, ?)";

        if (is_array($roles))
        {
            foreach ($roles as &$value) {
                $result = $this->mydb->execReturnBool($queryInsert, $value,$this->id );
                if ($result == false) {
                    return (false);
                }
            }
        }
        else
        {
            $queryInsertClient = "INSERT INTO `user_has_role` (`idrole`, `iduser`) VALUES (( SELECT idrole FROM role_app where code = 'CLI' ), ?)";
            // Cas du client
            $result = $this->mydb->execReturnBool($queryInsertClient,$this->id);
                if ($result == false) {
                    return (false);
                }
        }

        return true;
    }

    public function getClient(){
        return UserService::getClientbyIdUser($this->id, $this->mydb);
    }
}
