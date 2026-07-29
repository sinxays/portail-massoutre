$(document).ready(function () {

    let loader = $('#loader');
    loader.show();

    const sauvegarde = sessionStorage.getItem("filtresVehicules");

    if (sauvegarde) {
        const filtres = JSON.parse(sauvegarde);

        $("#immatriculation_input").val(filtres.filtre_immat_save);
        $("#client_input").val(filtres.filtre_client_save);
        $("#select_id_code_alerte").val(filtres.filtre_id_type_alerte_save);
        console.log(sauvegarde);

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: { input_immat: filtres.filtre_immat_save, input_client: filtres.filtre_client_save, id_code_alerte: filtres.filtre_id_type_alerte_save },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });
    }

    else {

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: {},
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });
    }




    $("#div_retour_detail_collaborateur").click(function (e) {
        // history.back();
        window.location.href = "/operations/suivi_lag/suivi_lag.php";
    });


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $("#immatriculation_input").keyup(function (e) {
        let input_immat = $(this).val();
        let input_archive = $("#select_archive").val();
        $("#client_input").val('');
        $("#select_id_code_alerte").val(0);
        loader.show();

        const filtres = {
            filtre_immat_save: $(this).val()
        };
        sessionStorage.setItem("filtresVehicules", JSON.stringify(filtres));

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: { input_immat: input_immat, archive: input_archive },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });


    $("#client_input").keyup(function (e) {
        let input_client = $(this).val();
        let input_archive = $("#select_archive").val();
        let selected_id_code_alerte = $("#select_id_code_alerte").val();
        $("#immatriculation_input").val('');
        // $("#select_id_code_alerte").val(0);
        loader.show();

        const filtres = {
            filtre_client_save: $(this).val(),
            filtre_id_type_alerte_save: $("#select_id_code_alerte").val()
        };
        sessionStorage.setItem("filtresVehicules", JSON.stringify(filtres));

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: { input_client: input_client, id_code_alerte: selected_id_code_alerte, archive: input_archive },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });
    $("#select_id_code_alerte").change(function (e) {
        let selected_id_code_alerte = $(this).val();
        let input_archive = $("#select_archive").val();
        let input_client = $("#client_input").val();

        $("#immatriculation_input").val('');
        // $("#client_input").val('');

        loader.show();

        const filtres = {
            filtre_id_type_alerte_save: $(this).val(),
            filtre_client_save: $("#client_input").val(),
        };
        sessionStorage.setItem("filtresVehicules", JSON.stringify(filtres));

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: { id_code_alerte: selected_id_code_alerte, input_client: input_client, archive: input_archive },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });


    $("#select_archive").change(function (e) {
        let selected_deleted = $(this).val();
        console.log(selected_deleted);
        loader.show();

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: { deleted: selected_deleted },
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });

    });

    // Import fichier excel
    $("#button_import_fichier_suivi_lag").click(function (e) {
        e.preventDefault();
        $("#modal_import").modal('hide');
        loader.show();

        let formData = new FormData();

        // Ajout du fichier
        let fichier = $("#formFile")[0].files[0];

        if (!fichier) {
            alert("Veuillez sélectionner un fichier");
            loader.hide();
            return;
        }

        formData.append("fichier", fichier);

        // Ajout du select
        formData.append("type_fichier", $("#select_source_fichier").val());

        console.lo

        $.ajax({
            url: "/operations/suivi_lag/req/req_import_fichier_suivi_lag.php",
            type: "POST",
            data: formData,
            processData: false, // obligatoire avec FormData
            contentType: false, // obligatoire avec FormData

            success: function (data) {
                alert('fichier importé avec succès')
                window.location.replace('/operations/suivi_lag/suivi_lag.php');
            },

            error: function (error_details) {
                alert("Erreur lors du traitement du fichier ==> Veuillez importer un fichier XLSX");
                loader.hide();

            }
        });

    });

    // Import fichier excel
    $("#refresh_filters").click(function (e) {
        e.preventDefault();
        $("#immatriculation_input").val('');
        $("#client_input").val('');
        $("#select_id_code_alerte").val('');

        sessionStorage.clear();

        loader.show();

        $.ajax({
            url: "/operations/suivi_lag/req/req_tableau_suivi_lag.php",
            type: "POST",
            data: {},
            success: function (data) {
                $("#table_shop_exterieur").html(data);
                loader.hide();
            }
        });





    });



});


