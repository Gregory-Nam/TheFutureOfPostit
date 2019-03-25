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

        if(isset($_POST['NOM']) && !empty($_POST['NOM']))
        {
            $nom = htmlspecialchars($_POST['NOM']);
            if(strlen($nom) > 15)
            {
                echo json_encode("Le nom du post-it est trop long");
            }
            else if(preg_match("/([%\$#\*]+)/", $nom))
            {
                echo json_encode("Un des caractères n'est pas valide (%,$,#,*)");
            }
            else if($this->existeDeja($nom))
            {
                echo json_encode("Vous avez déjà un post-it qui porte ce nom");
            }
            else
            {
                $postit['NOM']= $nom;
                $query = "INSERT INTO postit (NOM, UTILISATEUR)  VALUES ('". $nom ."','".$_SESSION['userid']."')";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                $postit['ID'] = $this->dbh->lastInsertId();
                $_SESSION['postits'][] = $postit;
                echo json_encode($_SESSION['postits']);
            }

        }
        else{
            echo json_encode("Veuillez rentrer un nom pour votre post-it");
        }
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
        $i = 0;
        while($postit = $statement->fetch(PDO::FETCH_ASSOC)){

            $_SESSION['postits'][$id]['TACHES'][]['INTITULE'] = $postit['INTITULE'];
            $_SESSION['postits'][$id]['TACHES'][$i]['DATE'] = $postit['DATE_T'];
            $_SESSION['postits'][$id]['TACHES'][$i]['ETAT'] = $postit['ETAT'];
            ++$i;

        }

    }


    function setEtat($id, $idPostit,$idPostitUser,$etat){
        $_SESSION['postits'][$idPostitUser]['TACHES'][$id]['ETAT'] = $etat;
        echo json_encode($_SESSION['postits'][$idPostitUser]['TACHES'][$id]);

        $query = "UPDATE taches ".
                 "SET ETAT =".$etat.
                 " WHERE ID IN ".
                     "(SELECT ID ".
                       "FROM ".
                        "(SELECT *,row_number() OVER (ORDER BY ID) 'nb' ".
                        "FROM taches ".
                        "WHERE postit = ". $idPostit .") ".
                      "AS t WHERE t.nb =".++$id.")";


        $statement = $this->dbh->prepare($query);
        $statement->execute();



    }

    function supprimerPostit($id){

        $query = "DELETE FROM postit WHERE ID =".$id;
        $statement = $this->dbh->prepare($query);
        $statement->execute();
    }
    function recupTacheDone($idbd, $id){
        $query = "SELECT * FROM taches WHERE POSTIT=".$idbd." AND ETAT=1";
        $statement = $this->dbh->prepare($query);
        $statement->execute();

        $taskDone = array();

        while($task = $statement->fetch(PDO::FETCH_ASSOC)) {
          $taskDone[]=$task;
        }
        echo json_encode($taskDone);

    }

    function existeDeja($nom){
        $query = "SELECT * FROM postit WHERE NOM = '".$nom."' AND UTILISATEUR = '".$_SESSION['userid']."'";
        $statement = $this->dbh->prepare($query);
        $statement->execute();

        if($statement->rowCount() == 0){

            return false;
        }
        else
        {
            return true;
        }
    }

}