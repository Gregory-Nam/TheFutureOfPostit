<?php
require_once 'postit.php';



$postit = new Postit();
if(isset($_POST['NOM'])){
    $postit->insertPostit();
}
else if(isset($_POST['idpostituser'])){
    $idpostituser = $_POST['idpostituser'];
    echo json_encode($_SESSION['postits'][$idpostituser]['TACHES']);
}
else if(isset($_SESSION['postits']))
{
    $postit->selectPostit();
}


