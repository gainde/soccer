<?php
namespace models;

require_once WEBROOT.'system/Database.php';



class Presence {

    public function __construct() {
    }

    public function getAll() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM presence");
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
        $stmt = $db->prepare("SELECT * FROM presence WHERE id = :id");
        $stmt -> bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
    
     public function create($data){
         if(isset($data) && !empty($data)){
            $db = \Db::getInstance();
            $sql = "INSERT INTO `presence` (id, date, id_joueur, id_equipe) 
            VALUES (NULL, :date, :id_joueur, :id_equipe)";
           $stmt = $db->prepare ($sql);
           $stmt -> bindParam(':date', $data['date']);
           $stmt -> bindParam(':id_joueur', $data['id_joueur']);
           $stmt -> bindParam(':id_equipe', $data['id_equipe']);
           try
           {
               $stmt->execute();
           }
           catch(PDOException $e)
           {
                   echo $e->getMessage();
                   return false;
           }
        }
        return false;

    }
	
	public function del($data){
         if(isset($data) && !empty($data)){
            $db = \Db::getInstance();
            $sql = "DELETE FROM `presence` WHERE id_joueur = :id_joueur AND date = :date";
           $stmt = $db->prepare ($sql);
           $stmt -> bindParam(':date', $data['date']);
           $stmt -> bindParam(':id_joueur', $data['id_joueur']);
           try
           {
               $stmt->execute();
           }
           catch(PDOException $e)
           {
                   echo $e->getMessage();
                   return false;
           }
        }
        return false;

    }


    public function getPresenceByDate($date) {
            $db = \Db::getInstance();
            try
            {
                    $stmt = $db->prepare("SELECT j.id, j.nom, j.telephone, j.email, p.id_joueur, p.id_equipe, e.couleur FROM presence p INNER JOIN joueur j ON p.id_joueur = j.id INNER JOIN equipe e ON p.id_equipe = e.id WHERE p.date = ? GROUP BY p.id");
                    $stmt->execute([$date]);
                    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    return $result;
            }
            catch(PDOException $e)
            {
                    echo $e->getMessage(); 
                    return false;
            }
    }
	
	public function updateEquipe($data, $idEquipe){
		$db = \Db::getInstance();
            try
            {
                    $stmt = $db->prepare("UPDATE presence SET  id_equipe = :id_equipe WHERE id_joueur IN (".implode(',',$data).")");
					$stmt -> bindParam(':id_equipe', $idEquipe);
                    $stmt->execute();
                    return true;
            }
            catch(PDOException $e)
            {
                    echo $e->getMessage(); 
                    return false;
            }
	}
	
	public function updateEquipeJoueur($idJoueur, $idEquipe){
		$db = \Db::getInstance();
		var_dump($idJoueur, $idEquipe);
            try
            {
                    $stmt = $db->prepare("UPDATE presence SET  id_equipe = :id_equipe WHERE id_joueur :id_joueur");
					$stmt -> bindParam(':id_equipe', $idEquipe);
					$stmt -> bindParam(':id_joueur', $idJoueur);
                    $stmt->execute();
                    return true;
            }
            catch(PDOException $e)
            {
                    echo $e->getMessage(); 
                    return false;
            }
	}
	

}