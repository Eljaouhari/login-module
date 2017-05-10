<?php
/// TO DO : add the sha function on password*
/// TODO : Implement the validation of the forms


/**
 * 
 */
class UsersManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb($db){
        $this->_db = $db;
    }

    public function add(User $user){
        $query = $this->_db->prepare('INSERT INTO user(`firstname`, `lastname`, `email`, `password`) VALUES (:firstname, :lastname, :email, :password)');
        
        $query->bindValue(':firstname', $user->getFirstName());
        $query->bindValue(':lastname', $user->getLastName());
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue(':password', $user->getPassword());
        
        $query->execute();

        
    }

    public function exists($email){
       if(is_string($email)){
           $query  = $this->_db->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
           // 'SELECT COUNT(*) FROM user WHERE email ='mindfulincantotr@gmail.com''

           $query->execute([':email' => $email]);

           return (bool) $query->fetchColumn();
       }
    }

    public function delete(){
        // suprimmer mon compte
    }


    // $email of the user
    // $user is the password owner
    public function getPassword($email, $password){
        $query = $this->_db->prepare('SELECT `password` FROM user WHERE email = :email');
        $query->execute([':email' => $email]);
    
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if($data['password'] == sha1($password)){
            return true;
        }
    }

    public function get($email){
        $query = $this->_db->prepare('SELECT id, firstName, lastName, email FROM user WHERE email = :email');
        $query->execute([':email' => $email]);
    
        //TODO : hydrate

        return new User($query->fetch(PDO::FETCH_ASSOC));
    }
}