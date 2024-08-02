$(document).ready(function () {


    let loader = $('#loader');
    loader.show();


    $.ajax({
        url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
        type: "POST",
        data: {},
        success: function (data) {
            $("#table_shop_exterieur").html(data);
            loader.hide();
        }
    });


    $('#btn_creer_shop_ext').click(function (e) {
        window.location.href = '/operations/shop_exterieurs/ajout_shop_exterieur.php';
    });


    $("#div_retour_detail_collaborateur").click(function (e) {
        history.back();
    });


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $("#immatriculation_input").keyup(function (e) {
        let input_immat = $(this).val();
        console.log(input_immat);
        loader.show();

        $.ajax({
            url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
            type: "POST",
            data: { input_immat: input_immat },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });
    $("#mva_input").keyup(function (e) {
        let input_mva = $(this).val();
        console.log(input_mva);
        loader.show();

        $.ajax({
            url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
            type: "POST",
            data: { input_mva: input_mva },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });
    $("#categories").change(function (e) {
        let select_categorie = $(this).val();
        console.log(select_categorie);
        loader.show();

        $.ajax({
            url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
            type: "POST",
            data: { categorie: select_categorie },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });

});


