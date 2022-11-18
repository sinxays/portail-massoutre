function modifier_cvo(ID_cvo) {
    $("#id_cvo_modifier").val(ID_cvo);

    //submit le form de cvo.php
    $("#modifier_cvo_form").submit();
}


$(document).ready(function () {

    // menu right nav
    $("*.active").removeClass("active");
    $("#menu_infos").addClass("active");
    $("#menu_infos_cvo").addClass("active");



    // load le tableau des agences 
    $.ajax({
        url: "/Infos/req/req_tableau.php",
        type: "POST",
        data: { type: "cvo" },
        success: function (data) {
            $("#table_cvo_infos").html(data);
        }
    });

});