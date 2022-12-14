$(document).ready(function () {

    // réglages au chargement de la page
    $("#collaborateur_div").hide();
    $("#bouton_tableau_commision").focus();



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


    // au select du tableau collaborateurs
    $("#bouton_tableau_collaborateurs").click(function (e) {
        $("#table_payplan").fadeOut(0);
        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                $("#table_payplan").html(data);
                $("#table_payplan").fadeIn(300);
                $("#select_site_payplan").val(0);
                $("#collaborateur_div").fadeIn(300);
            }
        });
    });

    // au select du tableau comission total
    $("#bouton_tableau_commision").click(function (e) {
        $("#table_payplan").fadeOut(0);
        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                $("#table_payplan").html(data);
                $("#table_payplan").fadeIn(300);
                $("#select_site_payplan").val(0);
                $("#collaborateur_div").fadeOut(300);

            }
        });
    });

    // au select du tableau collaborateurs
    $("#bouton_update_payplan").click(function (e) {
        $("#table_payplan").fadeOut(0);
        $.ajax({
            url: "/payplan/req/req_tableau_payplan.php",
            data: {},
            success: function (data) {
                $("#table_payplan").html(data);
                $("#table_payplan").fadeIn(300);
            }
        });
    });




});
