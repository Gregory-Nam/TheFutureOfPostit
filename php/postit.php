<?php
session_start();
require_once 'bd.php';
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

class postit {

    private $bd;
    private $dbh;

    //contructeur a faire
    function __construct()
    {
        $this->bd = new bd();
        $this->dbh = $this->bd->getBdd();

    }

    //insertion d'un nouveau postit dans
    //la base de données
    function insertPostit() {

        $postit['NOM']= htmlspecialchars($_POST['NOM']);

        $query = "INSERT INTO postit (NOM, UTILISATEUR)  VALUES ('". $postit['NOM'] ."','".$_SESSION['userid']."')";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $numPostit = count($_SESSION['postits']);
        $postit['ID'] = $this->dbh->lastInsertId();
        $_SESSION['postits'][] = $postit;




        echo json_encode($_SESSION['postits']);
    }


    //recupération des postits d'un user
    function selectPostit() {
        $query2 = "SELECT * FROM postit WHERE UTILISATEUR =".$_SESSION['userid'];
        $statement = $this->dbh-> prepare($query2);
        $statement->execute();
        $i = 0;
        while($postit = $statement->fetch(PDO::FETCH_ASSOC)){
            $_SESSION['postits'][] = $postit;
            $this->recupTache($postit['ID'],$i);
            ++$i;
        }

    }

    function recupTache($idbd, $id){
        $query = "SELECT * FROM taches WHERE POSTIT =".$idbd;
        $statement = $this->dbh-> prepare($query);
        $statement->execute();
        while($postit = $statement->fetch(PDO::FETCH_ASSOC)){

            $_SESSION['postits'][$id]['TACHES'][] = $postit['INTITULE'];
        }

    }

}