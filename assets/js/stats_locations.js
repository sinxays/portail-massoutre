$(document).ready(function () {


    // menu 
    $("*.active").removeClass("active");
    $("#bouton_statistiques").addClass("active");
    $("#bouton_stats_loc").addClass("active");

    // les loaders
    let loader = $(".lds-ellipsis");
    let loader_vider = $("#loader_vider_base_import");
    let loader_vider_vp_vu_cumul = $("#loader_vider_base_vp_vu_cumul");
    let loader_alimenter = $("#loader_alimenter_base");

    //bouton import
    let button_import_csv = $("#submit");

    // ce qu'on cache au chargement de la page
    $("#bloc_date_import_csv").hide();
    button_import_csv.hide();
    loader.hide();

    //griser le bouton d'alimentation tant que la date n'est pas rentrée
    $("#bouton_alimenter_tableau").prop("disabled", true);

    //date d'hier par défaut
    var yesterday = new Date(Date.now() - 86400000); // that is: 24 * 60 * 60 * 1000
    // var yesterday = new Date(Date.now() - 172800000); // that is: 48 * 60 * 60 * 1000
    var dd = String(yesterday.getDate()).padStart(2, '0');
    var mm = String(yesterday.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = yesterday.getFullYear();
    yesterday = yyyy + '-' + mm + '-' + dd;
    $("#date_locations_stats").val(yesterday);

    $date_start = $("#date_locations_stats").val();



    // load le tableau des stats 
    $.ajax({
        url: "/pages_stats/req/req_tableau_stats.php",
        type: "POST",
        data: { date_start: $date_start },
        success: function (data) {
            var parsed = JSON.parse(data);
            $("#table_stats_locations").html(parsed["tableau"]);
            $("#requete").text(parsed["requete"]);
            // $("#requete").hide();

        }
    });

    // load le select secteur
    $.ajax({
        url: "/pages_stats/req/req_secteurs.php",
        data: {},
        success: function (data) {
            $("#afficherSecteurs_select").html(data);
        }
    });

    // load le select district
    $.ajax({
        url: "/pages_stats/req/req_district.php",
        data: {},
        success: function (data) {
            $("#afficherDistrict_select").html(data);
        }
    });


    // au select du type
    $("#afficherType_select").change(function (e) {
        $agence = $("#afficher_agence").val();
        $secteur = $("#afficherSecteurs_select").val();
        $district = $('#afficherDistrict_select').val();
        $date = $('#date_locations_stats').val();
        $.ajax({
            url: "/pages_stats/req/onSelect_type.php",
            type: "POST",
            data: { type: $(this).val(), agence: $agence, secteur: $secteur, district: $district, date: $date },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_locations").html(parsed["tableau"]);
                $("#requete").text(parsed["requete"]);
                $("#requete").hide();
                $("#afficherResultats_select").val("tous");
            }
        });
    });


    // au select de l'agence
    $("#afficher_agence").change(function (e) {
        $type = $("#afficherType_select").val();
        $("#afficherSecteurs_select").val(0);
        $("#afficherDistrict_select").val(0);
        $date = $('#date_locations_stats').val();
        $.ajax({
            url: "/pages_stats/req/onSelect_agence.php",
            type: "POST",
            data: { id_agence: $(this).val(), type: $type, date: $date },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_locations").html(parsed["tableau"]);
                $("#requete").text(parsed["requete"]);
                $("#requete").hide();
            }
        });
    });


    // au select du secteur
    $("#afficherSecteurs_select").change(function (e) {
        $type = $("#afficherType_select").val();
        $("#afficherDistrict_select").val(0);
        $("#afficher_agence").val(0);
        $date = $('#date_locations_stats').val();

        $.ajax({
            url: "/pages_stats/req/onSelect_secteur.php",
            type: "POST",
            data: { id_secteur: $(this).val(), type: $type, date: $date },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_locations").html(parsed["tableau"]);
                $("#requete").text(parsed["requete"]);
                $("#requete").hide();
                // $("#afficherResultats_select").val("tous");
            }
        });
    });


    // au select du district
    $("#afficherDistrict_select").change(function (e) {
        $type = $("#afficherType_select").val();
        $("#afficher_agence").val(0);
        $("#afficherSecteurs_select").val(0);
        $date = $('#date_locations_stats').val();

        $.ajax({
            url: "/pages_stats/req/onSelect_district.php",
            type: "POST",
            data: { id_district: $(this).val(), type: $type, date: $date },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_locations").html(parsed["tableau"]);
                $("#requete").text(parsed["requete"]);
                $("#requete").hide();
            }
        });
    });

    //au select de la date 
    $("#date_locations_stats").change(function (e) {
        $requete = $("#requete").text();

        $.ajax({
            url: "/pages_stats/req/onSelect_date.php",
            type: "POST",
            data: { date: $(this).val(), requete: $requete },
            success: function (data) {
                var parsed = JSON.parse(data);
                $("#table_stats_locations").html(parsed["tableau"]);
                $("#requete").text(parsed["requete"]);
                $("#requete").hide();
            }
        });
    });


    // bouton pour vider la table d'import
    $("#bouton_vider_table").click(function (e) {
        e.preventDefault();
        loader_vider.show();
        $.ajax({
            url: "/pages_stats/vider_table_stats_journalieres.php",
            success: function () {
                alert("table vidée avec succès");
                loader_vider.hide();
            },
            error: function () {
                alert("table non vidée");
            }
        });

    })

    // bouton pour vider la table VP,VU,CUMUL
    $("#bouton_vider_table_vp_vu_cumul").click(function (e) {
        e.preventDefault();
        loader_vider_vp_vu_cumul.show();
        $.ajax({
            url: "/pages_stats/req/vider_vp_vu_cumul.php",
            success: function () {
                alert("tables VP VU et CUMUL vidées avec succès");
                loader_vider_vp_vu_cumul.hide();
            },
            error: function () {
                alert("table non vidée");
            }
        });

    })


    //alimenter les bases
    $("#bouton_alimenter_tableau").click(function (e) {
        e.preventDefault();
        loader_alimenter.show();
        $date = $("#date_import_stats").val();
        $.ajax({
            url: "/pages_stats/alimenter_tableau_stats_journalieres.php",
            type: "POST",
            data: { date: $date },
            success: function (data) {
                alert(data);
                window.location.replace("/pages_stats/locations.php");
            }
        });

    })


    /**TESST FADE **/
    $("#button_fade_in").click(function (e) {
        e.preventDefault();
        $("#requete").fadeIn(500);
    })

    $("#button_fade_out").click(function (e) {
        e.preventDefault();
        $("#requete").fadeOut(500);
    })

    $("#button_fade_toggle").click(function (e) {
        e.preventDefault();
        $("#requete").fadeToggle(500);
    })


    //UPLOAD du fichier CSV
    $("#upload_csv_form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#loader_import_csv").show();

        $.ajax({
            url: "/pages_stats/import_csv.php",
            type: 'POST',
            data: formData,
            success: function (retour) {
                alert(retour);
                window.location.replace("/pages_stats/locations.php");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    //apres la selection d'un fichier csv faire apparaitre le bouton import
    $('input[name=csv_file]').change(function (e) {
        $("#bloc_date_import_csv").fadeIn(500);

    })

    //une fois la date rentrée, faire apparaitree le bouton import ou non si date pas valide
    $("#date_import_stats").change(function (e) {
        $date_value = this.value;
        if ($date_value !== '') {
            button_import_csv.fadeIn(500);
        }
        else {
            button_import_csv.fadeOut(500);
        }
    })





});
