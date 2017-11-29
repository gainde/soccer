<?php
namespace models;

require_once WEBROOT.'system/Database.php';



class Joueur {

    public function __construct() {
    }

    public function getAll() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM joueur");
			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
    }
	
    public function get($id) {
        $db = \Db::getInstance();
        $stmt = $db->prepare("SELECT * FROM joueur WHERE id = :id");
        $stmt -> bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
    
     public function create($data){
         if(isset($data) && !empty($data)){
            $db = \Db::getInstance();
            $sql = "INSERT INTO `joueur` (id, nom, telephone, email, password) 
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


    public function getJoueurPresent($date) {
            $db = \Db::getInstance();
            try
            {
                    $stmt = $db->prepare("SELECT nom, prenom, telephone FROM joueur INNER JOIN presence on joueur.id = presence.id_joueur");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
            }
            catch(PDOException $e)
            {
                    echo $e->getMessage(); 
                    return false;
            }
    }
	
	public function getJoueurPresentByTeam($id) {
            $db = \Db::getInstance();
            try
            {
                    $stmt = $db->prepare("SELECT nom, prenom, telephone FROM joueur INNER JOIN presence on joueur.id = presence.id_joueur WHERE presence.id_equipe = :id");
					$stmt -> bindParam(':id', $id);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
            }
            catch(PDOException $e)
            {
                    echo $e->getMessage(); 
                    return false;
            }
    }
	
	public function getAllAndPresence($date) {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM joueur LEFT JOIN (SELECT p.id_joueur, p.id_equipe, p.date FROM presence p WHERE p.date = :date) AS p on joueur.id = p.id_joueur");
			$stmt -> bindParam(':date', $date);
			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
    }
	
	public function getAllAbsent($date) {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM joueur LEFT JOIN (SELECT p.id_joueur, p.id_equipe, p.date FROM presence p WHERE p.date = :date) AS p on joueur.id = p.id_joueur WHERE p.date is NULL");
			$stmt -> bindParam(':date', $date);
			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
    }
	
}
