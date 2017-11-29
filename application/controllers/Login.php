<?php

require_once WEBAPPROOT.'security/Validation.php';

/**
 * Description of Login
 *
 * @author Moussa
 */
class Login extends Controller{
    public function __construct() {
             parent::__construct("login_header", "login_footer");
    }
    public function index() {
	  $this->render('login');
    }
}
