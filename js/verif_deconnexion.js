(function(){
    'use strict';
    $(document).ready(function(){
        //verification si la personne est connecté
        //le bouton deconnexion est affiché si la personne est connecter ainsi que tout ses postits
        //sinon il est redirigé vers la page de login
        $.ajax({
            url: '/php/is_connected.php',
            dataType: 'json',
        }).done(function (data) {
            if (data === false)
            {
                window.location.href = "/php/login.php";

            }
            else
            {
                console.log(data);
                $('#navbarList').append('<li class="nav-item"></li>')
                    .append('<a class="nav-link" href="/php/utilisateur_handler.php?action=deco">Déconnexion</a>');

                //data correspond a la variable session lorsque l'utilisateur est co
                //$_SESSION['postits'] comporte tous les postits de l'utilisateur connecté
                for(let index in data){
                    let postit = new Postit(data[index],index)
                    creationPostit(postit);

                }
            }

        });
    })
})();