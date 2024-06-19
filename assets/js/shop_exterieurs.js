$(document).ready(function () {


    let loader = $('#loader');
    loader.show();

    let categorie = 0;

    console.log(categorie);

    $.ajax({
        url: "/operations/shop_exterieurs/req/req_tableau_shop_exterieurs.php",
        type: "POST",
        data: { categorie: categorie },
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


});


