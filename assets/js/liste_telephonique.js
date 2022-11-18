
$(document).ready(function () {



    // menu right nav
    $("*.active").removeClass("active");
    $("#menu_liste_telephnique").addClass("active");

    $("#infra_select_div").hide();
    $("#btn_afficher_all_div").hide();




    // load le tableau liste telephonique
    $.ajax({
        url: "/Liste_telephonique/req/req_liste_telephonique.php",
        success: function (data) {
            $("#table_liste_telephonique").html(data);
            // $("#loader_liste_telephonique").fadeOut(500);

        }
    });


    // recherche collaborateur
    $("#input_collaborateur").change(function (e) {
        let collaborateur = this.value;
    });


    $("#select_type").change(function (e) {
        let type = this.value;
        // $("#loader_liste_telephonique").show();
        $.ajax({
            url: "/Liste_telephonique/req/req_liste_telephonique.php",
            type: "POST",
            data: { type: type },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#select_infrastructure").html(parsed["select_infra"]);
                $("#table_liste_telephonique").html(parsed["tableau_telephonique"]);
                // $("#loader_liste_telephonique").fadeOut(500);
                // $("#infra_select_div").fadeIn(300);

            }
        });
    });

    // recherche par infrastructure
    $("#select_infrastructure").change(function (e) {
        let type = $("#select_type").value;
        let id_infrastructure = this.value;
        // $("#loader_liste_telephonique").show();
        $.ajax({
            url: "/Liste_telephonique/req/req_liste_telephonique.php",
            type: "POST",
            data: { type: type, what_infrastructure: id_infrastructure },
            success: function (data) {
                $("#select_infrastructure").html(data);
                // $("#loader_liste_telephonique").fadeOut(500);
            }
        });
    });



    $("#see_more_infrastructure").click(function (e) {
        $("#loader_liste_telephonique").fadeToggle(500);

    });

});