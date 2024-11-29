$(document).ready(function () {

    //bouton retrour arriere
    $("#div_retour_liste_traqueurs").click(function (e) {
        window.location.replace("/operations/traqueurs/liste_traqueurs.php");
    });


    let loader = $('#loader');
    loader.show();

    $.ajax({
        url: "/operations/traqueurs/req/req_tableau_liste_traqueurs.php",
        success: function (data) {
            $("#table_liste_traqueurs").html(data);
            loader.hide();
        }
    });


    // click sur le bouton créer un montage traqueur
    $("#btn_create_montage_traqueur").click(function (e) {
        e.preventDefault();
        console.log($("#form_ajout_montage_traqueur").serialize());
        $.ajax({
            url: "../../operations/traqueurs/req/req_modif_ajout_montage_traqueur.php",
            type: "POST",
            data: { data: $("#form_ajout_montage_traqueur").serialize(), type: "create" },
            success: function () {
                window.location.replace("/operations/traqueurs/traqueurs.php");
            },
            error: function () {
            }
        });
    });


    // click sur le bouton update un montage traqueur
    $("#btn_modif_montage_traqueur").click(function (e) {
        e.preventDefault();
        console.log($("#form_montage_traqueurs").serialize());
        $.ajax({
            url: "../../operations/traqueurs/req/req_modif_ajout_montage_traqueur.php",
            type: "POST",
            data: $("#form_montage_traqueurs").serialize(),
            success: function () {
                die();
                window.location.replace("/operations/traqueurs/traqueurs.php");
                $("#alert_shop_ext_modif_success").show(300);
            },
            error: function () {
                $("#alert_shop_ext_modif_fail").show(300);
            }
        });
    });




});


