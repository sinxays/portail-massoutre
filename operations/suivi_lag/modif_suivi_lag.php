<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>


    <!--========== CSS ==========-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/styles.css">


    <!--========== JS ==========-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





    <title>Portail Massoutre - Modif Alerte Suivi LAG</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <?php include "../../header.php";

    // NAV  
    include "../../right_menubar.php";
    include "../../include.php"; ?>




    <!--============================== CONTENTS ==============================-->
    <main>

        <?php

        if (isset($_GET['id']) && $_GET['id'] !== '') {
            $id = $_GET['id'];
            $details_suivi_lag = get_detail_suivi_lag($id);
            $alerte_id = $details_suivi_lag['infos']['alerte_id'];
            // var_dump($details_suivi_lag);
        }
        ?>

         <!-- LOGO LAG -->
        <img src="../../assets/img/LAG_logo.png" alt="" class="header__lag_img">

        <br />
        <br />
        <br />

        <div id="div_retour_detail_collaborateur">
            <i class='bx bx-left-arrow-circle bx-md'></i><span>Retour</span>
        </div>

        <div class="container_form_modif_lecture_shop_ext">
            <form id="form_suivi_lag">

                <div class="container_form_modif_lecture_shop_ext_1">

                    <div class="ajout_shop_categorie">



                        <div class="div_form_vh_label"><span>Vehicule</span></div>
                        <div class="div_contenu_label">
                            <div class="div_form_vh_row">
                                <div class="element_champ">
                                    <label for="input_immat">Immatriculation</label>
                                    <input type="text" class="form-control" id="input_immat"
                                        placeholder="Immatriculation" name="immatriculation" style="width: 200px;"
                                        value="<?php echo $details_suivi_lag['infos']['immatriculation'] ?>" readonly>
                                </div>

                            </div>
                            <div class="div_form_vh_row">
                                <div class="element_champ">
                                    <label for="input_marque_modele">Marque + Modèle</label>
                                    <input readonly type="text" class="form-control" id="input_marque_modele"
                                        placeholder="Marque & modèle" name="marque_modele" style="width: 550px;"
                                        value="<?php echo $details_suivi_lag['infos']['marque'] . " " . $details_suivi_lag['infos']['modele'] ?>">
                                </div>
                            </div>
                            <div class="div_form_vh_row">
                                <div class="element_champ">
                                    <label for="input_km_echoes">Kilomètre Echoes</label>
                                    <input type="text" class="form-control" id="input_km_echoes" placeholder="km echoes"
                                        name="km_echoes" style="width: 200px;"
                                        value="<?php echo $details_suivi_lag['infos']['km_echoes'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ajout_shop_categorie">

                        <div class="div_form_vh_label"><span>Infos Alerte</span></div>
                        <div class="div_contenu_label">
                            <div class="div_form_vh_column">

                                <div class="element_champ_row">

                                    <div class="element_champ">
                                        <label for="input_type">Type d'alerte</label>
                                        <input type="text" class="form-control" id="input_type" style="width: 200px;"
                                            value="<?php echo $details_suivi_lag['infos']['type'] ?>" readonly>
                                    </div>

                                    <div class="element_champ">
                                        <label for="libelle_alerte">Libellé alerte</label>
                                        <input type="text" class="form-control" id="libelle_alerte"
                                            style="width: 350px;"
                                            value="<?php echo $details_suivi_lag['infos']['libelle'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="element_champ_row">

                                    <div class="element_champ">
                                        <label for="input_date_to_entretien">Date (si entretien)</label>
                                        <input type="text" class="form-control" id="input_date_to_entretien"
                                            style="width: 200px;"
                                            value="<?php echo $details_suivi_lag['infos']['date_to_entretien'] ?>"
                                            readonly>
                                    </div>

                                    <div class="element_champ">
                                        <label for="input_km_to_entretien">Km (si entretien)</label>
                                        <input type="text" class="form-control" id="input_km_to_entretien"
                                            style="width: 350px;"
                                            value="<?php echo $details_suivi_lag['infos']['km_to_entretien'] ?>"
                                            readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="container_form_modif_lecture_shop_ext_3">

                    <div class="input-group" style="width: 750px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                style="display:flex;justify-content:center;align-items:center;width: 200px ;height: 60px;background: #8a0710 ; color:white ; font-weight:bold">CLIENT</span>
                        </div>
                        <input type="text" class="form-control" id="client" name="client" style="width:100px;"
                            value="<?php echo $details_suivi_lag['infos']['client'] ?>" readonly>
                    </div>


                </div>

                <!-- Champ caché pour envoyer la valeur du vehicule id -->
                <input type="hidden" name="vehicule_id" <?php echo "value='$id'" ?>>

                <!-- Champ caché pour envoyer la valeur de l'alerte id car les actions sont liées à l'alerte pas au véhicule -->
                <input type="hidden" name="alerte_id" id="alerte_id" <?php echo "value='$alerte_id'" ?>>



                <div class="container_form_modif_lecture_shop_ext_2">
                    <div class="ajout_shop_categorie_action">
                        <div class="div_form_vh_label"><span>Actions</span></div>
                        <div class="div_contenu_label_action">
                            <table class="my_tab_shop_ext_action">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type d'action</th>
                                        <th>detail de l'action</th>
                                        <th>retour d'action ? </th>
                                        <th>Prochaine action à effectuer</th>
                                    </tr>
                                </thead>

                                <?php
                                foreach ($details_suivi_lag['actions'] as $nb_action => $action) {
                                    echo "<tr>";
                                    echo "<td style='width:120px'>" . $action['date_action'] . "</td>";
                                    echo "<td>" . $action['type_action'] . "</td>";
                                    echo "<td>" . $action['commentaire'] . "</td>";
                                    echo "<td>" . $action['action_retour_client'] . "</td>";
                                    echo "<td>" . $action['action_a_effectuer'] . "</td>";

                                    echo "<td class='td_n'style='width:80px'>";

                                    echo "<a title='modifier action' data-bs-toggle='modal' data-bs-target='#modal_ajout_modif_action' data-actionid='" . $action['ID'] . "' data-typemodal='modifier'>
                                    <i class='bx bx-edit bx-sm' style='color:blue;' ></i>
                                    </a>";

                                    echo "<a title='supprimer action' data-bs-toggle='modal' data-bs-target='#modal_ajout_modif_action' data-actionid='" . $action['ID'] . "' data-typemodal='delete' >
                                    <i class='bx bx-trash bx-sm' style='color:red;'></i>
                                    </a>";

                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>

                            </table>
                        </div>

                        <div class="div_ajout_action">
                            <!-- <button type="button" class="btn btn-success" id="btn_ajout_action"
                                style="background: #33B5FF ;" data-toggle="modal"
                                data-target="#modal_ajout_modif_action">Ajouter
                                Action</button> -->
                            <button type="button" class="btn btn-success" id="btn_ajout_action"
                                style="background: #33B5FF ;" data-bs-toggle="modal"
                                data-bs-target="#modal_ajout_modif_action" data-typemodal="ajouter">Ajouter
                                Action</button>
                        </div>
                    </div>
                </div>

                <div class="div_container_flex_row_categories_shop_ext">
                    <div class="btn-group btn-group-lg" role="group" id="my_checkbox_categories">

                        <?php
                        $radio_checked = 'checked';
                        $statut_id = intval($details_suivi_lag['infos']['statut']);
                        ?>

                        <input type="radio" class="btn-check" id="btnradio1" name="statut_alerte" value="1" <?php echo $statut_id == 1 ? $radio_checked : '' ?>>
                        <label class="btn btn-outline-warning" for="btnradio1">En attente devis</label>

                        <input type="radio" class="btn-check" id="btnradio2" name="statut_alerte" value="2" <?php echo $statut_id == 2 ? $radio_checked : '' ?>>
                        <label class="btn btn-outline-dark" for="btnradio2">BDC envoyé</label>

                        <input type="radio" class="btn-check" id="btnradio3" name="statut_alerte" value="3" <?php echo $statut_id == 3 ? $radio_checked : '' ?>>
                        <label class="btn btn-outline-info" for="btnradio3">En attente facture</label>

                        <input type="radio" class="btn-check" id="btnradio4" name="statut_alerte" value="4" <?php echo $statut_id == 4 ? $radio_checked : '' ?>>
                        <label class="btn btn-outline-danger" for="btnradio4">OK</label>

                    </div>
                </div>

            </form>


            <div class="div_validation_modif">
                <button type="button" class="btn btn-success" id="btn_modif_enregistrer">Enregistrer</button>
            </div>

            <div class="lds-ellipsis" id="loader" style="display:none;">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>


            <div class="div_validation_modif">
                <button type="button" class="btn btn-danger" id="btn_sortir_alerte_suivi_lag">Archiver alerte</button>
            </div>


        </div>

        </div>

        </br>

        <!-- Modal ajout Action-->

        <div class="modal fade bd-example-modal-lg" id="modal_ajout_modif_action" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="width: 1000px;">
                    <div class="modal-header" id="my_modal_header_ajout_action">
                        <h5 class="modal-title" id="title_ajout_modif_action">Ajouter Une action</h5>
                    </div>

                    <div class="modal_ajout_modif_action_body">
                        <form id="form_ajout_action">
                            <div class="form-group">
                                <label for="dateInput">Date Action:</label>
                                <input type="date" class="form-control" id="dateInput" name="date_action"
                                    style="width: 200px;">
                            </div>

                            <div class="form-group">
                                <label for="action_type">Type Action</label>
                                <select class="form-select" style="width : 200px;" id="action_type" name="action_type">
                                    <option value="appel" selected> Appel </option>
                                    <option value="email"> Email </option>
                                    <option value="autre"> Autre </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="action_effectuee">Action effectuée</label>
                                <textarea class="form-control" id="action_effectuee" rows="3"
                                    name="action_effectuee"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="action_retour_client">Retour client ? </label>
                                <input type="text" class="form-control" id="action_retour_client"
                                    name="action_retour_client">
                            </div>

                            <div class="form-group">
                                <label for="action_a_effectuer">Action a effectuer ? </label>
                                <input type="text" class="form-control" id="action_a_effectuer_next"
                                    name="action_a_effectuer_next">
                            </div>



                            <!-- Champ caché pour envoyer la valeur de l'alerte id car les actions sont liées à l'alerte pas au véhicule -->
                            <input type="hidden" name="alerte_id" id="alerte_id" <?php echo "value='$alerte_id'" ?>>

                            <!-- Champ caché pour envoyer la valeur id action qu'on va alimenter en value en js si on veut modifier une action -->
                            <input type="hidden" name="action_id" id="action_id_to_modif">
                        </form>
                    </div>


                    <div class="modal-footer" id="modal_footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="button_annuler">Annuler</button>
                        <button type="button" class="btn btn-primary" id="button_ajouter_modifier_action">Ajouter
                            Action</button>
                    </div>


                </div>
            </div>
        </div>

        <!-- FIN MODAL Ajout Action -->


        <div class="alert alert-success" role="alert" id="alert_suivi_lag_modif_success" style="display:none;">
            Modifié
        </div>
        <div class="alert alert-danger" role="alert" id="alert_suivi_lag_modif_fail" style="display:none;">
            Erreur : non modifié
        </div>

        <div class="alert alert-danger" role="alert" id="alert_action_added_fail" style="display:none;">
            Erreur : Action non ajoutée
        </div>


    </main>



    <!--========== MAIN JS ==========-->

    <!-- <script src="/assets/js/jquery-3.6.0.min.js"></script> -->
    <script src="/assets/js/main.js"></script>
    <!-- <script src="/assets/js/shop_exterieurs_modif.js"></script> -->
    <script src="/assets/js/suivi_lag_modif.js"></script>
</body>

</html>