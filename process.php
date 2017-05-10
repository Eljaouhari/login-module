<?php

// TODO : share with abdo and younes also bikourne and my proffessor annd ask them for ameliorations possibles

// On enregistre notre autoload.
function chargerClasse($classname)
{
  require $classname.'.php';
}

spl_autoload_register('chargerClasse');
// On appelle session_start() APRÈS avoir enregistré l'autoload.
session_start(); 


$bd = new PDO('mysql:host=localhost;dbname=php-login;' , 'root' , '3EhF!t&TtHf3\'s');
$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new UsersManager($bd);

$data = array(
    'firstName' => $_POST['firstname'],
    'lastName' => $_POST['lastname'],
    'email' => $_POST['email'],
    'password' => $_POST['password']);

$message = [];

if(isset($_POST['login'])){
    // s'il existe'
  if($manager->exists($data['email']) && $manager->getPassword($data['email'], $data['password'])){
    
    $user = $manager->get($data['email']);
    var_dump($user);
    // Access to profile
    $user->getEmail();
    $user->getFirstName();
    $user->getLastName();
    $user->getPassword();
    
    echo '<strong>Vous êtes connecté<strong><br>';
    
  }
    if($manager->exists($data['email']) && !$manager->getPassword($data['email'], $data['password'])){
      echo '<strong>Your password is not correct !</strong>';
    }
    
    if(!$manager->exists($data['email'])){
      echo '<a href="index.php"><strong>You tried to login but password the email' . $data['email'] . 'doesn\'t exist !</strong></a>';
    }
    
}

if(isset($_POST['register'])){
  // On vérifie se celui la existe
    // Si Oui on lui demande de login
    // Si les donnees sont valides on l'enregistre
  $user = new User($data);

  if(!$user->isValidFirstName($data['firstName'])){
    echo '<strong>Invalid First Name</strong><br>';
    unset($user);
  }

  if(!$user->isValidLastName($data['lastName'])){
    echo '<strong>Invalid Last Name</strong><br>';
    unset($user);
  } 
  
  if(!$user->isValidMail($data['email'])){
    echo '<strong>Invalid Mail</strong><br>';
    unset($user);
  } 

  if (!$user->isValidPassword($data['password'])){
    echo '<strong>Invalid password please try a stronger password</strong><br>';
    unset($user);    
  } 

  if($manager->exists($data['email'])){
    echo '<strong>You\'re already signed up ! Please <a href="index.php">sign in</a></strong><br>';
    unset($user);
  }

  if(isset($user)){
    $manager->add($user);
    echo '<storng>You just signed up tp ur platforms ! Bravoo ! please sign in <a href="index.php"></a></storng><br>';
  }

  
}
?>

