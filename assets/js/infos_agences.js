$(document).ready(function () {

    // menu right nav
    $("*.active").removeClass("active");
    $("#menu_infos").addClass("active");
    $("#menu_infos_agence").addClass("active");



    // load le tableau des agences 
    $.ajax({
        url: "/Infos/req/req_tableau.php",
        type: "POST",
        data: { type: "agence" },
        success: function (data) {
            $("#table_agences_infos").html(data);
        }
    });


    // recherche d'une agence
    $("#input_search_agence").keyup(function (e) {
        let tmp_search_agence = $(this).val();
        if (tmp_search_agence !== '') {
            $.ajax({
                url: "/Infos/req/onSearch_agence.php",
                type: "POST",
                data: { agence: $(this).val() },
                success: function (data) {
                    $("#table_agences_infos").html(data);
                }
            });
        } else {
            $.ajax({
                url: "/Infos/req/req_tableau.php",
                type: "POST",
                data: { type: "agence" },
                success: function (data) {
                    $("#table_agences_infos").html(data);
                }
            });
        }
    });





});


/***** FONCTIONS *****/

function get_agence(ID_agence) {

    $.ajax({
        url: "/Infos/req/onSearch_agence.php",
        type: "POST",
        data: { id_agence: ID_agence },
        success: function (data) {
            $("#table_agences_infos").html(data);
            $("#search_agence").val('');
        }
    });

}

function modifier_agence(ID_agence) {
    $("#id_agence_modifier").val(ID_agence);
    let test = $("#id_agence_modifier").val();
    // alert(test);
    $("#modifier_agence_form").submit();
}












