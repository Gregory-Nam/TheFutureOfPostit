(function(){
    "use strict";
    $(document).ready(function() {
        
        //verification de la connexion
        $('#monForm').submit(function(){
            $.ajax({
                url: '../php/utilisateur_handler.php',
                method:'POST',
                dataType: 'json',
                data: $(this).serialize()
            }).done(function (data) {
                if(data === 'true')
                {
                    window.location.href = '/';

                }
                else if( data === 'mauvais_identifiant')
                {
                    $('#alert').remove();
                    $('#card').append(
                        $('<div/>')
                            .attr({
                            'class' : 'alert alert-danger ml-3 mr-3',
                            'role' : 'alert',
                            'id':'alert'
                        })
                            .html("Combinaison incorrecte")
                    );
                }
                else
                {
                    $('#alert').remove();
                    $('#card').append(
                        $('<div/>')
                            .attr({
                                'class' : 'alert alert-danger ml-3 mr-3',
                                'role' : 'alert',
                                'id':'alert'
                            })
                            .html("Veuillez renseigner tous les champs")
                    );
                }
            });
            return false;
        });





    });
})();
