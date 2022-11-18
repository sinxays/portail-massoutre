$(document).ready(function () {

    // load le tableau reseau
    $.ajax({
        url: "/Informatique/req/req_tableau_informatique.php",
        type: "POST",
        data: { type: "reseau" },
        success: function (data) {
            $("#table_reseau_informatique").html(data);
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



    // au select de l'infrastructure
    $("#afficher_reseau_agence").change(function (e) {
        $.ajax({
            url: "/Informatique/req/onSelect_reseau.php",
            type: "POST",
            data: { id_infrastructure: $(this).val() },
            success: function (data) {
                $("#table_reseau_informatique").html(data);
                // var parsed = JSON.parse(data);
                // $("#requete").text(parsed["requete"]);
                // $("#requete").hide();
            }
        });
    });

    // recherche d'une agence
    $("#input_search_infra_reseau").keyup(function (e) {
        let tmp_search_infra_reseau = $(this).val();
        $.ajax({
            url: "/Informatique/req/onSearch_infrastructure.php",
            type: "POST",
            data: { infrastructure: tmp_search_infra_reseau },
            success: function (data) {
                $("#table_reseau_informatique").html(data);
            }
        });
    });
});



