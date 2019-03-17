<?php
require_once 'user.php';

$utilisateur = new Utilisateur();

if(isset($_POST['username']) && isset($_POST['password'])){
    $utilisateur->connexion();
}
else if($_GET['action'] == 'deco')
{
    $utilisateur->deconnexion();
}