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


    $("#input_immat").keyup(function (e) {
        if ($(this).val().length === 7) {
            // Code à exécuter lorsque 7 caractères sont saisis
            console.log("7 caractères ont été saisis !");

            $.ajax({
                url: "../../operations/shop_exterieurs/req/req_ajout_mva_km_automatique.php",
                type: "POST",
                data: { immatriculation: $(this).val() },
                success: function (data) {
                    var parsed = JSON.parse(data);
                    $("#input_mva").val(parsed["mva"]);
                    $("#input_km").val(parsed["km"]);
                },
                error: function () {
                    //todo if error
                }
            });


        }
    });





    $("#div_retour_detail_collaborateur").click(function (e) {
        history.back();
    });

});
