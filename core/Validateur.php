<?php
require_once (WEBROOT.'core/ReglesValidation.php');

class Validateur{
    //array(name, string, 1, 30, false),...
    //string => array(array(name, string, 2, 30, false),...)
    var $list_champs;
    //var $data;
    var $erreur_array = array();
    
    var $key_courant = null;
    
    var $value_index = 1; //position de la valeur à valider
    
    function __construct($data, $list_champs) {
        $this->list_champs = $list_champs;
        //var_dump($list_champs);
        $this->prepare($data);
    }
    
    function prepare($data) {
        foreach ($data as $key => $value) {
            if(key_exists($key, $this->list_champs)){
                $this->list_champs[$key][$this->value_index] = $value;   
            }
        }
    }
    
    function valider(){
        $valide =true;
        foreach ($this->list_champs as $key => $value) {
            $this->key_courant = $key;
            $valide &= call_user_func_array(array($this, array_shift($value)), $value); 
        }
        //var_dump((bool) $valide);
        //var_dump($this->erreur_array);
        return $this->erreur_array;
    }
    
    function string($string, $lg_min, $lg_max, $nullable = true ){
        if(is_null($string) || empty($string)){
            if($nullable === false){
                $this->erreur_array[$this->key_courant] = 'Le champ ne peut pas être null';
            }
            return $nullable;
        }
        
        return $this->estDansBorne(strlen($string),$lg_min,$lg_max);
    }
    
    function email($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->erreur_array[$this->key_courant] = "L'email n'est pas valide";
        }
        return true;
    }
    
    function numerique($valeur, $lg_min, $lg_max, $nullable = true )
    {
        if(!isset($valeur) || $valeur === null ){
            if(!$nullable){
                $this->erreur_array[$this->key_courant] = "Le champ ne peut pas être null";
            }
            return $nullable;
        }
        if(is_numeric($valeur)){
            return $this->estDansBorne($valeur, $lg_min, $lg_max);
        }
        else {
            $this->erreur_array[$this->key_courant] = "Le champ doit être numerique";
            return false;
        }
        
    }
    
    function file(){
        if ($_FILES['imgp']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        /*
         * if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf('./uploads/%s.%s',
            sha1_file($_FILES['upfile']['tmp_name']),
            $ext
        )
    ))
         */
        $myme_exts= array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            );
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['imgp']['tmp_name']),$myme_exts,true )) {
                return false;
        }
        if ($files['imgp']['size'] > 2097152) {
            return false;
        }
    }
            
    function motDePasse($motDePasse){
        return true;
    }
    
    
    function estDansBorne($valeur, $lg_min, $lg_max){
        if($valeur>=$lg_min && $valeur<=$lg_max){
            return true;
        }
        else {
            $this->erreur_array[$this->key_courant] = "La taille n'est pas respecté : doit être entre ".$lg_min . " et ".$lg_max;
            return false;
        }
    }
    
    function telephone($tel){
        false;
    }
    
    function date($date, $format = 'Y-m-d', $delim = '-')
    {
        $date_arr  = explode($delim, $date);
        if (count($date_arr) == 3) {
            if (checkdate($date_arr[1], $date_arr[2],$date_arr[0])) {  
                return true;
                /*$d = DateTime::createFromFormat($format, $date);
                return $d && $d->format($format) == $date;*/
            } else {
                $this->erreur_array[$this->key_courant] = "La date n'est pas valide";
                return false;
            }
        } else {
            return false;
        }
        
    }
    
    function dateInf($dateString1, $dateString2){
        
        $format = 'Y-m-d';
        $date1 = DateTime::createFromFormat($format, $dateString1);
        $date2 = DateTime::createFromFormat($format, $dateString2);
        if($date1 === null || $date2 === null){
            $this->erreur_array[$this->key_courant] = "La difference de date n'est pas correct";
            $this->erreur_array['from'] = "invalide";
            $this->erreur_array['to'] = "invalide";
            return false;
        }
        //$difference = $date1->diff($date2);
        //die(var_dump($difference));
        if ($date1 <= $date2) {
            $this->erreur_array[$this->key_courant] = "La difference de date n'est pas correct";
            $this->erreur_array['from'] = "invalide";
            $this->erreur_array['to'] = "invalide";
            return false;
        }
        return true;
    }
    
    function url($url){
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            $this->erreur_array[$this->key_courant] = "L'url n'est pas valide";
            return false;
        }
        return true;
    }
    
    function getErrors(){
        return $this->erreur_array;
    }
}
