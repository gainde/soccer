<?php
namespace models;

require_once WEBROOT.'system/Database.php';



class Equipe {

    public function __construct() {
    }

    public function getAll() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM equipe");
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
        $stmt = $db->prepare("SELECT * FROM equipe WHERE id = :id");
        $stmt -> bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
	
}