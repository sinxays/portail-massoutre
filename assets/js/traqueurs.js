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
            data: { type_filtre: 'immatriculation', value: input_immat },
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
            data: { type_filtre: 'mva', value: input_mva },
            success: function (data) {
                $("#table_traqueurs").html(data);
                loader.hide();
            }
        });

    });

    $("#serialnumber_input").keyup(function (e) {
        let input_sn = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_montage_traqueurs.php",
            type: "POST",
            data: { type_filtre: 'sn', value: input_sn },
            success: function (data) {
                $("#table_traqueurs").html(data);
                loader.hide();
            }
        });

    });






});


