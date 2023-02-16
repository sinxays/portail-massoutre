$(document).ready(function () {

    // réglages au chargement de la page
    var date_value = '';
    var type_tableau = getUrlParameter('type');
    var filtre = getUrlParameter('filtre');
    if (filtre == 'date') {
        var date_value = getUrlParameter('value');
    }
    var id_collaborateur = getUrlParameter('id_detail_collaborateur_payplan_reprise_achat');



    console.log(type_tableau);
    console.log(filtre);
    console.log(id_collaborateur);

    // load le tableau payplan detail collaborateur
    $.ajax({
        url: "/payplan/req/req_tableau_payplan_detail_collaborateur.php",
        type: "POST",
        data: { id_collaborateur: id_collaborateur, type: type_tableau, filtre: filtre, date_value: date_value },
        success: function (data) {
            $("#titre_table").text(type_tableau);
            $("#table_payplan_detail_collaborateur").html(data);
        }
    });



    $("#div_retour_detail_collaborateur").click(function (e) { 
        e.preventDefault();
        
    });




});


//function pour recupérer valeur d'un parametre dans l'url
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
