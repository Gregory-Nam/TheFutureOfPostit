(function(){
    $(document).ready(function(){
        'use strict';
        //ajout d'un postit
        //le postit est enregistrer dans la BDD dans form_postit.php
        $("#monForm").submit(function () {
            //permet de fermer le modal avant de créer dynamiquement le postit
            $.ajax({
                url: "php/postit_handler.php",
                type: "POST",
                dataType: 'json',
                data: $(this).serialize()
            }).done(function(data){
                if(typeof data === 'string')
                {
                    $('#erreur_postit').fadeOut('slow',function(){
                        $(this).remove();
                    })
                    $('#modal_postit')
                        .prepend( $('<div/>')
                            .attr({
                                'class': 'alert alert-warning',
                                'id':'erreur_postit'
                            })
                            .append($('<p/>')
                                .attr('class', 'text-sm-center mb-0')
                                .html(data)
                            ).hide().delay(600).fadeIn('slow')
                        )

                }
                else
                {
                    $('#erreur_postit').remove();
                    $("#send").attr('data-dismiss','modal').click().removeAttr('data-dismiss');

                    let index = data.length - 1;
                    let postit = new Postit(data[index],index)
                    creationPostit(postit);

                }
            })
            return false;
        });


        $("#monForm2").submit(function(){
            // $("#send2").attr('data-dismiss','modal').click().removeAttr('data-dismiss');
            let idBd = $(this).attr('data-idBd');
            let id = $(this).attr('data-id')
            $.ajax({
                url:"php/tache.php",
                type:"POST",
                dateType:'json',
                data: $(this).serialize() + '&idbd=' + idBd + '&id=' + id

            }).done(function(data){

                if(typeof data === 'string')
                {
                    $('#erreur_tache').fadeOut('slow',function(){
                        $(this).remove();
                    })
                    $('#body_tache')
                        .prepend( $('<div/>')
                            .attr({
                                'class': 'alert alert-warning',
                                'id':'erreur_tache'
                            })
                            .append($('<p/>')
                                .attr('class', 'text-sm-center mb-0')
                                .html(data)
                            ).hide().delay(600).fadeIn('slow')
                        )
                }
                else{
                    $('#erreur_tache').remove();
                    let tache = new Tache(data);
                    $('#tache_col')
                        .append($('<p/>')
                            .attr({
                                'class':'text-sm-center',
                                'id': tache.getIdTacheUser()
                            })
                            .html(tache.toHtml())
                            .hide().fadeIn('slow')
                        );

                    $('#date_col').append($('<p/>').html(tache.getDate()).attr({
                        'class':'text-sm-right',
                    }).hide().fadeIn('slow'))

                    $('#checkbox_col')
                        .append($('<p/>')
                            .append($("<input/>")
                                .attr({
                                    'type':'checkbox',
                                    'vertical-align':'middle',
                                    'for':tache.getIdTacheUser(),
                                    'data-t':tache.getIdTacheUser(),
                                    'data-postit':idBd,
                                    'data-postituser':id,
                                    'name':'tache'
                                })

                                .html(tache.toHtml())
                                .hide().fadeIn('slow'))
                        )


                }


            })
            return false;
        });



    })
})();

