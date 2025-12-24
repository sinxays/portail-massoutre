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
        date_debut = $("#date_debut").val();
        date_fin = $("#date_fin").val();
        if (date_debut !== '') {
            $("#div_date_fin").fadeIn(200);
        } else {
            $("#div_date_fin").fadeOut(200);
            $("#btn_valider_date_perso").prop('disabled', true);
        }
    });


    //
    $("#date_suivi_bdc_fin").change(function (e) {
        date_debut = $("#date_suivi_bdc_debut").val();
        date_fin = this.value;
        tableau_selected = $("#tableau_selected").text();

        $("#btn_valider_date_perso").prop('disabled', false);
    });



    $("#btn_valider_date_perso").click(function (e) {
        date_debut = $("#date_suivi_bdc_debut").val();
        date_fin = $("#date_suivi_bdc_fin").val();
        tableau_selected = $("#tableau_selected").text();

        fadeOut_grille_de_gestion(300);

        console.log(date_debut);
        console.log(date_fin);


        let value_dates_perso = {};
        value_dates_perso['value_selected'] = 2;
        value_dates_perso['date'] = {}; // Initialiser l'objet 'date'
        value_dates_perso['date']['date_personnalise_debut'] = date_debut;
        value_dates_perso['date']['date_personnalise_fin'] = date_fin;

        console.log(value_dates_perso);

        switch (provenance_selected) {
            case 1:
            case 2:
                $.ajax({
                    url: "/payplan/req/req_tableau_payplan_grille_de_gestion.php",
                    type: "POST",
                    data: { type_tableau: provenance_selected, type_date: value_dates_perso },
                    success: function (data) {
                        $("#table_payplan_grille_de_gestion").html(data);
                        fadeIn_grille_de_gestion(200);
                    }
                });
                break;
        }

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