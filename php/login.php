<?php
    session_start();
    if(isset($_SESSION['username'])) {
        header("location: /");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>THE FUTURE OF POSTIT</title>
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="/js/jquery-3.3.1.js"></script>
        <script src="/js/redirection_connexion.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh">
            <div class="col-4">
                <div class="card" id="card">
                    <div class="card-body">
                        <form action="" autocomplete="off" id="monForm">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                            </div>
                            <button type="submit" id="sendlogin" class="btn btn-primary"> Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>-->
    </body>
</html>
