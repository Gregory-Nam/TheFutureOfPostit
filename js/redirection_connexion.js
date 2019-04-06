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
                else
                {
                    $('#alert').fadeOut('slow',function(){
                        $(this).remove();
                    });
                    $('<div/>')
                        .attr({
                            'class' : 'alert alert-danger ml-3 mr-3',
                            'role' : 'alert',
                            'id':'alert'
                        })
                        .insertBefore($('#formgroup'))
                        .html(data)
                        .hide().delay('600').fadeIn('slow')
                }
            });
            return false;
        });

        $("#non_inscrit").click( function(){
            $('#alert').remove();
            $('#card2').children().hide();
            $('#card2')
                .append($("<h3/>")
                    .html("Inscrivez-vous")
                    .attr('class','text-center mb-4')
                )
                .append($("<form/>")
                    .attr({
                        'autocomplete':'off',
                        'id':'formInscription'
                    })
                    .append($("<div/>")
                        .attr('class','form-group')
                        .append($("<input/>")
                            .attr({
                                'type':'text',
                                'class':'form-control mb-4',
                                'name':'username',
                                'placeholder':'Nom d\'utilisateur'
                            })
                        )
                        .append($("<input/>")
                            .attr({
                                'type':'email',
                                'class':'form-control mb-4',
                                'name':'mail',
                                'placeholder':'Adresse mail'
                            })
                        )
                        .append($("<input/>")
                            .attr({
                                'type':'password',
                                'class':'form-control mb-4',
                                'name':'password',
                                'placeholder':'Mot de passe'
                            })
                        )
                        .append($("<button/>")
                            .attr({
                                'type':'submit',
                                'id':'inscription',
                                'class':'btn btn-primary text-center',
                                'form':'formInscription'
                            })
                            .html("S'inscrire !")
                        )
                        .append($("<br/>"))
                        .append($("<a>")
                            .attr({
                                'href':'#',
                                'class':'text-center mb-3'
                            })
                            .html('Vous avez déjà un compte ?')
                            .click(function(){
                                $('#card2').children().not('#monForm').remove();
                                $('#monForm').show();


                            })
                        )

                    )
                )


        })


        // $("#formInscription").on("submit",function(){
        $(document).on("submit","#formInscription",function(){
            $.ajax({
                url: "../php/register.php",
                type: "POST",
                dataType: 'json',
                data: $(this).serialize()

            })
            .done(function(data) {
                if(data === "true")
                {
                    $('#alert').remove();
                    window.location.href = "/";
                }
                else
                {
                    $('#alert').fadeOut('slow',function(){
                        $(this).remove();
                    })
                    $('#formInscription').prepend(
                        $('<div/>')
                            .attr({
                                'class' : 'alert alert-danger ml-3 mr-3',
                                'role' : 'alert',
                                'id':'alert'
                            })
                            .html(data)
                            .hide().delay(600).fadeIn('slow')
                    )
                }
            }).fail(function (jqXHR, textStatus) {
                alert(jqXHR.responseText);
            })
            return false;

        });





    });
})();
