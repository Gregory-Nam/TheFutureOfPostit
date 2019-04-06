<?php
session_start();
require_once('bd.php');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


class Utilisateur{

    function connexion(){

        if(!empty($_POST['username']) && !empty($_POST['password']))
        {
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');

            $bd = new bd();
            $dbh = $bd->getBdd();

            $query = "SELECT * FROM utilisateurs where NOM_UTILISATEUR='".$_POST['username']."'";
            $statement = $dbh->prepare($query);
            $statement->execute();
            $test = $statement->fetch(PDO::FETCH_ASSOC);
            if($_POST['username'] == $test['NOM_UTILISATEUR'] && sha1($_POST['password']) == $test['MOT_DE_PASSE'])
            {
                $_SESSION['username'] = $test['NOM_UTILISATEUR'];
                $_SESSION['userid'] = $test['ID'];
                echo json_encode("true");
            }
            else
            {
                echo json_encode("La combinaison est incorrecte");
            }

        }
        else
        {
            echo json_encode("Veuillez saisir tous les champs");
        }

    }

    function deconnexion(){

        // Initialisation de la session.
        // Si vous utilisez un autre nom
        // session_name("autrenom")
        session_start();
        // Détruit toutes les variables de session
        $_SESSION = array();

        // Si vous voulez détruire complètement la session, effacez également
        // le cookie de session.
        // Note : cela détruira la session et pas seulement les données de session !
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalement, on détruit la session.
        session_destroy();
        header("Location: login.php");
    }
}