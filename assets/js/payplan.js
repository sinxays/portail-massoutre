$(document).ready(function () {

    // réglages au chargement de la page
    $("#collaborateur_div").hide();
    // $("#bouton_tableau_commision").focus();
    // $("#bouton_tableau_commision").blur();
    $("#bouton_tableau_commision").addClass("button_selected_tableau_comission");




    // load le tableau payplan 
    $.ajax({
        url: "/payplan/req/req_tableau_payplan.php",
        data: {},
        success: function (data) {
            $("#table_commission").html(data);
        }
    });


    // au select du collaborateur
    $("#select_collaborateur_payplan").change(function (e) {

        id_collaborateur_selected = $("#select_collaborateur_payplan").val()
        $.ajax({
            url: "/payplan/req/onSelect_reprise_achat_collaborateur_filtre.php",
            type: "POST",
            data: { id_collaborateur: id_collaborateur_selected },
            success: function (data) {
                // var parsed = JSON.parse(data);
                // $("#table_collaborateurs_reprise").html(parsed["table_reprise"]);
                // $("#table_collaborateurs_achat").html(parsed["table_achat"]);
                $("#table_achat_reprise").html(data);
            }
        });
    });

    // au select de la destination
    $("#select_destination_payplan").change(function (e) {
        $.ajax({
            url: "/payplan/req/onSelect_commission_filtre.php",
            type: "POST",
            data: { destination: $(this).val() },
            success: function (data) {
                $("#table_payplan").html(data);
                $("#select_type_achat_payplan").val(0);
            }
        });
    });

    // au select du type achat
    $("#select_type_achat_payplan").change(function (e) {
        $.ajax({
            url: "/payplan/req/onSelect_commission_filtre.php",
            type: "POST",
            data: { type_achat: $(this).val() },
            success: function (data) {
                $("#table_payplan").html(data);
                $("#select_destination_payplan").val(0);
            }
        });
    });

    /********************** AU SELECT DATE ***************************/
    $("#select_date_payplan").change(function (e) {
        date_select = this.value;
        tableau_selected = $("#tableau_selected").text();
        console.log(date_select);
        console.log(tableau_selected);

        switch (date_select) {
            //mois en cours
            case '0':
                $("#date_personnalisees_div").fadeOut(200);
                $("#date_payplan_debut").val("");
                $("#date_payplan_fin").val("");

                switch (tableau_selected) {
                    case 'commission':
                        $.ajax({
                            url: "/payplan/req/onSelect_commission_filtre.php",
                            data: {},
                            success: function (data) {
                                $("#table_commission").html(data);
                            }
                        });
                        break;
                    case 'collaborateur':
                        $.ajax({
                            url: "/payplan/req/onSelect_reprise_achat_collaborateur_filtre.php",
                            type: "POST",
                            data: { selected_date: date_select },
                            success: function (data) {
                                $("#table_achat_reprise").html(data);
                            }
                        });
                        break;
                    case 'payplan':
                        $.ajax({
                            url: "/payplan/req/onSelect_payplan_filtre.php",
                            type: "POST",
                            data: { selected_date: date_select },
                            success: function (data) {
                                $("#table_payplan").html(data);
                            }
                        });
                        break;
                }
                break;
            //si on choisit mois précédent
            case '1':
                $("#date_personnalisees_div").fadeOut(200);
                $("#date_payplan_debut").val("");
                $("#date_payplan_fin").val("");
                if (tableau_selected == "commission") {
                    $.ajax({
                        url: "/payplan/req/onSelect_commission_filtre.php",
                        type: "POST",
                        data: { selected_date: date_select },
                        success: function (data) {
                            $("#table_commission").html(data);
                            $("#select_destination_payplan").val(0);
                            $("#select_type_achat_payplan").val(0);
                        }
                    });
                }
                else if (tableau_selected == "collaborateur") {
                    $.ajax({
                        url: "/payplan/req/onSelect_reprise_achat_collaborateur_filtre.php",
                        type: "POST",
                        data: { selected_date: date_select },
                        success: function (data) {
                            $("#table_achat_reprise").html(data);
                        }
                    });
                }
                else if (tableau_selected == "payplan") {
                    $.ajax({
                        url: "/payplan/req/onSelect_payplan_filtre.php",
                        type: "POST",
                        data: { selected_date: date_select },
                        success: function (data) {
                            $("#table_payplan").html(data);
                        }
                    });
                }
                break;
            //date personnalisée
            case '2':
                $("#date_personnalisees_div").fadeIn(200);
                break;

            default:

        }

    });

    //affichage ou non de date fin selon la valeur de la date début 
    $("#date_payplan_debut").change(function (e) {
        date_debut = $("#date_payplan_debut").val();
        if (date_debut !== '') {
            $("#div_date_fin").fadeIn(200);
        } else {
            $("#div_date_fin").fadeOut(200);
        }
    });


    $("#date_payplan_fin").change(function (e) {
        date_debut = $("#date_payplan_debut").val();
        date_fin = this.value;
        tableau_selected = $("#tableau_selected").text();

        console.log(date_debut);
        console.log(date_fin);

        // value_dates_perso = Array(date_debut,date_fin);

        let value_dates_perso = {};
        value_dates_perso['debut'] = date_debut;
        value_dates_perso['fin'] = date_fin;

        console.log(value_dates_perso);

        switch (tableau_selected) {

            case 'commission':
                $.ajax({
                    url: "/payplan/req/onSelect_commission_filtre.php",
                    type: "POST",
                    data: { date_perso: value_dates_perso },
                    success: function (data) {
                        $("#table_commission").html(data);
                        $("#select_destination_payplan").val(0);
                        $("#select_type_achat_payplan").val(0);
                    }
                });
                break;
            case 'collaborateur':
                $.ajax({
                    url: "/payplan/req/onSelect_reprise_achat_collaborateur_filtre.php",
                    type: "POST",
                    data: { date_perso: value_dates_perso },
                    success: function (data) {
                        $("#table_achat_reprise").html();
                        $("#table_achat_reprise").html(data);
                    }
                });
                break;
            case 'payplan':
                $.ajax({
                    url: "/payplan/req/onSelect_payplan_filtre.php",
                    type: "POST",
                    data: { date_perso: value_dates_perso },
                    success: function (data) {
                        $("#table_payplan").html(data);
                    }
                });
                break;
        }
    });

    /************** SELECTION DES TABLEAUX ****************/

    // au select du tableau achat/reprise collaborateur
    $("#bouton_tableau_reprise_achat_collaborateur").click(function (e) {
        $("#tableau_selected").text("collaborateur");

        hide_tables();

        $("#bouton_tableau_reprise_achat_collaborateur").blur();
        $("#bouton_tableau_reprise_achat_collaborateur").addClass("button_selected_tableau_reprise_achat");
        $("#bouton_tableau_payplan").removeClass("button_selected_tableau_payplan");
        $("#bouton_tableau_commision").removeClass("button_selected_tableau_comission");

        //mise a 0 des filtres ou disparition
        reset_filtre();

        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                // var parsed = JSON.parse(data);
                $("#table_achat_reprise").html(data);
                $("#table_achat_reprise").fadeIn(300);
            }
        });
    });

    // au select du tableau payplan
    $("#bouton_tableau_payplan").click(function (e) {
        $("#tableau_selected").text("payplan");

        hide_tables();

        $("#bouton_tableau_payplan").blur();
        $("#bouton_tableau_payplan").addClass("button_selected_tableau_payplan");
        $("#bouton_tableau_reprise_achat_collaborateur").removeClass("button_selected_tableau_reprise_achat");
        $("#bouton_tableau_commision").removeClass("button_selected_tableau_comission");

        //mise a 0 des filtres ou disparition
        reset_filtre();

        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                // var parsed = JSON.parse(data);
                $("#table_payplan").html(data);
                $("#table_payplan").fadeIn(300);
            }
        });
    });

    // au select du tableau commission total
    $("#bouton_tableau_commision").click(function (e) {
        $("#tableau_selected").text("commission");

        hide_tables();

        $("#bouton_tableau_commision").blur();
        $("#bouton_tableau_commision").addClass("button_selected_tableau_comission");
        $("#bouton_tableau_payplan").removeClass("button_selected_tableau_payplan");
        $("#bouton_tableau_reprise_achat_collaborateur").removeClass("button_selected_tableau_reprise_achat");

        //mise a 0 des filtres ou disparition
        reset_filtre();

        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                // var parsed = JSON.parse(data);
                // $("#table_payplan").html(parsed["table_commission_total"]);
                $("#table_commission").html(data);
                $("#table_commission").fadeIn(300);
            }
        });
    });

    // update tableau payplan
    $("#bouton_update_payplan").click(function (e) {
        $("#table_commission").fadeOut(0);
        $("#text_chargement_update").text("Update en cours...");
        $.ajax({
            url: "/payplan/req/update_payplan.php",
            data: {},
            success: function (data) {
                $("#table_commission").html(data);
                $("#table_commission").fadeIn(300);
                $("#text_chargement_update").text("");
            }
        });
    });



});

function reset_filtre() {
    $("#date_payplan_debut").val('');
    $("#date_payplan_fin").val('');
    $("#div_date_fin").fadeOut();
    $("#date_personnalisees_div").fadeOut(100);
    $("#select_date_payplan").val("0");
    $("#select_type_achat_payplan").val(0);
    $("#select_destination_payplan").val(0);
    $("#select_collaborateur_payplan").val(0);
}

function hide_tables() {
    $("#table_payplan").fadeOut(100);
    $("#table_commission").fadeOut(100);
    $("#table_achat_reprise").fadeOut(100);
}



