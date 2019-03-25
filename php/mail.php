<?php
require_once 'bd.php';

function sendMail($mail,$msg){

    // Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
    $msg = wordwrap($msg, 70, "\r\n");

    // Envoi du mail
    mail($mail, 'Future of postit', $msg,"Content-type: text/html");
}

$bd = new bd();
$dbh = $bd->getBdd();

$query = "SELECT distinct MAIL,INTITULE FROM  utilisateurs u, postit p, taches t WHERE ".
         "p.ID = t.POSTIT AND u.ID = p.UTILISATEUR AND t.ETAT = 0 AND t.DATE_T >= '".date('Y-m-d')."'";

$statement = $dbh->prepare($query);
$statement->execute();

$mail = '';
$msg = '';

while($mailAndInitule = $statement->fetch(PDO::FETCH_ASSOC)){
    if($mail == $mailAndInitule['MAIL']){
        //ici on continue simplement de construire le mail
        //en rajoutant les taches à terminer
        $msg .= '   - ' .$mailAndInitule['INTITULE'] . '</br>';
    }
    else{
        //Changement d'utilisateur ou premier mail
        //on envoie pas de mail à la première itération
        //en revanche je rempli la variable mail et construit le mail
        //le mail est envoyé dès qu'on passe à un autre utilisateur
        if(!empty($mail)){
            $msg .= 'Bonne journée à vous !';
            sendMail($mail,$msg);
        }
        $mail = $mailAndInitule['MAIL'];
        $msg .= 'Bonjour, </br> Vous avez des taches à finir : </br> </br>';
        $msg .= '   - ' .$mailAndInitule['INTITULE'] . '</br>';
    }

}
//pour le dernier utilisateur je rentre pas dans la boucle
//effectivement il n'y a pas d'autre utilisateur
//son mail ne peut pas avoir été envoyé, mais a été construit.
$msg .= ' </br> Bonne journée à vous !';
sendMail($mail,$msg);


?>
