<?php
require_once 'postit.php';
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


$postit = new Postit();
if(isset($_POST['NOM'])){
    $postit->insertPostit();
}
else if(isset($_POST['idpostituser'])){
    $idpostituser = $_POST['idpostituser'];
    echo json_encode($_SESSION['postits'][$idpostituser]['TACHES']);
}
else if (isset($_POST['idTask'])){
    $postit->setEtat($_POST['idTask'], $_POST['idPostit'],$_POST['idPostitUser'],$_POST['etat']);
}
else if(isset($_POST['postitSupp']))
{
    $postit->supprimerPostit($_POST['postitSupp']);
    echo json_encode($_SESSION);
}
else if(isset($_SESSION['postits']))
{
    $postit->selectPostit();
}


