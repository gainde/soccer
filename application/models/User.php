<?php
namespace models;

require_once WEBROOT.'system/Database.php';



class User {

    public function __construct() {
    }

    public function getAll() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM user");
			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		}
		catch(\PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
    }
	
    public function get($id) {
        $db = \Db::getInstance();
        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt -> bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    
     public function create($data){
         if(isset($data) && !empty($data)){
            $db = \Db::getInstance();
            $sql = "INSERT INTO `user` (id, nom, telephone, email, password) 
            VALUES (NULL, :nom, :telephone, :email, :password)";
            try
           {
                $stmt = $db->prepare ($sql);
                $stmt -> bindParam(':nom', $data['nom']);
                $stmt -> bindParam(':telephone', $data['telephone']);
                $stmt -> bindParam(':email', $data['email']);
				$password = md5($data['password']);
                $stmt -> bindParam(':password', $password);
           
                $stmt->execute();
           }
           catch(\PDOException $e)
           {
                   echo $e->getMessage();
                   return false;
           }
        }
        return false;

    }

    
    public function getByAth($email, $password){
        $db = \Db::getInstance();
        try
        {
            $stmt = $db->prepare("SELECT * FROM joueur where email = ? AND password = ?");
            $stmt->execute([$email, $password]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch(\PDOException $e)
        {
            echo $e->getMessage(); 
            return false;
        }

    }
    
    public function getByLogin($email){
        $db = \Db::getInstance();
        try
        {
            $stmt = $db->prepare("SELECT * FROM joueur where email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch(\PDOException $e)
        {
            echo $e->getMessage(); 
            return false;
        }

    }
}
