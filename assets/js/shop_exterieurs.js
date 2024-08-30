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
        let type_select = $("#select_type").val();
        loader.show();

        $.ajax({
            url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
            type: "POST",
            data: { input_immat: input_immat, type: type_select },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });
    $("#mva_input").keyup(function (e) {
        let input_mva = $(this).val();
        let type_select = $("#select_type").val();
        loader.show();

        $.ajax({
            url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
            type: "POST",
            data: { input_mva: input_mva, type: type_select },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });
    $("#select_categories").change(function (e) {
        let select_categorie = $(this).val();
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


    $("#select_type").change(function (e) {
        let select_type = $(this).val();
        console.log(select_type);
        loader.show();

        $.ajax({
            url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
            type: "POST",
            data: { type: select_type },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });



});


