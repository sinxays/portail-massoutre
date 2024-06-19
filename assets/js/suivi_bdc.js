$(document).ready(function () {

    $('#loader').show();

    let date_select = {};
    date_select['value_selected'] = '0';

    $.ajax({
        url: "/pages_stats/req/req_tableau_suivi_bdc.php",
        type: "POST",
        data: { type_tableau: 1, type_date: date_select },
        success: function (data) {
            var parsed = JSON.parse(data);
            $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
            $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
            // $("#table_stats_suivi_bdc_all").html(parsed['tableau_suivi_bdc_all']);
            // $("#table_stats_suivi_bdc_particuliers").html(data);

        }
    });





    // au select du type provenance VH
    $("#select_provenance_vh").change(function (e) {
        e.preventDefault();
        fadeOutSuiviBdcTableau(300);
        let value_provenance = $("#select_provenance_vh").val();

        let date_select = {};
        date_select['value_selected'] = parseInt($("#select_date_suivi_bdc").val());

        console.log(date_select);

        $.ajax({
            url: "/pages_stats/req/req_tableau_suivi_bdc.php",
            type: "POST",
            data: { type_tableau: value_provenance, type_date: date_select },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
                $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
                fadeInSuiviBdcTableau(200);

                // $("#table_stats_suivi_bdc_all").html(parsed['tableau_suivi_bdc_all']);
                // $("#table_stats_suivi_bdc_particuliers").html(data);
            }
        });

    })

    // au select de la date bdc
    $("#date_recup_bdc").change(function (e) {
        let btn_alimenter_suivi = $("#btn_alimenter_suivi_ventes_bdc");
        btn_alimenter_suivi.prop('disabled', false);
    })


    // alimenter suivi ventes bdc
    $("#btn_alimenter_suivi_ventes_bdc").click(function (e) {
        e.preventDefault();

        $("#btn_alimenter_suivi_ventes_bdc").prop('disabled', true);

        fadeOutSuiviBdcTableau(300);

        let date_bdc = $("#date_recup_bdc").val();

        $.ajax({
            url: "/pages_stats/req/req_alimenter_suivi_ventes.php",
            type: "POST",
            data: {
                date: date_bdc
            },
            success: function () {
                // location.reload(true);
            }
        });

    })

    /***** Filtre DATE ******/
    $("#select_date_suivi_bdc").change(function (e) {

        fadeOutSuiviBdcTableau(200);

        let date_select = {};
        date_select['value_selected'] = parseInt($(this).val());

        provenance_selected = parseInt($("#select_provenance_vh").val());
        console.log(date_select);
        console.log(provenance_selected);


        switch (date_select['value_selected']) {
            //mois en cours
            case 0:
                $("#date_personnalisees_div").fadeOut(200);
                $("#date_suivi_bdc_debut").val("");
                $("#date_suivi_bdc_fin").val("");

                switch (provenance_selected) {
                    //locations
                    case 1:
                    case 2:
                        $.ajax({
                            url: "/pages_stats/req/req_tableau_suivi_bdc.php",
                            type: "POST",
                            data: { type_tableau: provenance_selected, type_date: date_select },
                            success: function (data) {
                                var parsed = JSON.parse(data);
                                $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
                                $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
                                fadeInSuiviBdcTableau(200);

                            }
                        });
                        break;
                }
                break;



            //si on choisit mois précédent
            case 1:
                $("#date_personnalisees_div").fadeOut(200);
                $("#date_suivi_bdc_debut").val("");
                $("#date_suivi_bdc_fin").val("");

                switch (provenance_selected) {
                    //locations ou négoce
                    case 1:
                    case 2:
                        $.ajax({
                            url: "/pages_stats/req/req_tableau_suivi_bdc.php",
                            type: "POST",
                            data: { type_tableau: provenance_selected, type_date: date_select },
                            success: function (data) {
                                var parsed = JSON.parse(data);
                                $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
                                $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
                                fadeInSuiviBdcTableau(200);
                            }
                        });
                        break;
                }
                break;


            //date personnalisée
            case 2:
                $("#date_personnalisees_div").fadeIn(200);
                break;
            default:
        }
    });


    //affichage ou non de date fin selon la valeur de la date début 
    $("#date_suivi_bdc_debut").change(function (e) {
        date_debut = $("#date_suivi_bdc_debut").val();
        date_fin = $("#date_suivi_bdc_fin").val();
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

        fadeOutSuiviBdcTableau(300);

        console.log(date_debut);
        console.log(date_fin);

        // value_dates_perso = Array(date_debut,date_fin);

        let value_dates_perso = {};
        value_dates_perso['value_selected'] = 2;
        value_dates_perso['date']['date_personnalise_debut'] = date_debut;
        value_dates_perso['date']['date_personnalise_fin'] = date_fin;

        console.log(value_dates_perso);

        switch (provenance_selected) {
            case 1:
            case 2:
                $.ajax({
                    url: "/pages_stats/req/req_tableau_suivi_bdc.php",
                    type: "POST",
                    data: { type_tableau: provenance_selected, type_date: value_dates_perso },
                    success: function (data) {
                        var parsed = JSON.parse(data);
                        $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
                        $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
                        fadeInSuiviBdcTableau(200);

                    }
                });
                break;
        }

    });

    function fadeOutSuiviBdcTableau(ms) {
        $("#table_stats_suivi_bdc_particuliers").fadeOut(ms);
        $("#table_stats_suivi_bdc_marchands").fadeOut(ms);
    }
    function fadeInSuiviBdcTableau(ms) {
        $("#table_stats_suivi_bdc_particuliers").fadeIn(ms);
        $("#table_stats_suivi_bdc_marchands").fadeIn(ms);
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



