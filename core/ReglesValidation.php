<?php

class ReglesValidation{
    /*
     * *Variable regles contient les informations de la regle de vaidation des formulaires
     */
    static $regles = array(
        'key' => array(
            'name' => array('string',null , 2, 30, false),
            'description' => array('string', null, 2, 30, false)
        ),
        'key2' => array(
            'nom' => array('string',null , 2, 30, false),
            'prenom' => array('string',null , 2, 30, false),
            'date_naissance' => array('date', null, false),
            'adresse' => array('string',null , 2, 30, false),
            'date_naissance' => array('date', null, false)
        )
    );
	
    private function __construct() {}
    
    public static function getRegle($key) {
        if(isset(self::$regles[$key])){
            return self::$regles[$key];
        }
        return null;
    }
}

