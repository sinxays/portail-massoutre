$(document).ready(function () {


    let loader = $('#loader');
    loader.show();

    $.ajax({
        url: "/operations/traqueurs/req/req_tableau_montage_traqueurs.php",
        type: "POST",
        data: {},
        success: function (data) {
            $("#table_traqueurs").html(data);
            loader.hide();
        }
    });

   
    //filtres
    $("#immatriculation_input").keyup(function (e) {
        let input_immat = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_montage_traqueurs.php",
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
            url: "/operations/traqueurs/req/req_tableau_montage_traqueurs.php",
            type: "POST",
            data: { input_mva: input_mva },
            success: function (data) {
                $("#table_traqueurs").html(data);
                loader.hide();
            }
        });

    });





});


