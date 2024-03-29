$(document).ready(function () {

    let type = $("#type_tableau");
    // load le tableau reseau
    $.ajax({
        url: "/pages_stats/req/req_tableau_suivi_bdc.php",
        type: "POST",
        data: { type_tableau: 1 },
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
        $("#table_stats_suivi_bdc_particuliers").fadeOut(300);
        $("#table_stats_suivi_bdc_marchands").fadeOut(300);
        let value_provenance = $("#select_provenance_vh").val();
        $.ajax({
            url: "/pages_stats/req/req_tableau_suivi_bdc.php",
            type: "POST",
            data: { type_tableau: value_provenance },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
                $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
                $("#table_stats_suivi_bdc_particuliers").fadeIn(500);
                $("#table_stats_suivi_bdc_marchands").fadeIn(500);

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

    //au select de la date facture
    $("#date_recup_factures").change(function (e) {
        let btn_alimenter_suivi = $("#btn_alimenter_suivi_ventes_factures");
        btn_alimenter_suivi.prop('disabled', false);
    })

    // alimenter suivi ventes bdc
    $("#btn_alimenter_suivi_ventes_bdc").click(function (e) {
        e.preventDefault();

        $("#btn_alimenter_suivi_ventes_bdc").prop('disabled', true);

        $("#table_stats_suivi_bdc_particuliers").fadeOut(300);
        $("#table_stats_suivi_bdc_marchands").fadeOut(300);

        let date_bdc = $("#date_recup_bdc").val();
        let value_provenance = $("#select_provenance_vh").val();
        let type_recup = "bdc";

        $.ajax({
            url: "/pages_stats/req/req_alimenter_suivi_ventes.php",
            type: "POST",
            data: {
                type_recup: type_recup,
                date: date_bdc,
                provenance_vh: value_provenance
            },
            success: function (data) {
                /* var parsed = JSON.parse(data);
                $("#table_stats_suivi_bdc_particuliers").html(parsed['tableau_suivi_bdc_locations_particuliers']);
                $("#table_stats_suivi_bdc_marchands").html(parsed['tableau_suivi_bdc_locations_marchands']);
                $("#table_stats_suivi_bdc_particuliers").fadeIn(300);
                $("#table_stats_suivi_bdc_marchands").fadeIn(300);
                */
                location.reload(true);


            }
        });

    })


    // alimenter suivi ventes factures
    $("#btn_alimenter_suivi_ventes_factures").click(function (e) {
        e.preventDefault();

        $("#btn_alimenter_suivi_ventes_factures").prop('disabled', true);

        $("#table_stats_suivi_bdc_particuliers").fadeOut(300);
        $("#table_stats_suivi_bdc_marchands").fadeOut(300);

        let date_bdc = $("#date_recup_factures").val();
        let value_provenance = $("#select_provenance_vh").val();
        let type_recup = "factures";

        $.ajax({
            url: "/pages_stats/req/req_alimenter_suivi_ventes.php",
            type: "POST",
            data: {
                type_recup: type_recup,
                date: date_bdc,
                provenance_vh: value_provenance
            },
            success: function (data) {
                location.reload(true);
            }
        });

    })


});



