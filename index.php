<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>THE FUTURE OF POST IT</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">


        <script src="/js/jquery-3.3.1.js"></script>


        <script src="/js/redirection_connexion.js"></script>
        <script src="/js/gestion_affichage.js"></script>
        <script src="/js/verif_deconnexion.js"></script>

        <script src="/js/taches.js"></script>
        <script src="/js/postit.js"></script>

        <script src="/js/creationElement.js"></script>
        <script src="/js/formulaires.js"></script>










    </head>
    <style>
        html,body{
            height:100%;
        }
    </style>

    <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand" href="#">The Future Of Post IT</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto" id="navbarList">
                    <li class="nav-item active">
                        <a class="nav-link" href=".">Mes Post-IT
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container" id="mesPostits">
        <div class="row" id="row1">
            <div class="col-lg-4 mt-5 bt-5 text-center" id="col0" >
                <div class="card h-100" style="width: 18rem;">
                    <div class="card-body">
                        <button class="btn btn-outline-light mt-3" data-toggle="modal" data-target="#modal_nouveau_postit"> <img class="card-img-top w-25 h-25" src="img/plus_button.png" > </button>
                        <h5 class="card-title mt-2"> Ajouter un post-it !</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php
    include("php/modals.php");
    ?>
    </body>

</html>
