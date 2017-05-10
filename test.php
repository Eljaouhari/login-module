<?php
$email = 'dddddddd@dddddd.com';

$retour = preg_match('#[\w-.]{3,}@[a-zA-Z]{2,}\.[a-z]{2,3}#', $email);

if($retour == 1){
    echo 'true';
} else {
    echo 'false';
}