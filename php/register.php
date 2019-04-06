<?php
require_once('bd.php');
require_once('user.php');

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


if((isset($_POST['username']) && !empty($_POST['username'])) &&
   (isset($_POST['mail']) && !empty($_POST['mail'])) &&
   (isset($_POST['password']) && !empty($_POST['password'])))
{
    $mail = htmlspecialchars($_POST['mail']);
    $pseudo = htmlspecialchars($_POST['username']);
    $password = sha1(htmlspecialchars($_POST['password']));
    if( preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $mail))
    {
        if(strlen($pseudo) > 3)
        {
            $bd = new bd();
            $dbh = $bd->getBdd();

            $query = "INSERT INTO utilisateurs (NOM_UTILISATEUR, MAIL, MOT_DE_PASSE)  VALUES ('". $pseudo ."','".$mail."','". $password."')";
            $statement = $dbh->prepare($query);
            $statement->execute();
            $user = new Utilisateur();
            $user->connexion();


        }
        else
        {
            echo json_encode("Nom d'utilisateur trop court");
        }
    }
    else
    {
        echo json_encode("Le mail est incorrect");
    }
}
else{
    echo json_encode("Veuillez remplir tous les champs");
}