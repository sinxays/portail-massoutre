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
            $("#table_payplan").html(data);
        }
    });


    // au select du collaborateur
    $("#select_collaborateur_payplan").change(function (e) {
        id_collaborateur_selected = $("#select_collaborateur_payplan").val()
        $.ajax({
            url: "/payplan/req/onSelect_payplan_collaborateur_filtre.php",
            type: "POST",
            data: { id_collaborateur: id_collaborateur_selected },
            success: function (data) {
                // var parsed = JSON.parse(data);
                // $("#table_collaborateurs_reprise").html(parsed["table_reprise"]);
                // $("#table_collaborateurs_achat").html(parsed["table_achat"]);
                $("#table_payplan_achat_reprise").html(data);
            }
        });
    });

    // au select de la destination
    $("#select_destination_payplan").change(function (e) {
        $.ajax({
            url: "/payplan/req/onSelect_payplan_filtre.php",
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
            url: "/payplan/req/onSelect_payplan_filtre.php",
            type: "POST",
            data: { type_achat: $(this).val() },
            success: function (data) {
                $("#table_payplan").html(data);
                $("#select_destination_payplan").val(0);
            }
        });
    });

    // au select de date
    $("#select_date_payplan").change(function (e) {
        date_select = this.value;
        tableau_selected = $("#tableau_selected").text();
        console.log(date_select);
        console.log(tableau_selected);

        switch (date_select) {
            //afficher tout 
            case '0':
                $("#date_personnalisees_div").fadeOut(200);
                $("#date_payplan_debut").val("");
                $("#date_payplan_fin").val("");
                if (tableau_selected == "commission") {
                    $.ajax({
                        url: "/payplan/req/req_tableau_payplan.php",
                        data: {},
                        success: function (data) {
                            $("#table_payplan").html(data);
                        }
                    });
                } else if (tableau_selected == "collaborateur") {
                    $.ajax({
                        url: "/payplan/req/onSelect_payplan_collaborateur_filtre.php",
                        type: "POST",
                        data: { selected_date: date_select },
                        success: function (data) {
                            $("#table_payplan_achat_reprise").html(data);
                        }
                    });
                }
                break;
            //si on choisit mois précédent
            case '1':
                $("#date_personnalisees_div").fadeOut(200);
                $("#date_payplan_debut").val("");
                $("#date_payplan_fin").val("");
                if (tableau_selected == "commission") {
                    $.ajax({
                        url: "/payplan/req/onSelect_payplan_filtre.php",
                        type: "POST",
                        data: { selected_date: date_select },
                        success: function (data) {
                            $("#table_payplan").html(data);
                            $("#select_destination_payplan").val(0);
                            $("#select_type_achat_payplan").val(0);
                        }
                    });
                } else if (tableau_selected == "collaborateur") {
                    $.ajax({
                        url: "/payplan/req/onSelect_payplan_collaborateur_filtre.php",
                        type: "POST",
                        data: { selected_date: date_select },
                        success: function (data) {
                            $("#table_payplan_achat_reprise").html(data);
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

        console.log(tableau_selected);

        // value_dates_perso = Array(date_debut,date_fin);

        let value_dates_perso = {};
        value_dates_perso['debut'] = date_debut;
        value_dates_perso['fin'] = date_fin;

        console.log(value_dates_perso);

        if (tableau_selected == "commission") {
            $.ajax({
                url: "/payplan/req/onSelect_payplan_filtre.php",
                type: "POST",
                data: { date_debut: date_debut, date_fin: date_fin },
                success: function (data) {
                    $("#table_payplan").html(data);
                    $("#select_destination_payplan").val(0);
                    $("#select_type_achat_payplan").val(0);
                }
            });
            // si tableau collaborateur
        } else if (tableau_selected == "collaborateur") {
            $.ajax({
                url: "/payplan/req/onSelect_payplan_collaborateur_filtre.php",
                type: "POST",
                data: { selected_date: date_select, date_perso: value_dates_perso },
                success: function (data) {
                    $("#table_payplan_achat_reprise").html();
                    $("#table_payplan_achat_reprise").html(data);
                }
            });
        }

    });



    // au select du tableau achat/reprise collaborateur
    $("#bouton_tableau_reprise_achat_collaborateur").click(function (e) {
        $("#table_payplan").fadeOut(0);
        $("#bouton_tableau_reprise_achat_collaborateur").blur();
        $("#bouton_tableau_reprise_achat_collaborateur").addClass("button_selected_tableau_reprise_achat");
        $("#bouton_tableau_payplan").removeClass("button_selected_tableau_payplan");
        $("#bouton_tableau_commision").removeClass("button_selected_tableau_comission");

        //mise a 0 des filtres ou disparition
        $("#div_form_destination").fadeOut(300);
        $("#div_form_type_achat").fadeOut(300);
        $("#collaborateur_div").fadeIn(300);
        $("#tableau_selected").text("collaborateur");
        $("#select_site_payplan").val(0);
        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                // var parsed = JSON.parse(data);
                $("#table_payplan_achat_reprise").html(data);
                $("#table_payplan_achat_reprise").fadeIn(300);
            }
        });
    });

    // au select du tableau payplan
    $("#bouton_tableau_payplan").click(function (e) {
        $("#table_payplan").fadeOut(100);
        $("#table_payplan_achat_reprise").fadeOut(100);
        $("#bouton_tableau_payplan").blur();
        $("#bouton_tableau_payplan").addClass("button_selected_tableau_payplan");
        $("#bouton_tableau_reprise_achat_collaborateur").removeClass("button_selected_tableau_reprise_achat");
        $("#bouton_tableau_commision").removeClass("button_selected_tableau_comission");

        //mise a 0 des filtres ou disparition
        $("#div_form_destination").fadeOut(300);
        $("#div_form_type_achat").fadeOut(300);
        $("#collaborateur_div").fadeIn(300);
        $("#tableau_selected").text("payplan");
        $("#select_site_payplan").val(0);
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

    // au select du tableau comission total
    $("#bouton_tableau_commision").click(function (e) {
        $("#table_payplan_achat_reprise").fadeOut(0);
        $("#table_collaborateurs_reprise").fadeOut(200);
        $("#table_collaborateurs_achat").fadeOut(200);
        $("#bouton_tableau_commision").blur();
        $("#bouton_tableau_commision").addClass("button_selected_tableau_comission");
        $("#bouton_tableau_payplan").removeClass("button_selected_tableau_payplan");
        $("#bouton_tableau_reprise_achat_collaborateur").removeClass("button_selected_tableau_reprise_achat");
       
        //mise a 0 des filtres ou disparition
        $("#collaborateur_div").fadeOut(300);
        $("#div_form_destination").fadeIn(300);
        $("#div_form_type_achat").fadeIn(300);
        $("#select_site_payplan").val(0);
        $("#tableau_selected").text("commission");

        $.ajax({
            url: "/payplan/req/onClick_choix_tableau.php",
            type: "POST",
            data: { choix_tableau_payplan: $(this).val() },
            success: function (data) {
                // var parsed = JSON.parse(data);
                // $("#table_payplan").html(parsed["table_commission_total"]);
                $("#table_payplan").html(data);
                $("#table_payplan").fadeIn(300);
            }
        });
    });

    // update tableau payplan
    $("#bouton_update_payplan").click(function (e) {
        $("#table_payplan").fadeOut(0);
        $.ajax({
            url: "/payplan/req/update_payplan.php",
            data: {},
            success: function (data) {
                $("#table_payplan").html(data);
                $("#table_payplan").fadeIn(300);
            }
        });
    });




});
