$(document).ready(function () {


    let loader = $('#loader');
    loader.show();

    $.ajax({
        url: "/operations/shop_exterieurs/req/req_tableau_traqueurs.php",
        type: "POST",
        data: {},
        success: function (data) {
            $("#table_shop_exterieur").html(data);
            loader.hide();
        }
    });





});


