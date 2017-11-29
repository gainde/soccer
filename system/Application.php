<?php

class Application {

    private $controller = null;
    private $action = null;
    private $params = array();
    private $isAdmin = false;
    private $controllerPath;
    private $section = "client";

    /**
     * analyser et récupérer format (controlleur/methode/[params/]
     * sinon erreur
     */
    public function __construct() {
        $this->controllerPath = WEBAPPROOT . 'controllers/';
        
        $this->splitUrl();
        if (file_exists($this->controllerPath . $this->controller . '.php')) {
            require $this->controllerPath . $this->controller . '.php';
            
            $this->controller = new $this->controller();
            // verifier si méthode existe
            if (method_exists($this->controller, $this->action)) {
                if (!empty($this->params)) {
                    // Si ya des params
                    call_user_func_array(array($this->controller, $this->action), $this->params);
                } else {
                    // Si pas de parametres
                    $this->controller->{$this->action}();
                }
            } else {
                require ($this->controllerPath . 'PageErreur.php');
                $this->controller = new Erreur();
                $this->controller->Page404();
            }
        } else {
            require ($this->controllerPath . 'PageErreur.php');
            $this->controller = new Erreur();
            $this->controller->Page404();
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl() {
        if (isset($_GET['page'])) {
            // split URL
            $url = trim($_GET['page'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            //$this->checkAdmin($url, count($url));
            $this->controller = isset($url[0]) ? ucfirst($url[0]) : "Home";
            $this->action = isset($url[1]) ? $url[1] : "index";
            // Enlever le controlleur et la méthode
            unset($url[0], $url[1]);
            // Récupérer les parametres
            $this->params = array_values($url);
        }else{
            $this->controller = "Home";
            $this->action = "index";
            //$this->controllerPath .=$this->section  . '/';        
        }
    }
    

}
