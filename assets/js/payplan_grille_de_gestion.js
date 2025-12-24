$(document).ready(function () {

    $('#loader').show();

    let date_select = {};
    date_select['value_selected'] = '0';

    $.ajax({
        url: "/payplan/req/req_tableau_payplan_grille_de_gestion.php",
        type: "POST",
        data: { collaborateur: 0, date: date_select },
        success: function (data) {
            $("#table_payplan_grille_de_gestion").html(data);
            // $("#table_stats_suivi_bdc_all").html(parsed['tableau_suivi_bdc_all']);
            // $("#table_stats_suivi_bdc_particuliers").html(data);

        }
    });


    /***** Filtre DATE ******/
    $("#select_date_grille_de_gestion").change(function (e) {
        fadeOut_grille_de_gestion(200);

        $("#date_debut").val("");
        $("#date_fin").val("");

        let date_select = {};
        date_select['value_selected'] = parseInt($(this).val());

        collaborateur_selected = parseInt($("#select_collaborateur_grille_de_gestion").val());
        console.log(date_select);
        console.log(collaborateur_selected);

        $("#date_personnalisees_div").fadeOut(200);
        $("#date_suivi_bdc_debut").val("");
        $("#date_suivi_bdc_fin").val("");

        /*si dates personnalisées*/
        if (date_select['value_selected'] == 2) {
            $("#date_personnalisees_div").fadeIn(200);
            // let date_select = {};
            // date_select['value_selected']['debut'] = date_debut;
            // date_select['value_selected']['fin'] = date_fin;
        }
        else {
            $.ajax({
                url: "/payplan/req/req_tableau_payplan_grille_de_gestion.php",
                type: "POST",
                data: { collaborateur: collaborateur_selected, date: date_select },
                success: function (data) {
                    $("#table_payplan_grille_de_gestion").html(data);
                    fadeIn_grille_de_gestion(200);
                }
            });
        }




    });


    //affichage ou non de date fin selon la valeur de la date début 
    $("#date_debut").change(function (e) {
        date_debut = this.value;
        date_fin = $("#date_fin").val();
        if (date_debut !== '') {
            $("#div_date_fin").fadeIn(200);
        } else {
            $("#div_date_fin").fadeOut(200);
            $("#btn_valider_date_perso").prop('disabled', true);
        }
    });


    //au changement sur la date de fin
    $("#date_fin").change(function (e) {
        date_fin = this.value
        if (date_fin !== '') {
            $("#btn_valider_date_perso").prop('disabled', false);
        } else {
            $("#btn_valider_date_perso").prop('disabled', true);
        }
    });



    $("#btn_valider_date_perso").click(function (e) {
        date_type_selected = $("#select_date_grille_de_gestion").val();
        date_debut = $("#date_debut").val();
        date_fin = $("#date_fin").val();
        collaborateur_selected = $("#select_collaborateur_grille_de_gestion").val();

        fadeOut_grille_de_gestion(300);

        console.log(date_debut);
        console.log(date_fin);
        console.log(collaborateur_selected);


        let value_dates_perso = {
            value_selected: date_type_selected,
            dates: {
                debut: date_debut,
                fin: date_fin
            }
        };

        console.log(value_dates_perso);


        $.ajax({
            url: "/payplan/req/req_tableau_payplan_grille_de_gestion.php",
            type: "POST",
            data: { collaborateur: collaborateur_selected, date: value_dates_perso },
            success: function (data) {
                $("#table_payplan_grille_de_gestion").html(data);
                fadeIn_grille_de_gestion(200);
            }
        });



    });

    function fadeOut_grille_de_gestion(ms) {
        $("#table_payplan_grille_de_gestion").fadeOut(ms);
    }

    function fadeIn_grille_de_gestion(ms) {
        $("#table_payplan_grille_de_gestion").fadeIn(ms);
    }

    // Afficher le loader avant l'envoi de la requête AJAX
    $(document).ajaxSend(function () {
        $('#loader').show();
    });

    // Cacher le loader lorsque la requête AJAX est terminée
    $(document).ajaxComplete(function () {
        $('#loader').hide();
    });


});