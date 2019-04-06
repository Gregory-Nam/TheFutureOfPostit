
(function(){
    "use strict";
    $(document).ready(function() {

        $('#closepostit').click(function () {
            $('#erreur_tache').remove();
            $('input[type=checkbox]').each(function () {
                let idTask = $(this).attr('data-t');
                let idPostit = $(this).attr('data-postit');
                let idPostitUser = $(this).attr('data-postituser')
                let etat = $(this).prop("checked") ? '1' : '0';
                $.ajax({
                    url: "php/postit_handler.php",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'idTask': idTask,
                        'idPostit': idPostit,
                        'idPostitUser': idPostitUser,
                        'etat': etat
                    }
                }).done(function (data) {
                    $('input').val('');
                }).fail(function (jqXHR, textStatus) {
                    alert(textStatus);
                })

            });
        })

        $('#fermernouveau').click(function(){
            $('#erreur_postit').remove();
        })

        $(document).on("change", "input[type='checkbox']", function () {
            if ($(this).is(":checked")) {
                $('#' + $(this).attr('for'))
                    .prop("checked", true)
                    .wrap("<strike>").fadeIn(1000);

            } else {
                $('#' + $(this).attr('for')).unwrap()
                    .prop("checked", false);

            }
        })




    })

})();