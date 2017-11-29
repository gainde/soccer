<?php

require_once WEBAPPROOT.'models/Joueur.php';
require_once WEBAPPROOT.'models/DateMatch.php';
require_once WEBAPPROOT.'models/Presence.php';
require_once WEBAPPROOT.'models/Equipe.php';


  class Presence extends Controller{
      
    public function __construct() {
               parent::__construct();
    }
    public function index() {
    }
	
	public function confirme(){
		var_dump($_POST);
		if(isset($_POST['id_joueur'])){
			$idJoueur = (int) $_POST['id_joueur'];
			$idEquipe = 1;
			$data= array();
			$data['date'] = $_POST['date_match'];
			$data['id_joueur'] = $_POST['id_joueur'];
			$data['id_equipe'] = $idEquipe;
			
			$presence_md = new models\Presence();
			$presence_md->create($data);
		}
	}
	
	public function desister(){
		var_dump($_POST);
		if(isset($_POST['id_joueur'])){
			$idJoueur = (int) $_POST['id_joueur'];
			$data= array();
			$data['date'] = $_POST['date_match'];
			$data['id_joueur'] = $_POST['id_joueur'];
			
			$presence_md = new models\Presence();
			$presence_md->del($data);
		}
	}

    public function getJoueurs() {
		$joueur_model = new models\Joueur();
        $result = array();
		$result = $joueur_model->getAll();
		var_dump($result);
		return $result;
		
    }
	
	public function getDateProchainRencontre() {
		$dateMatch_md = new models\DateMatch();
        $result = array();
		$result = $dateMatch_md->getDateProchainRencontre();
		var_dump($result);
		return $result;
    }
    

  }
?>