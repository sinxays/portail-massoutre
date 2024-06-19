$(document).ready(function () {


    let loader = $('#loader');


    $("#btn_ajout_shop_ext").click(function (e) {
        e.preventDefault();

        console.log($("#ajout_shop_exterieur_form").serialize());
        $.ajax({
            url: "../../operations/shop_exterieurs/req/req_ajouter_shop_exterieur.php",
            type: "POST",
            data: $("#ajout_shop_exterieur_form").serialize(),
            success: function () {
                $("#alert_shop_ext_added").show(300);
                window.location.replace("/operations/shop_exterieurs/shop_exterieurs.php");
            },
            error: function () {
                $("#alert_shop_ext_added_fail").show(300);
            }
        });
    });


    $("#div_retour_detail_collaborateur").click(function (e) {
        history.back();
    });

});
