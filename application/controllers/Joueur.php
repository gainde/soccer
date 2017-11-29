<?php

require_once WEBAPPROOT.'models/Joueur.php';
//require_once WEBAPPROOT.'models/Rencontre.php';
require_once WEBAPPROOT.'models/DateMatch.php';
require_once WEBAPPROOT.'models/Presence.php';
require_once WEBAPPROOT.'models/Equipe.php';


  class Joueur extends Controller{
      
    public function __construct() {
               parent::__construct();
    }
    public function index() {
    }

    public function getJoueurs($date = null) {
		$joueur_model = new models\Joueur();
        $result = array();
		if($date === null){
			$result = $joueur_model->getAll();
		}
		else {
			$result = $joueur_model->getAllAndPresence($date);
		}
		//var_dump($result);
		return $result;
		
    }
	
	
	public function getDateProchainRencontre() {
		$dateMatch_md = new models\DateMatch();
        $result = array();
		$result = $dateMatch_md->getDateProchainRencontre();
		//var_dump($result);
		return $result;
    }
	
	public function getPresences($date){
		$md = new models\Presence();
        $result = array();
		$result = $md->getPresenceByDate($date);
		//var_dump($result);
		return $result;
	}
	
	public function genererEquipe($joueurs){
		$presence_md = new models\Presence();
		$equipe_md = new models\Equipe();
		
		$id_Joueurs = array('verte'=>array(), 'orange' =>array());
		$team = array(0=>'verte', 1=>'orange');
		$team_arr = array('verte' => array(), 'orange' => array());
		$nbJoueur = count($joueurs);
		
	
		while($nbJoueur>0){
			$index = rand(0, $nbJoueur-1);
			$joueurs[$index]['couleur'] = $team[$nbJoueur%2];
			array_push($team_arr[$team[$nbJoueur%2]], $joueurs[$index]);
			array_push($id_Joueurs[$team[$nbJoueur%2]], $joueurs[$index]['id_joueur']);
			array_splice($joueurs, $index, 1);
			$nbJoueur = count($joueurs);
		}
		$equipes = $equipe_md->getAll();
		
		$equipes = $this->getTeamByColor($equipes);
		

		$presence_md->updateEquipe($id_Joueurs['verte'], $equipes['verte']['id']);
		$presence_md->updateEquipe($id_Joueurs['orange'], $equipes['orange']['id']);

		return $team_arr;
	}
	
	public function getEquipe($joueurs){
		
		$team = array(0=>'verte', 1=>'orange');
		$team_arr = array('verte' => array(), 'orange' => array());
		$nbJoueur = count($joueurs);
		foreach($joueurs as $index => $joueur){
			array_push($team_arr[$joueurs[$index]['couleur']], $joueurs[$index]);
		}

		return $team_arr;
	}
	public function getAllAbsent($date = null) {
		$joueur_model = new models\Joueur();
        $result = array();
		$result = $joueur_model->getAllAbsent($date);
		
		//var_dump($result);
		return $result;
		
    }
	
	public function getTeamByColor($equipes){
		$result = array();
		foreach($equipes as $index => $equipe){
			$result[$equipe['couleur']] = $equipe;
		}
		return $result;
	}
	public function team(){
		$prochaineRencontre = $this->getDateProchainRencontre();
		$joueurs_presents = $this->getPresences($prochaineRencontre['date_match']);
		
		echo json_encode($this->genererEquipe($joueurs_presents));
	}
	
	public function equipe(){
		$prochaineRencontre = $this->getDateProchainRencontre();
		$joueurs_presents = $this->getPresences($prochaineRencontre['date_match']);
		
		echo json_encode($this->getEquipe($joueurs_presents));
	}
	
	public function joueurs_absents() {
		$prochaineRencontre = $this->getDateProchainRencontre();
		
        $result = $this->getAllAbsent($prochaineRencontre['date_match']);
		echo json_encode($result);
		
    }
	
	public function joueurs_presents() {
		$prochaineRencontre = $this->getDateProchainRencontre();
		
        $result = $this->getPresences($prochaineRencontre['date_match']);
		echo json_encode($result);
		
    }
    

  }
?>