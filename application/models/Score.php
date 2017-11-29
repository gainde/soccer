<?php
namespace models;

require_once WEBROOT.'system/Database.php';



class Score {

    public function __construct() {
    }

    public function getAll() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM score");
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
        $stmt = $db->prepare("SELECT * FROM score WHERE id = :id");
        $stmt -> bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
    
     public function create($data){
         if(isset($data) && !empty($data)){
            $db = \Db::getInstance();
            $sql = "INSERT INTO `score` (id, date_rencontre, score_verte, score_orange) 
            VALUES (NULL, :date_rencontre, :score_verte, :score_orange)";
           $stmt = $db->prepare ($sql);
           $stmt -> bindParam(':date_rencontre', $data['date_rencontre']);
           $stmt -> bindParam(':score_verte', $data['score_verte']);
           $stmt -> bindParam(':score_orange', $data['score_orange']);
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


    public function getRencontreByDate($date) {
            $db = \Db::getInstance();
            try
            {
                    $stmt = $db->prepare("SELECT * FROM score WHERE date = :date");
                    $stmt->execute([$date]);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
            }
            catch(PDOException $e)
            {
                    echo $e->getMessage(); 
                    return false;
            }
    }
	public function getDernierRencontre() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT MAX(date_rencontre) AS date, score_verte, score_orange FROM score GROUP BY id, score_verte, score_orange ORDER BY date_rencontre DESC LIMIT 1");
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $result;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage(); 
			return false;
		}
    }
	
	
}
