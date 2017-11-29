<?php

class Validation{

    /*
    * @errors array
    */
    public $errors = array();

    /*
    * @the validation rules array
    */
    private $validation_rules = array();

    /*
     * @the sanitized values array
     */
    public $sanitized = array();
     
    /*
     * @the source 
     */
    private $source = array();
    
    private $has_error = false;


    /**
     *
     * @the constructor, duh!
     *
     */
    public function __construct()
    {
    }

    /**
     *
     * @add the source
     *
     * @paccess public
     *
     * @param array $source
     *
     */
    public function addSource($source, $trim=false)
    {
        $this->source = $source;
    }


    /**
     *
     * @run the validation rules
     *
     * @access public
     *
     */
    public function run()
    {
        /*** set the vars ***/
        foreach( new ArrayIterator($this->validation_rules) as $var=>$opt)
        {
            if($opt['required'] == true)
            {
                $this->is_set($var);
            }

            if( array_key_exists('trim', $opt) && $opt['trim'] == true )
            {
                $this->source[$var] = trim( $this->source[$var] );
            }

            switch($opt['type'])
            {
                case 'email':
                    $this->validateEmail($var, $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeEmail($var);
                    }
                    break;

                case 'url':
                    $this->validateUrl($var);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeUrl($var);
                    }
                    break;

                case 'numeric':
                    $this->validateNumeric($var, $opt['min'], $opt['max'], $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeNumeric($var);
                    }
                    break;

                case 'string':
                    $this->validateString($var, $opt['min'], $opt['max'], $opt['required']);
                    if(!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeString($var);
                    }
                break;


            }
        }
    }


    /**
     *
     * @add a rule to the validation rules array
     *
     * @access public
     *
     * @param string $varname The variable name
     *
     * @param string $type The type of variable
     *
     * @param bool $required If the field is required
     *
     * @param int $min The minimum length or range
     *
     * @param int $max the maximum length or range
     *
     */
    public function addRule($varname, $type, $required=false, $min=0, $max=0, $trim=false)
    {
        $this->validation_rules[$varname] = array('type'=>$type, 'required'=>$required, 'min'=>$min, 'max'=>$max, 'trim'=>$trim);
        /*** allow chaining ***/
        return $this;
    }


    /**
     *
     * @add multiple rules to teh validation rules array
     *
     * @access public
     *
     * @param array $rules_array The array of rules to add
     *
     */
    public function addRules(array $rules_array)
    {
        $this->validation_rules = array_merge($this->validation_rules, $rules_array);
    }

    /**
     *
     * @Check if POST variable is set
     *
     * @access private
     *
     * @param string $var The POST variable to check
     *
     */
    private function is_set($var)
    {
        if(!isset($this->source[$var]))
        {
            $this->errors[$var] = "Le champs ne peut pas être vide";
        }
    }


    /**
     *
     * @validate a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param int $min the minimum string length
     *
     * @param int $max The maximum string length
     *
     * @param bool $required
     *
     */
    private function validateString($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(isset($this->source[$var]))
        {
            if(empty($this->source[$var])){
                $this->errors[$var] = 'Le champs ne peux pas être vide';
            }
            elseif(strlen($this->source[$var]) < $min)
            {
                $this->errors[$var] = 'Invalide : trop court';
            }
            elseif(strlen($this->source[$var]) > $max)
            {
                $this->errors[$var] = 'Invalide : trop long';
            }
            elseif(!is_string($this->source[$var]))
            {
                $this->errors[$var] = 'Invalide';
            }
        }
    }

    /**
     *
     * @validate an number
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param int $min The minimum number range
     *
     * @param int $max The maximum number range
     *
     * @param bool $required
     *
     */
    private function validateNumeric($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))===FALSE)
        {
            $this->errors[$var] = "Vous devez rentrer des chiffres";
        }
    }

    /**
     *
     * @validate a url
     *
     * @access private
     *
      * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateUrl($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_URL) === FALSE)
        {
            $this->errors[$var] = "L'URL n'est pas valide";
        }
    }


    /**
     *
     * @validate an email address
     *
     * @access private
     *
     * @param string $var The variable name 
     *
     * @param bool $required
     *
     */
    private function validateEmail($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $this->errors[$var] = "L'adresse email n'est pas valide";
        }
    }


    

    ########## SANITIZING METHODS ############
    

    /**
     *
     * @santize and email
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @return string
     *
     */
    public function sanitizeEmail($var)
    {
        $email = preg_replace( '((?:\n|\r|\t|%0A|%0D|%08|%09)+)i' , '', $this->source[$var] );
        $this->sanitized[$var] = (string) filter_var($email, FILTER_SANITIZE_EMAIL);
    }


    /**
     *
     * @sanitize a url
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeUrl($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var],  FILTER_SANITIZE_URL);
    }

    /**
     *
     * @sanitize a numeric value
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeNumeric($var)
    {
        $this->sanitized[$var] = (int) filter_var($this->source[$var], FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     *
     * @sanitize a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeString($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var], FILTER_SANITIZE_STRING);
    }
    
    public function has_error() {
        return  !empty($this->errors);
    }

} /*** end of class ***/

?>