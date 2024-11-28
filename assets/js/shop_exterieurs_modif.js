$(document).ready(function () {

    $("#div_retour_detail_collaborateur").click(function (e) {
        window.location.replace("/operations/shop_exterieurs/shop_exterieurs.php");
    });

    // APPUI SUR LE BOUTON AJOUTER/MODIFIER UNE ACTION
    $("#button_ajouter_modifier_action").click(function (e) {
        e.preventDefault();
        console.log($("#form_ajout_action").serialize());
        $.ajax({
            url: "../../operations/shop_exterieurs/req/req_ajouter_action.php",
            type: "POST",
            data: $("#form_ajout_action").serialize(),
            success: function () {
                location.reload();
            },
            error: function () {
                $("#alert_action_added_fail").show(300);
            }
        });
    });



    $("#btn_sortir_vh_shop_ext").click(function (e) {
        e.preventDefault();
        console.log($("#form_shop_ext").serialize());

        $.ajax({
            url: "../../operations/shop_exterieurs/req/req_archiver_shop_ext.php",
            type: "POST",
            data: $("#form_shop_ext").serialize(),
            success: function () {
                window.location.replace("/operations/shop_exterieurs/shop_exterieurs.php");
                $("#alert_shop_ext_modif_success").show(300);
            },
            error: function () {
                $("#alert_shop_ext_modif_fail").show(300);
            }
        });
    });


    $("#btn_modif_enregistrer").click(function (e) {
        e.preventDefault();
        console.log($("#form_shop_ext").serialize());
        $.ajax({
            url: "../../operations/shop_exterieurs/req/req_modif_shop_ext.php",
            type: "POST",
            data: $("#form_shop_ext").serialize(),
            success: function () {
                window.location.replace("/operations/shop_exterieurs/shop_exterieurs.php");
                $("#alert_shop_ext_modif_success").show(300);
            },
            error: function () {
                $("#alert_shop_ext_modif_fail").show(300);
            }
        });
    });

    $('#modal_ajout_modif_action').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // element qui ouvre le modal ici c'est le <a>
        var action_id = button.data('actionid');
        var typemodal = button.data('typemodal');
        var modal = $(this);


        //ajouter,modifier ou delete
        switch (typemodal) {
            case 'ajouter':
                mise_en_forme_modal("ajouter");
                modal.find('#title_ajout_modif_action').text('Ajouter une action');
                modal.find('#button_ajouter_modifier_action').text('Ajouter');
                break;
            case 'modifier':
                mise_en_forme_modal("modifier");
                $.ajax({
                    url: "../../operations/shop_exterieurs/req/req_get_info_action.php",
                    type: "POST",
                    data: { action_id: action_id },
                    success: function (data) {
                        var result = JSON.parse(data);
                        // console.log(result);
                        modal.find('#dateInput').val(result.date_action);
                        modal.find('#action_effectuee').val(result.action);
                        modal.find('#remarque').val(result.remarque);
                        modal.find('#is_action_factured').val(result.is_factured);
                        modal.find('#montant_action').val(result.montant_facture);
                        modal.find('#action_id_to_modif').val(result.ID);
                    },
                    error: function () {
                    }
                });
                break;
            case 'delete':
                console.log(action_id);
                mise_en_forme_modal("delete", action_id);
                break;
        }
    })

    $('#modal_ajout_modif_action').on('hide.bs.modal', function (event) {
        clear_elements_action();
    })

});

function clear_elements_action() {
    var modal = $("#modal_ajout_modif_action");
    modal.find('#dateInput').val('');
    modal.find('#action_effectuee').val('');
    modal.find('#remarque').val('');
    modal.find('#is_action_factured').val('');
    modal.find('#montant_action').val('');
    modal.find('#action_id_to_modif').val('');

    $("#button_delete_action").remove();
    $("#span_action_to_delete").remove();

}

function mise_en_forme_modal(type, action_id = '') {

    let modal = $('#modal_ajout_modif_action');

    switch (type) {
        case "ajouter":
            modal.find('#my_modal_header_ajout_action').css('background', '#31a6ff');
            modal.find('#form_ajout_action').show();
            break;

        case 'modifier':
            modal.find('#my_modal_header_ajout_action').css('background', '#31a6ff');
            modal.find('#form_ajout_action').show();
            modal.find('#title_ajout_modif_action').text('Modifier une action');
            modal.find('#button_ajouter_modifier_action').show();
            modal.find('#button_ajouter_modifier_action').text('Modifier');
            modal.find('#button_annuler').show();
            modal.find('#button_annuler').text('Annuler');
            break;

        case 'delete':
            //mise en forme du modal
            modal.find('#title_ajout_modif_action').text('Supprimer Action');
            modal.find('#my_modal_header_ajout_action').css('background', '#ff3151');
            modal.find('#form_ajout_action').hide();

            //creation du span et ajout de celui ci dans le modal body
            let span_action_to_delete = document.createElement("span");
            span_action_to_delete.id = "span_action_to_delete";
            span_action_to_delete.textContent = "Voulez vous vraiment supprimer cette action ?";
            let body_modal = document.querySelector(".modal_ajout_modif_action_body");
            body_modal.appendChild(span_action_to_delete);


            // Changement du footer
            let button_valider_delete = document.createElement("button");
            button_valider_delete.className = "btn btn-primary";
            button_valider_delete.id = "button_delete_action";
            button_valider_delete.textContent = "Oui";
            modal.find('#button_annuler').text('Non');
            modal.find('#button_ajouter_modifier_action').hide();

            let button_annuler = document.getElementById("button_annuler");
            button_annuler.insertAdjacentElement("afterend", button_valider_delete);

            // Ajouter un écouteur d'événement 'click' en utilisant jQuery
            $("#button_delete_action").click(function (e) {
                e.preventDefault();
                let vh_id = $("#vehicule_id").val();
                // console.log("vehicule id est " + vh_id)
                // console.log("action id est : " + action_id);
                $.ajax({
                    url: "../../operations/shop_exterieurs/req/req_delete_action.php",
                    type: "POST",
                    data: { id_action: action_id },
                    success: function () {
                        window.location.replace("/operations/shop_exterieurs/modif_shop_exterieur.php?id=" + vh_id);
                        $("#alert_shop_ext_modif_success").show(300);
                    },
                    error: function () {
                        $("#alert_shop_ext_modif_fail").show(300);
                    }
                });
            });
            break;
    }

}

