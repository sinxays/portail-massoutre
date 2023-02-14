$(document).ready(function () {

    // réglages au chargement de la page
    var type = getUrlParameter('type');
    var filtre = getUrlParameter('filtre');
    if(filtre=='date'){
        
    }
    var id_collaborateur = getUrlParameter('id_detail_collaborateur_payplan_reprise_achat');



    console.log(type);
    console.log(filtre);
    console.log(id_collaborateur);

    // load le tableau payplan detail collaborateur
    $.ajax({
        url: "/payplan/req/req_tableau_payplan_detail_collaborateur.php",
        type: "POST",
        data: { id_collaborateur: id_collaborateur, type: type, filtre: filtre },
        success: function (data) {
            $("#titre_table").text(type);
            $("#table_payplan_detail_collaborateur").html(data);
        }
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
