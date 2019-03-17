<?php
require_once 'bd.php';
session_start();

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


$retour = array();
if(isset($_POST['titre_input_tache']) && !empty($_POST['titre_input_tache']) && isset($_POST['date_input_tache']) && !empty($_POST['date_input_tache'])){

    if(strlen($_POST['titre_input_tache']) > 40){
        $retour['message'] ='L\'intitule de votre tâche est trop long !';
        echo json_encode($retour);
    }
    else if($_POST['date_input_tache'] < date('Y-m-d')){
        $retour['message'] ='Vivez-vous dans le passé ? Veuillez insérer une date plus récente.';
        echo json_encode($retour);
    }
    else {
        $bd = new bd();

        $dbh = $bd->getBdd();


        $query = "INSERT INTO taches (INTITULE, POSTIT, DATE_T)  VALUES ('". $_POST['titre_input_tache'] ."','".$_POST['idbd']."','".$_POST['date_input_tache']."')";
        $stmt = $dbh->prepare($query);
        $stmt->execute();

        $_SESSION['postits'][$_POST['id']]['TACHES'][] = $_POST['titre_input_tache'];

        echo json_encode($_POST['titre_input_tache']);
    }

}
else{
    if(empty($_POST['date_input_tache']) && empty($_POST['titre_input_tache'])){
        $retour['message'] = 'Il manque des informations !';
        echo json_encode($retour);
    }
    else if(empty($_POST['date_input_tache']))
    {
        $retour['message'] = 'Veuillez préciser une date.';
        echo json_encode($retour);
    }
    else if(empty($_POST['titre_input_tache'])){
        $retour['message'] = 'Veuillez préciser l\'intitulé de votre tâche.';
        echo json_encode($retour);
    }
}







