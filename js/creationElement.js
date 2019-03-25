
        //Je dois créer dynamiquement les postits deux fois
        //Lors de la connexion, je créée chaque postit dynamiquement
        //Lors de l'ajout d'un postit je créée ce postit dynamiquement
        //J'avais de la duplication de code
        //J'ai fais la creation de postit avec une fonction
        function creationPostit(postit) {
            $("#row1").append(
                $("<div/>")
                    .attr('class', 'col-lg-4 mt-5  text-center')
                    .append(
                        $("<div/>").attr({
                            'class': 'card h-100 ',
                            'style': 'width:18rem'
                        })
                            .append(
                                $("<div/>").attr('class', 'card-body mb-5 ')
                                    .append(
                                        $("<h5/>").attr('class', 'card-title mt-4 mb-4').html(postit.nomToHtml()))
                                    .append(
                                        $("<button/>").attr({
                                            'class': 'btn btn-secondary btn-sm ',
                                            'type': 'button',
                                            'data-toggle': 'modal',
                                            'data-target': '#modal_nouvelle_tache',
                                            // 'data-id':idpostituser,
                                            // 'data-nom':nom
                                        }).html('Voir le postit').click(function () {
                                            remplirModal(postit, postit.getIdPostitUser())
                                        })
                                    ).append(
                                    $("<button/>").attr({
                                        'class': 'btn btn-outline-dark btn-sm ml-3',
                                        'type': 'button',
                                    }).html('Supprimer').click(function () {
                                        let button = $(this);
                                        $.ajax({
                                            url: '../php/postit_handler.php',
                                            type: 'POST',
                                            data: {
                                                'postitSupp': postit.getIdBd()
                                            }
                                        }).done(function(data){
                                            button.parents().eq(2).slideUp(1500, function () {
                                                $(this).remove();
                                            })

                                        }).fail(function (jqXHR, textStatus) {
                                            alert(textStatus);
                                        })
                                    })
                                )
                            ).hide().fadeIn('slow')
                    )
            )
        }

        //Il y a un seul modal
        //Ce modal devra etre different selon quel postit on clique
        //Cette fonction rempli le modal avec les infos relatives aux postits
        function remplirModal(postit,index){
            //suppresion du header du modal
            //soit titre et le bouton close
            $("#header_tache").children().remove();
            $("#tache_col").children().remove();
            $("#date_col").children().remove();
            $("#checkbox_col").children().remove();

            $('#monForm2').children().remove();

            //remplissage entete
            $('#header_tache')
                .prepend($('<h5/>').attr('class', 'modal-title').html(postit.nomToHtml()))

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
                for(let index in data) {
                    let tache = new Tache(data[index]);
                    //bonne façon de cast en boolean
                    let etatBool = (tache.getEtat() === '1');
                    console.log(etatBool);
                    $('#tache_col')
                        .append($('<p/>')
                            .attr({
                                'class': 'text-sm-center',
                                'id': index
                            })
                            .html(tache.toHtml()));

                    $('#date_col').append($('<p/>').html(tache.getDate()).attr({
                        'class': 'text-sm-right'
                    }))


                    $('#checkbox_col')
                        .append($('<p/>')
                            .append($("<input/>")
                                .attr({
                                    'type': 'checkbox',
                                    'vertical-align': 'middle',
                                    'data-postit': postit.getIdBd(),
                                    'name': 'tache',
                                    'data-postituser': postit.getIdPostitUser(),
                                    'data-t': index,
                                    'for': index
                                })
                                .prop("checked",etatBool )
                                .html(tache.toHtml()))
                        )





                }
                $("input[type='checkbox']:checked").each(function(){
                    $('#'+$(this).attr('for')).wrap("<strike>");

                })

            });

            $('#monForm2')
                .attr({
                    'data-idbd':postit.getIdBd(),
                    'data-id':index
                })
                .append($('<div/>').attr('class','input-group mb-3 mt-3')
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
                        'class':'form-control w-25',
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





