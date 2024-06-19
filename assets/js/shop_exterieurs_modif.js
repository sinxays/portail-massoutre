$(document).ready(function () {

    $("#div_retour_detail_collaborateur").click(function (e) {
        history.back();
    });

    $("#button_ajouter_action").click(function (e) {
        e.preventDefault();
        console.log($("#form_ajout_action").serialize());
        $.ajax({
            url: "../../operations/shop_exterieurs/req/req_ajouter_action.php",
            type: "POST",
            data: $("#form_ajout_action").serialize(),
            success: function () {
                location.reload();
            },
            error: function () {
                $("#alert_action_added_fail").show(300);
            }
        });
    });


    $("#btn_modif_shop_ext").click(function (e) {
        e.preventDefault();
        console.log($("#form_shop_ext").serialize());
        $.ajax({
            url: "../../operations/shop_exterieurs/req/req_modif_shop_ext.php",
            type: "POST",
            data: $("#form_shop_ext").serialize(),
            success: function () {
                window.location.replace("/operations/shop_exterieurs/shop_exterieurs.php");
                $("#alert_shop_ext_modif_success").show(300);

            },
            error: function () {
                $("#alert_shop_ext_modif_fail").show(300);
            }
        });
    });


});
