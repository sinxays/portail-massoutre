$(document).ready(function () {

    // load le select secteur
    $.ajax({
        url: "/pages_stats/req/req_secteurs.php",
        data: {},
        success: function (data) {
            $("#afficherSecteurs_select").html(data);
        }
    });

    // load le select district
    $.ajax({
        url: "/pages_stats/req/req_district.php",
        data: {},
        success: function (data) {
            $("#afficherDistrict_select").html(data);
        }
    });

    // load le tableau des marges 
    $.ajax({
        url: "/marge/req/req_tableau_marges.php",
        data: {},
        success: function (data) {
            $("#table_marge").html(data);
        }
    });


    // au select de l'agence
    $("#afficher_agence").change(function (e) {
        $.ajax({
            url: "/marge/req/onSelect_agence.php",
            type: "POST",
            data: { id_agence: $(this).val() },
            success: function (data) {
                $("#table_marge").html(data);
                $("#afficherResultats_select").val("tous");
                $("#afficherSecteurs_select").val(0);
                $("#afficherDistrict_select").val(0);

            }
        });
    });


    // au select du secteur
    $("#afficherSecteurs_select").change(function (e) {
        $.ajax({
            url: "/marge/req/onSelect_secteur.php",
            type: "POST",
            data: { id_secteur: $(this).val() },
            success: function (data) {
                $("#table_marge").html(data);
                $("#afficherResultats_select").val("tous");
                $("#afficher_agence").val(0);
                $("#afficherDistrict_select").val(0);
            }
        });
    });


    // au select du district
    $("#afficherDistrict_select").change(function (e) {
        $.ajax({
            url: "/marge/req/onSelect_district.php",
            type: "POST",
            data: { id_district: $(this).val() },
            success: function (data) {
                $("#table_marge").html(data);
                $("#afficherResultats_select").val("tous");
                $("#afficher_agence").val(0);
                $("#afficherSecteurs_select").val(0);
            }
        });
    });





});
