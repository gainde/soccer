<?php


require_once WEBAPPROOT.'models/User.php';
require_once WEBAPPROOT.'session/UserSession.php';

/**
 * Description of Auth
 *
 * @author Moussa
 */
class AuthentificationManager {
    private $isAdmin;
    private $login;
    private $password;
    private $user = null;
    private $table = 'joueur';


    public function __construct() {
    }
    
    public function login($username, $password){
        //valider login
        //valider password
        
        $user_model = new models\User();
        $passwordMd5 = $this->hashPassword($password);
        $this->user = $user_model->getByAth($username, $passwordMd5);
        var_dump($this->user);
        if (!empty($this->user)) {
            $session = new UserSession();
            $session->start();
            $session->set($this->user);
        }
        return $this->user;
    } 
    public function logout(){
        require_once WEBAPPROOT.'security/UserSession.php';
        removeUser();
    } 
    
    public function register($data){
        $user_model = new models\User();
        return  $user_model->create($data);
    }
    public function exists($login){
        $user_model = new models\User();
        $user = $user_model->getByLogin($login);
        return isset($user);
    }
    public function createUser(){
    }
    public function removeUser(){
        $session = new UserSession();
        $session->start();
        $session->delete();
    }
    public function getUser(){ 
        if(!isset($this->user)){
            $session = new UserSession();
            $session->start();
            $this->user = $session->getUser();
        }
        return $this->user;
    }
    public function getCurrentUser(){ 
    }
    public function setCurrentUser($user){  
        $session = new UserSession();
        $session->start();
        $session->set($user);
    }
    public function clearCurrent(){        
    }
    public function isAdmin(){ 
    } 
    public function redirect(){       
    }  
    public function changePassword(){        
    }  
    public function hashPassword($password){  
        return md5($password);
    }
    public function verifyPassword(){       
    }
    public function verifyPasswordStrength(){        
    }  
    public function generateStrongPassword(){       
    }  
    public function verifyAccountNameStrength(){       
    }
    
    
}
