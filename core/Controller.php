<?php

require_once WEBROOT.'system/Session.php';
require_once WEBAPPROOT.'session/UserSession.php';
require_once WEBAPPROOT.'models/Joueur.php';
require_once WEBAPPROOT.'models/Score.php';
require_once WEBAPPROOT.'models/DateMatch.php';
require_once WEBAPPROOT.'models/Presence.php';
require_once WEBAPPROOT.'models/Equipe.php';
require_once WEBAPPROOT.'libs/Uri.php';

class Controller {
    protected $vars = array();
    protected $js = array();
    protected $css = array();
    protected $header = "" ;
    protected $footer="";
    
    private $admin = "";
    protected $section;
    protected $tpl;
    protected $userSession;
            
    function __construct($header = "header", $footer = "footer") {
		$this->header = $header;
		$this->footer = $footer;
        $this->getUser();
		$scores = $this->getScores();
	   $dernierScore= $this->getDernierScores();
		$prochaineRencontre = $this->getDateProchainRencontre();
		$joueurs_presents = $this->getPresences($prochaineRencontre['date_match']);
		
		$joueurs = $this->getJoueurs();
		$joueurs_absent = $this->getAllAbsent($prochaineRencontre['date_match']);
		
		//$this->genererEquipe($joueurs_presents);
		
	   $this->setData('joueurs', $joueurs);
	   $this->setData('nbJoueursTotal', count($joueurs));
	   $this->setData('statsVictoire', $this->nombreDeVictoire($scores));
	   $this->setData('dernierScore', $dernierScore);
	   $this->setData('prochaineRencontre', $prochaineRencontre);
	   $this->setData('joueurs_presents', $joueurs_presents);
	   $this->setData('nbJoueursPresent', count($joueurs_presents));
	   //$this->setData('joueurs_absent', $joueurs_absent);
                
    }
    
    function set($tab){
        $this->vars = $tab;
    }
    
    function setData($key, $value){
        $this->vars[$key] = $value;
    }
   
    function redirect($url){
        $url = ROOT.$url;
       // header('Location: ' . $url);
        echo "<script>
            window.location = '".$url."';
            </script>";
        exit;
    }
    
    function render($filename){
        $this->setData('user', $this->userSession);
		//die(var_dump($this->vars));
		extract($this->vars);

        include(WEBAPPROOT.'views/'.$this->header.'.php');
		include(WEBAPPROOT.'views/'.$filename.'.php');
		include(WEBAPPROOT.'views/'.$this->footer.'.php');
		
    }
    
	
    function load_css(){
        $this->css[] = 'http://fonts.googleapis.com/css?family=Bree+Serif';
        $this->css[] = 'http://fonts.googleapis.com/css?family=Philosopher';
        $this->css[] = 'http://fonts.googleapis.com/css?family=Source+Code+Pro|Open+Sans:300';
    }
    
    function load_js(){ 
    }
    
    function getUser(){
        /*require_once WEBAPPROOT . 'security/AuthentificationManager.php';
        $auth = new AuthentificationManager();
        //print_r($auth->getUser());
        //$user = UserSession::getUser();
        return $auth->getUser();*/
		
        $session = new UserSession();
        $session->start();
        $this->userSession = $session->get();
        return $this->userSession;
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
	
	public function getStats(){
		$joueur_model = new models\Joueur();
        $result = array();
		$joueurs = $joueur_model->getAll();
		$listScores = $this->getScores();
		foreach($listScores as $index => $score){
			$joueurs_p = $joueur_model->getJoueurPresent($score['date_rencontre']);
			
			if($score['score_verte']> $score['score_orange']){
				$statsVictoire['verte'] ++;
				foreach($joueurs as $index => $joueur){
					if($joueur['id_equipe'] == 1) $joueur['nbVictoire'] ++;
					else if($joueur['id_equipe'] == 2) $joueur['nbDefaite'] ++;
				}
				
			}else if($score['score_verte'] < $score['score_orange']){
				$statsVictoire['orange'] ++;
				foreach($joueurs as $index => $joueur){
					if($joueur['id_equipe'] == 2) $joueur['nbVictoire'] ++;
					else if($joueur['id_equipe'] == 1) $joueur['nbDefaite'] ++;
				}
			}
		}
	}
	
	
	public function getDernierScores() {
		$score_md = new models\Score();
        $result = array();
		$result = $score_md->getDernierRencontre();
		//var_dump($result);
		return $result;
    }
	
	public function getScores() {
		$score_md = new models\Score();
        $result = array();
		$result = $score_md->getAll();
		//var_dump($result);
		return $result;
    }
	
	public function nombreDeVictoire($listScores){
		$statsVictoire = array('verte' => 0, 'orange'=>0);
		$victoireVerte = 0;
		foreach($listScores as $index => $score){
			if($score['score_verte']> $score['score_orange']){
				$statsVictoire['verte'] ++;
			}else if($score['score_verte'] < $score['score_orange']){
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
	}
	public function getAllAbsent($date = null) {
		$joueur_model = new models\Joueur();
        $result = array();
		$result = $joueur_model->getAllAbsent($date);
		
		//var_dump($result);
		return $result;
		
    }
	
    

  }

  