<?php
require_once 'bd.php';
session_start();

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


$retour = array();
if(isset($_POST['titre_input_tache']) && !empty($_POST['titre_input_tache']) && isset($_POST['date_input_tache']) && !empty($_POST['date_input_tache'])){

    if(strlen($_POST['titre_input_tache']) > 40){
        echo json_encode('L\'intitule de votre tâche est trop long !');
    }
    else if($_POST['date_input_tache'] < date('Y-m-d')){
        echo json_encode('Vivez-vous dans le passé ? Veuillez insérer une date plus récente.');
    }
    else {
        $bd = new bd();

        $dbh = $bd->getBdd();
        $tache = htmlspecialchars($_POST['titre_input_tache']);

        $query = "INSERT INTO taches (INTITULE, POSTIT, DATE_T)  VALUES ('". $tache ."','".$_POST['idbd']."','".$_POST['date_input_tache']."')";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $numTache = sizeof($_SESSION['postits'][$_POST['id']]['TACHES']);
        $_SESSION['postits'][$_POST['id']]['TACHES'][] = $tache;

        $retour['num'] = $numTache;
        $retour['intitule'] = $tache;
        echo json_encode($retour);
    }

}
else{
    if(empty($_POST['date_input_tache']) && empty($_POST['titre_input_tache'])){
        echo json_encode('Il manque des informations !');
    }
    else if(empty($_POST['date_input_tache']))
    {
        echo json_encode( 'Veuillez préciser une date.');
    }
    else if(empty($_POST['titre_input_tache'])){
        echo json_encode('Veuillez préciser l\'intitulé de votre tâche.');
    }
}







