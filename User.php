<?php
// TODO ; Check Openclassroooms offer email regex in javascript curse maybe ! get it done
// TODO : Add magic methods

/**
 * The class representing the user
 */
class User
{
    private $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    private $password;

    public function __construct($data)
    {
        $this->hydrate($data);
        $this->isValidPassword($data['password']);
        $this->isValidMail($data['email']);
        $this->isValidFirstName($data['firstName']);
        $this->isValidLastName($data['lastName']);
    }

    public function hydrate(array $data){

        foreach($data as $key => $value){
            $method = 'set' . ucfirst($key);

            if(method_exists($this, $method)){
                $this->$method($value);
            }

        }
    }

    public function getId(){
        return $this->id;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return sha1($this->password);
    }

    public function getIsValidPassword(){
        return $this->isValidPassword;
    }

    public function getIsValidFirstName(){
        return $this->isValidFirstName;
    }

    public function getIsValidLastName(){
        return $this->isValidLastName;
    }

   public function getIsValidEmail(){
        return $this->isValidEmail;
    }

    public function setId($id){
        $id = (int) $id;

        if(is_int($id)){
            $this->id = $id;
        }


    }

    public function setFirstName($firstname){
        $firstname = (string) $firstname;

        $retour = preg_match('#^[a-zA-Z]*$#', $firstname);

        if(is_string($firstname) && $retour == 1){
            $this->firstName = $firstname;
        } else {
            trigger_error('First name is not valid');
        }

    }
    
    public function setLastName($lastname){
        $lastname = (string) $lastname;

        $retour = preg_match('#^[a-zA-Z]*$#', $lastname);

        if(is_string($lastname) && $retour = 1){
            $this->lastName = $lastname;
        } else {
            trigger_error('Last name is not valid');
        }

    }

    public function setEmail($email){
        $email = (string) $email;

        $length = strlen($email);

        if(is_string($email) && $length <= 255){
            $this->email = $email;
        }

    }

    public function setPassword($password){
        $password = (string) $password;

        $length = strlen($password);

        if(is_string($password) && $length >= 8){
            $this->password = $password;
        }

    }


    public function isValidFirstName($firstname){

         $retour = preg_match('#([a-zA-Z]){2,}#', $firstname);

        if($retour == 1){
            return true;
        }
    }
    
    public function isValidLastName($lastname){

        $retour = preg_match('#([a-zA-Z]){2,}#', $lastname);
        
        if($retour == 1){
            return true;
        }
    }

    public function isValidPassword($password){
    
        $retour = preg_match('#[a-zA-Z]*#', $password);

        if($retour == 1){
            return true;
        }
    }

    public function isValidMail($email){
       
        $retour = preg_match('#[\w-.]{3,}@[a-zA-Z]{2,}\.[a-z]{2,}#', $email);
    
        if($retour == 1){
            return true;
        }
    }

}

