$(document).ready(function () {

  

    // load le tableau payplan 
    $.ajax({
        url: "/payplan/req/req_tableau_payplan.php",
        data: {},
        success: function (data) {
            $("#table_payplan").html(data);
        }
    });


    // au select du collaborateur
    $("#select_collaborateur").change(function (e) {
        $.ajax({
            url: "/payplan/req/onSelect_collaborateur.php",
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


    // au select du site
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

});
