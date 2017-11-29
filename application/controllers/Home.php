<?php

require_once WEBAPPROOT.'models/Joueur.php';
//require_once WEBAPPROOT.'models/Rencontre.php';
require_once WEBAPPROOT.'models/DateMatch.php';
require_once WEBAPPROOT.'models/Presence.php';
require_once WEBAPPROOT.'models/Equipe.php';
require_once WEBAPPROOT.'libs/Uri.php';


  class Home extends Controller{
      
    public function __construct() {
               parent::__construct();
    }
    public function index() {
		if(!isset($this->userSession)){
            Uri::redirect(ROOT.'user/login/', false);
            exit();
        }
       //$joueurs = $this->getJoueurs();  
	   //$scores = $this->getScores();
	   //$dernierScore= $this->getDernierScores();
		//$prochaineRencontre = $this->getDateProchainRencontre();
		//$joueurs_presents = $this->getPresences($prochaineRencontre['date_match']);
		
		//$joueurs = $this->getJoueurs();
		//$joueurs_absent = $this->getAllAbsent($prochaineRencontre['date_match']);
		
		//$this->genererEquipe($joueurs_presents);
		
	   /*$this->setData('joueurs', $joueurs);
	   $this->setData('nbJoueursTotal', count($joueurs));
	   $this->setData('statsVictoire', $this->nombreDeVictoire($scores));
	   $this->setData('dernierScore', $dernierScore);
	   $this->setData('prochaineRencontre', $prochaineRencontre);
	   $this->setData('joueurs_presents', $joueurs_presents);
	   $this->setData('nbJoueursPresent', count($joueurs_presents));
	   $this->setData('joueurs_absent', $joueurs_absent);*/
      $this->render('production/index2');
    }

    /*public function getJoueurs($date = null) {
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
		
    }*/
	
	/*public function getAllAbsent($date = null) {
		$joueur_model = new models\Joueur();
        $result = array();
		$result = $joueur_model->getAllAbsent($date);
		
		//var_dump($result);
		return $result;
		
    }
	
	public function getDernierScores() {
		$rencontre_md = new models\Rencontre();
        $result = array();
		$result = $rencontre_md->getDernierRencontre();
		//var_dump($result);
		return $result;
    }
	
	public function getScores() {
		$rencontre_md = new models\Rencontre();
        $result = array();
		$result = $rencontre_md->getAll();
		//var_dump($result);
		return $result;
    }
	
	public function nombreDeVictoire($listRencontres){
		$statsVictoire = array('verte' => 0, 'orange'=>0);
		$victoireVerte = 0;
		foreach($listRencontres as $index => $rencontre){
			if($rencontre['score_verte']> $rencontre['score_orange']){
				$statsVictoire['verte'] ++;
			}else if($rencontre['score_verte'] < $rencontre['score_orange']){
				$statsVictoire['orange'] ++;
			}
		}
		
		return $statsVictoire;
		
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
	}*/
	
	public function genererEquipe($joueurs){
		$presence_md = new models\Presence();
		$equipe_md = new models\Equipe();
		
		$id_Joueurs = array('verte'=>array(), 'orange' =>array());
		$team = array(0=>'verte', 1=>'orange');
		$team_arr = array('verte' => array(), 'orange' => array());
		$nbJoueur = count($joueurs);
		
	
		while($nbJoueur>0){
			$index = rand(0, $nbJoueur-1);
			var_dump($team[$nbJoueur%2]);
			$joueurs[$index]['couleur'] = $team[$nbJoueur%2];
			array_push($team_arr[$team[$nbJoueur%2]], $joueurs[$index]);
			array_push($id_Joueurs[$team[$nbJoueur%2]], $joueurs[$index]['id_joueur']);
			array_splice($joueurs, $index, 1);
			$nbJoueur = count($joueurs);
		}
		$equipes = $equipe_md->getAll();
		var_dump($equipes);
		$equipes = $this->getTeamByColor($equipes);
		var_dump($equipes);
		die();
		$presence_md->updateEquipe($id_Joueurs['verte'], $equipes['verte']['id']);
		$presence_md->updateEquipe($id_Joueurs['orange'], $equipes['orange']['id']);
		//var_dump($team_arr);
		return $team_arr;
	}
	public function getTeamByColor($equipes){
		$result = array();
		foreach($equipes as $index => $equipe){
			$result[$equipe['couleur']] = $equipe;
		}
		return $result;
	}
    

  }
?>