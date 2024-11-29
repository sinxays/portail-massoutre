$(document).ready(function () {


    let loader = $('#loader');
    loader.show();

    $.ajax({
        url: "/operations/traqueurs/req/req_tableau_liste_traqueurs.php",
        success: function (data) {
            $("#table_liste_traqueurs").html(data);
            loader.hide();
        }
    });

    $("#csv_file").change(function (e) {
        $("#btn_submit_csv").prop("disabled", false);
    });

    $("#csvForm").submit(function (e) {
        e.preventDefault();
        $("#btn_submit_csv").prop("disabled", true);

        loader.show();

        // Créer un objet FormData pour inclure le fichier CSV
        var formData = new FormData(this);

        console.log(formData);

        $.ajax({
            url: "/operations/traqueurs/upload_csv_traqueurs.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                loader.hide();
                var parsed = JSON.parse(data);
                $("#table_liste_traqueurs").html(parsed['tableau']);
                $("#response_import_csv").html(parsed['import_state']);
            },
            error: function (xhr, status, error) {
                $("#response_import_csv").text("erreur");
            }
        });

    });



    //filtres
    $("#serial_number_input").keyup(function (e) {
        let sn_input_value = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_liste_traqueurs.php",
            type: "POST",
            data: { input_sn: sn_input_value },
            success: function (data) {
                $("#table_liste_traqueurs").html(data);
                loader.hide();
            }
        });

    });
    $("#imei_input").keyup(function (e) {
        let imei_input_value = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_liste_traqueurs.php",
            type: "POST",
            data: { input_imei: imei_input_value },
            success: function (data) {
                $("#table_liste_traqueurs").html(data);
                loader.hide();
            }
        });

    });
    $("#sim_input").keyup(function (e) {
        let input_sim_value = $(this).val();
        loader.show();

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_liste_traqueurs.php",
            type: "POST",
            data: { input_sim: input_sim_value },
            success: function (data) {
                $("#table_liste_traqueurs").html(data);
                loader.hide();
            }
        });

    });

    $("#select_actif_traqueur").change(function (e) {
        let select_actif_traqueur = $(this).val();
        loader.show();
        console.log(select_actif_traqueur);

        $.ajax({
            url: "/operations/traqueurs/req/req_tableau_liste_traqueurs.php",
            type: "POST",
            data: { select_actif: select_actif_traqueur },
            success: function (data) {
                $("#table_liste_traqueurs").html(data);
                loader.hide();
            }
        });

    });


    $("#button_ajouter_montage_traqueur").click(function (e) {
        e.preventDefault();

        console.log($("#form_ajout_montage_traqueur").serialize());
        $.ajax({
            url: "../../operations/traqueurs/req/req_ajouter_montage_traqueur.php",
            type: "POST",
            data: $("#form_ajout_montage_traqueur").serialize(),
            success: function () {
                window.location.replace("/operations/traqueurs/traqueurs.php");
            },
            error: function () {
            }
        });
    });


    // click sur le bouton enregistrer un montage traqueur
    $("#btn_modif_montage_traqueur").click(function (e) {
        e.preventDefault();
        console.log($("#form_montage_traqueurs").serialize());
        $.ajax({
            url: "../../operations/traqueurs/req/req_modif_ajout_montage_traqueurs.php",
            type: "POST",
            data: $("#form_shop_ext").serialize(),
            success: function () {
                window.location.replace("/operations/traqueurs/traqueurs.php");
                $("#alert_shop_ext_modif_success").show(300);
            },
            error: function () {
                $("#alert_shop_ext_modif_fail").show(300);
            }
        });
    });



    $("#div_retour_liste_traqueurs").click(function (e) {
        window.location.replace("/operations/traqueurs/traqueurs.php");
    });

});


