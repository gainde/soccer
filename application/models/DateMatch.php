<?php
namespace models;

require_once WEBROOT.'system/Database.php';



class DateMatch {

    public function __construct() {
    }

    public function getAll() {
		$db = \Db::getInstance();
		try
		{
			$stmt = $db->prepare("SELECT * FROM dates_match");
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
	
	public function getDateProchainRencontre() {
			$date = date("Y-m-d H:i:s");
			$dateFin = date("Y-m-d H:i:s", strtotime("+1 week"));
			//var_dump($date, $dateFin);
            $db = \Db::getInstance();
            try
            {
                    $stmt = $db->prepare("SELECT * FROM dates_match WHERE date_match >= ? AND date_match < ?");
                    $stmt->execute([$date, $dateFin]);
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
