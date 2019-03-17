
(function(){
    "use strict";
    $(document).ready(function() {
        //Je dois créer dynamiquement les postits deux fois
        //Lors de la connexion, je créée chaque postit dynamiquement
        //Lors de l'ajout d'un postit je créée ce postit dynamiquement
        //J'avais de la duplication de code
        //J'ai fais la creation de postit avec une fonction
        function creationPostit(postit){
            $("#row1").append(
                $("<div/>").attr('class', 'col-lg-4 text-center').append(
                    $("<div/>").attr({
                        'class':'card mt-5',
                        'style':'width:18rem'
                    }).append(
                        $("<div/>").attr('class', 'card-body').append(
                            $("<h5/>").attr('class', 'card-title mt-2').html(postit.nomToHtml())
                        ).append(
                            $("<button/>").attr({
                                'class': 'btn btn-secondary',
                                'type': 'button',
                                'data-toggle': 'modal',
                                'data-target': '#modal_nouvelle_tache',
                                // 'data-id':idpostituser,
                                // 'data-nom':nom
                            }).html('Voir le postit').click(function(){
                                remplirModal(postit,postit.getIdPostitUser())
                            })
                        )
                    )
                )

            );

        }

        //Il y a un seul modal
        //Ce modal devra etre different selon quel postit on clique
        //Cette fonction rempli le modal avec les infos relatives aux postits
        function remplirModal(postit,index){
            //suppresion du header du modal
            //soit titre et le bouton close
            $("#header_tache").children().remove();
            $("#body_tache").children().not('#monForm2').remove();
            $('#monForm2').children().remove();

            //remplissage entete
            $('#header_tache')
                .prepend($('<h5/>').attr('class', 'modal-title').html(postit.nomToHtml()))
                .append($('<button/>').attr({
                    'type' : 'button',
                    'class' : 'close',
                    'data-dismiss' : 'modal',
                    'arial-label' : 'Close'
                }).append($('<span/>').attr('aria-hidden','true').html('&times;')));

            //affichage des taches dans le modal
            $.ajax({
                url:'../php/postit_handler.php',
                dataType:'json',
                type:'POST',
                data:{
                    // correspond a $_POST['idpostituser'] = à l'id passé en parametre
                    // on s'en sert dans postit handler pour echo json encode les taches du postit
                    idpostituser:postit.getIdPostitUser(),
                }
            }).done(function(data){
               console.log(data);
               for(let index in data){
                   let tache = new Tache(data[index]);
                   $('#body_tache')
                       .prepend($('<p/>').attr('class','text-center').html(tache.toHtml()));
               }
            });

            $('#monForm2')
                .attr({
                    'data-idbd':postit.getIdBd(),
                    'data-id':index
                })
                .append($('<div/>').attr('class','input-group mb-3')
                    .append($('<div/>')
                    .attr({
                        'class':'input-group-preprend',
                        'id':'formgroup_tache',

                    })
                    .append($('<span/>')
                        .html('Nouvelle tache')
                        .attr({
                            'class':'input-group-text',
                            'id':'titre_input_tache',

                        })
                    )

                )
                .append($('<input/>').attr({
                    'type':'text',
                    'class':'form-control w-50  ',
                    'aria-label':'Nouvelle tache',
                    'name':'titre_input_tache',
                    'id':'titre_input_tache',
                    'form':'monForm2'
                }))
                .append($('<input/>')
                    .attr({
                        'type':'date',
                        'class':'form-control',
                        'name':'date_input_tache',
                        'id':'date_input_tache',
                        'form':'monForm2'
                    })
                )

            )
            $('#send2').attr('form','monForm2');

        }

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
                    let postit = new Postit(data[index],index);
                    creationPostit(postit);

                }
            }

        });

        //ajout d'un postit
        //le postit est enregistrer dans la BDD dans form_postit.php
        $("#monForm").submit(function () {
            alert("test");
            //permet de fermer le modal avant de créer dynamiquement le postit
            $("#send").attr('data-dismiss','modal').click().removeAttr('data-dismiss');
            $.ajax({
                url: "php/postit_handler.php",
                type: "POST",
                dataType: 'json',
                data: $(this).serialize()
            }).done(function(data){
                let index = data.length - 1;
                let postit = new Postit(data[index],index)
                creationPostit(postit);
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

                if(typeof data === 'object')
                {
                    $('#erreur_tache').remove();
                    $('#body_tache')
                        .prepend( $('<div/>')
                            .attr({
                                'class': 'alert alert-warning',
                                'id':'erreur_tache'
                            })
                            .append($('<p/>')
                                .attr('class', 'text-center mb-0')
                                .html(data.message)
                            )
                        )
                }
                else{
                    $('#erreur_tache').remove();
                    let tache = new Tache(data);
                    $('#body_tache').prepend($("<p/>").attr("class","text-center").html(tache.toHtml()));
                }

            })
            return false;
        });


    });
})();