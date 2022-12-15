$(document).ready(function () {

    // réglages au chargement de la page
    const value_id = $("#span_id_collaborateur").text();

    // load le tableau payplan detail collaborateur
    $.ajax({
        url: "/payplan/req/req_tableau_payplan_detail_collaborateur.php",
        type: "POST",
        data: { id_collaborateur: value_id },
        success: function (data) {
            $("#table_payplan_detail_collaborateur").html(data);
        }
    });






});
