$(document).ready(function () {


    let loader = $('#loader');
    loader.show();

    $.ajax({
        url: "/operations/traqueurs/req/req_tableau_traqueurs.php",
        type: "POST",
        data: {},
        success: function (data) {
            $("#table_traqueurs").html(data);
            loader.hide();
        }
    });

    $("#button_ajouter_montage_traqueur").click(function (e) {
        e.preventDefault();

        console.log($("#form_ajout_montage_traqueur").serialize());
        $.ajax({
            url: "../../operations/traqueurs/req/req_ajouter_montage_traqueur.php",
            type: "POST",
            data: $("#form_ajout_montage_traqueur").serialize(),
            success: function () {
                window.location.replace("/operations/traqueurs/traqueurs.php");
            },
            error: function () {
            }
        });
    });


    //filtres
    $("#immatriculation_input").keyup(function (e) {
        let input_immat = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_traqueurs.php",
            type: "POST",
            data: { input_immat: input_immat },
            success: function (data) {
                $("#table_traqueurs").html(data);
                loader.hide();
            }
        });

    });
    $("#mva_input").keyup(function (e) {
        let input_mva = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_traqueurs.php",
            type: "POST",
            data: { input_mva: input_mva },
            success: function (data) {
                $("#table_traqueurs").html(data);
                loader.hide();
            }
        });

    });





});


