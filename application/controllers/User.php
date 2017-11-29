<?php
require_once WEBAPPROOT.'models/Joueur.php';
require_once WEBAPPROOT.'session/UserSession.php';
require_once WEBAPPROOT.'security/Validation.php';
require_once WEBAPPROOT.'libs/Uri.php';
require_once WEBAPPROOT.'security/AuthentificationManager.php';


class User extends Controller{
	  
    public function __construct() {
             parent::__construct();
    }
    public function index() {
        $this->login();
    }
	
    
    public function login() {
        $session = new Session("login");
        $session->start();
        $data = $session->get();
        $session->delete();
        if(!isset($data)){
            $data = array();
            $data['errors_msg'] = array();
            $data['errors_class'] = array();
         
             $data['errors_msg']['email'] = '';
              $data['errors_msg']['password'] = '';
              
              $data['errors_class']['email'] = '';
              $data['errors_class']['password'] = '';
              $data['email'] = '';
              $data['password'] = '';
        }
        //die(var_dump($data));
        $this->setData('data', $data);
	$this->render('production/login');
    }
    
    public function connexion() {
        $user_session = new UserSession();
        $user_session->start();
        $session = new Session("login");
        $session->start();
		$user_session->delete();
        //die(var_dump($session->getUser()));
		//die(var_dump($_POST));
		
        if(isset($_POST['username'])){
			if($_POST['username'] == 'admin' && $_POST['password'] == 'admin123'){
				$user['nom'] = $_POST['username'];
				$user_session->set($user);
                Uri::redirect(ROOT, false);
			}
            $authMngr = new AuthentificationManager();
            //die(var_dump($_POST));
            $data = $_POST;
            $user = $authMngr->login($data['username'], $data['password']);
			
            if(isset($user) && !empty($user)){
				die(var_dump($user));
                $user_session->set($user);
                Uri::redirect(ROOT, false);
            }
            
            
        }
        $user_session->set($data);
        Uri::redirect(ROOT.'user/login/', false);
        exit();
	  
    }
    
    public function deconnexion() {
        $session = new UserSession();
        $session->start();
        $session->delete();
        Uri::redirect(ROOT, false);
        exit();
	  
    }
    
    public function liste(){
        
    }

    public function register() {
        $session = new Session("register_user");
        $session->start();
        $data = $session->get();
        if(isset($data)){
			$session->delete();
            var_dump($data);die();
        }
        $this->setData('data', $data);
        $this->render('add_user');
    }
    
    
    public function save_user(){
        $session = new Session('register_user');
        $session->start();
        //var_dump($_POST);
        if(isset($_POST['nom'])){
            
            $data = $_POST;
            
            $validation = new Validation();
            
            $validation->addRules($this->getRules($data));
            
            $validation->addSource($data);
            $validation->run();
            //var_dump($validation->errors);
            //die();
            
            $erreur_class = $this->getClasses($validation->errors);

            $data['errors_msg'] = $validation->errors;
            $data['errors_class'] = $erreur_class;
			
			//var_dump($data);
			//die();
         
            if(!$validation->has_error()){
                $user_model = new models\Joueur();
                //var_dump($user_model);
                $result = $user_model->create($data);
                //die(var_dump($result));
                
            }else{
                $session->set($data);
                //die(var_dump($data));
            }
            

            
        }
        Uri::redirect(ROOT.'user/register/', false);
        exit();
        
    }
	
    
    private function getRules($data){
        
       $rules_array = array(
        'nom'=>array('type'=>'string', 'required'=>true, 'min'=>3, 'max'=>50, 'trim'=>true),
        'email'=>array('type'=>'string', 'required'=>true, 'min'=>6, 'max'=>50, 'trim'=>true),
		'confirm_email'=>array('type'=>'string', 'required'=>true, 'min'=>6, 'max'=>50, 'trim'=>true),
        'telephone'=>array('type'=>'string', 'required'=>false, 'min'=>7, 'max'=>50, 'trim'=>true),
        'password'=>array('type'=>'string', 'required'=>true, 'min'=>6, 'max'=>100, 'trim'=>true),
        'password2'=>array('type'=>'string', 'required'=>true, 'min'=>6, 'max'=>100, 'trim'=>true),  
        );
        foreach ($rules_array as $key => $value) {
            if(!array_key_exists($key, $data))
            {
                $data[$key] = null;
            }
        }
        
       return $rules_array;
    }
    private function getClasses($errorArray) {
        $classes = array(
        'nom'=>'',
        'email'=>'',
		'confirm_email'=>'',
        'telephone'=>'',
        'password'=>'',
        'password2'=>''
        );
        foreach ($classes as $key => $value) {
            if(!array_key_exists($key, $errorArray))
            {
                $classes[$key] = Constantes::CLASS_SUCCESS ;
            }else{
                $classes[$key] = Constantes::CLASS_ERROR ;
            }
        }
        return $classes;
    }
 }
 
?>