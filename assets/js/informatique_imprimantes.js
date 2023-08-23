$(document).ready(function () {

    const loader_ajout_imprimante = $("#loader_ajout_imprimante");
    const input_num_serie = $("#num_serie");
    const input_agence = $("#agence");
    const input_emplacement = $("#emplacement");
    const input_prestataire = $("#prestataire");
    const input_marque = $("#marque");
    const input_modele = $("#modele");
    const input_ip_vpn = $("#ip_vpn");
    const input_ip_locale = $("#ip_locale");
    const alert_imprimante_ajoutee_var = $("#alert_imprimante_ajoutee");
    $("#loader_import_csv_imprimantes").hide();


    loader_ajout_imprimante.hide();


    // load le tableau des agences 
    $.ajax({
        url: "/Informatique/req/req_tableau_informatique.php",
        type: "POST",
        data: { type: "imprimantes" },
        success: function (data) {
            var parsed = JSON.parse(data);
            // $("#table_imprimantes_infos").html(data);
            $("#table_imprimantes_infos").html(parsed["table"]);
            $("#requete").text(parsed["nb_rows"]);
        }
    });

    $("#close_toast").click(function (e) {
        toast_imprimante_ajoutee.hide();
    })

    // bouton pour pour ajouter une imprimante
    $("#btn_ajout_imprimante").click(function (e) {
        e.preventDefault();
        loader_ajout_imprimante.show();
        $.ajax({
            url: "/Informatique/req/req_ajouter_imprimante.php",
            type: "POST",
            data: $("#ajout_imprimante_form").serialize(),
            success: function () {
                // alert("imprimante ajoutée");
                loader_ajout_imprimante.hide();
                input_num_serie.val('');
                input_agence.val('');
                input_emplacement.val('');
                input_marque.val('');
                input_prestataire.val('');
                input_modele.val('');
                input_ip_vpn.val('');
                input_ip_locale.val('');

                alert_imprimante_ajoutee_var.show(300);

            },
            error: function () {
                alert("imprimante non ajoutée");
            }
        });

    })

    $("#btn_modif_imprimante").click(function (e) {
        e.preventDefault();
        loader_ajout_imprimante.show();
        $.ajax({
            url: "/Informatique/req/req_modifier_imprimante.php",
            type: "POST",
            data: $("#ajout_imprimante_form").serialize(),
            success: function () {
                // alert("imprimante ajoutée");
                loader_ajout_imprimante.hide();
                input_num_serie.val('');
                input_agence.val('');
                input_emplacement.val('');
                input_marque.val('');
                input_prestataire.val('');
                input_modele.val('');
                input_ip_vpn.val('');
                input_ip_locale.val('');

                alert_imprimante_ajoutee_var.show(300);

                window.location.replace("/Informatique/imprimantes.php");


            },
            error: function () {
                alert("imprimante non ajoutée");
            }
        });




    })




    $("#alert_imprimante_ajoutee").click(function (e) {
        e.preventDefault();
        alert_imprimante_ajoutee_var.fadeOut(300);
    })

    //UPLOAD du fichier CSV
    $("#upload_csv_form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#loader_import_csv_imprimantes").show();

        $.ajax({
            url: "/Informatique/req/import_csv_imprimante.php",
            type: 'POST',
            data: formData,
            success: function (retour) {
                alert(retour);
                window.location.replace("/Informatique/ajout_imprimante.php");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    // au type du numéro de série
    $("#input_num_serie").keyup(function (e) {
        $.ajax({
            url: "/Informatique/req/onSelect_imprimantes.php",
            type: "POST",
            data: { num_serie: $(this).val(), type: 'num_serie' },
            success: function (data) {
                var parsed = JSON.parse(data);
                // $("#table_imprimantes_infos").html(data);
                $("#table_imprimantes_infos").html(parsed["table"]);
                $("#requete").text(parsed["nb_rows"]);
                // $("#requete").hide();

                // $("#input_num_serie").val("");
            }
        });
    });


    // au select de l'infrastructure
    $("#afficher_print_infrastructure").change(function (e) {
        $.ajax({
            url: "/Informatique/req/onSelect_imprimantes.php",
            type: "POST",
            data: { id_infrastructure: $(this).val(), type: 'infrastructure' },
            success: function (data) {
                var parsed = JSON.parse(data);
                // $("#table_imprimantes_infos").html(data);
                $("#table_imprimantes_infos").html(parsed["table"]);
                $("#requete").text(parsed["nb_rows"]);
                // $("#requete").hide();
                $("#input_num_serie").val("");

            }
        });
    });

    // au select du prestataire
    $("#select_pretataire").change(function (e) {
        $.ajax({
            url: "/Informatique/req/onSelect_imprimantes.php",
            type: "POST",
            data: { prestataire: $(this).val(), type: 'prestataire' },
            success: function (data) {
                // $("#table_imprimantes_infos").html(data);
                var parsed = JSON.parse(data);
                $("#table_imprimantes_infos").html(parsed["table"]);
                $("#requete").text(parsed["nb_rows"]);
                // $("#requete").hide();
                $("#input_num_serie").val("");

            }
        });
    });










});


function modifier_imprimante(id) {
    console.log(id);
    document.location.href = "modif_imprimante.php?id=" + id;
}



