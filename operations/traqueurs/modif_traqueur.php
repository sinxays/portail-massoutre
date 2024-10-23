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





    <title>Portail Massoutre - Modif TRAQUEUR</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <img src="../../assets/img/perfil.jpg" alt="" class="header__img">

            <a href="#" class="header__logo"> </a>

            <div class="header__search">
                <input type="search" placeholder="Search" class="header__input">
                <i class='bx bx-search header__icon'></i>
            </div>

            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
        </div>
    </header>

    <!--========== NAV ==========-->
    <?php include "../../right_menubar.php";
    include "../../include.php"; ?>




    <!--============================== CONTENTS ==============================-->
    <main>

        <?php

        if (isset($_GET['id']) && $_GET['id'] !== '') {
            $id = $_GET['id'];
            $details_traqueur = get_details_traqueur($id);
            // var_dump($details_traqueur);
        }
        ?>

        <H2> MODIFIER TRAQUEUR </H2>

        <br />

        <div id="div_retour_detail_collaborateur">
            <i class='bx bx-left-arrow-circle bx-md'></i><span>Retour</span>
        </div>

        <div class="container_form_modif_lecture_shop_ext">
            <form id="form_shop_ext">

                <div class="container_form_modif_lecture_shop_ext_1">

                    <div class="ajout_shop_categorie">

                        <div class="div_form_vh_label"><span>Traqueur</span></div>
                        <div class="div_contenu_label">
                            <div class="div_form_vh_row">
                                <div class="element_champ">
                                    <label for="serial_number_input">Numéro de série</label>
                                    <input type="text" class="form-control" id="serial_number_input" placeholder="S/N"
                                        name="serial_number" style="width: 200px;"
                                        value="<?php echo $details_traqueur['serial_number'] ?>">
                                </div>
                                <div class="element_champ">
                                    <label for="imei_input">IMEI</label>
                                    <input type="text" class="form-control" id="imei_input" name="imei"
                                        style="width: 150px;" value="<?php echo $details_traqueur['imei'] ?>">
                                </div>
                                <div class="element_champ">
                                    <label for="sim_input">SIM</label>
                                    <input type="text" class="form-control" id="sim_input" name="sim"
                                        style="width: 150px;" value="<?php echo $details_traqueur['sim'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ajout_shop_categorie">

                        <div class="div_form_vh_label"><span>Véhicule</span></div>
                        <div class="div_contenu_label">
                            <div class="div_form_vh_column">

                                <div class="element_champ_row">
                                    <div class="element_champ">
                                        <label for="immat_input">Immatriculation</label>
                                        <input type="text" class="form-control" id="immat_input" name="immatriculation"
                                            style="width: 150px;"
                                            value="<?php echo $details_traqueur['immatriculation'] ?>">
                                    </div>

                                    <div class="element_champ">
                                        <label for="mva_input">MVA</label>
                                        <input type="text" class="form-control" id="mva_input" name="mva"
                                            style="width: 150px;" value="<?php echo $details_traqueur['mva'] ?>">
                                    </div>
                                </div>


                                <div class="element_champ_row">



                                    <div class="element_champ">
                                        <label for="type_input">Type</label>
                                        <input type="text" class="form-control" id="type_input" name="type"
                                            style="width: 150px;" value="<?php echo $details_traqueur['type'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ajout_shop_categorie">

                    <div class="div_form_vh_label"><span>Montage</span></div>
                    <div class="div_contenu_label">
                        <div class="div_form_vh_column">

                            <div class="element_champ_row">

                                <div class="form-group">
                                    <label for="date_installation_input">Date d'installation</label>
                                    <input type="date" class="form-control" id="date_installation_input"
                                        name="date_installation" style="width: 200px;"
                                        value="<?php echo $details_traqueur['date_installation'] ?>">
                                </div>

                               
                                <div class="form-group">
                                    <label for="date_maj_site_input">Date MAJ site</label>
                                    <input type="date" class="form-control" id="date_maj_site_input"
                                        name="date_maj_site" style="width: 200px;"
                                        value="<?php echo $details_traqueur['date_maj_site'] ?>">
                                </div>
                            </div>


                            <div class="element_champ_row">



                                <div class="element_champ">
                                    <label for="type_input">Type</label>
                                    <input type="text" class="form-control" id="type_input" name="type"
                                        style="width: 150px;" value="<?php echo $details_traqueur['type'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Champ caché pour envoyer la valeur du vehicule id -->
        <input type="hidden" name="vehicule_id" <?php echo "value='$id'" ?>>



        <div class="container_form_modif_lecture_shop_ext_2">
            <div class="ajout_shop_categorie_action">
                <div class="div_form_vh_label"><span>Actions</span></div>
                <div class="div_contenu_label_action">
                    <table class="my_tab_shop_ext_action">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action Effectuée</th>
                                <th>Remarque</th>
                                <th>Facturé ?</th>
                                <th>Montant</th>
                            </tr>
                        </thead>

                        <?php
                        foreach ($details_traqueur['actions'] as $nb_action => $action) {
                            echo "<tr>";
                            echo "<td style='width:120px'>" . $action['date_action'] . "</td>";
                            echo "<td>" . $action['action'] . "</td>";
                            echo "<td>" . $action['remarque'] . "</td>";
                            echo "<td>" . ($action['is_factured'] == '1' ? 'oui' : 'non') . "</td>";
                            echo "<td>" . $action['montant_facture'] . " € </td>";

                            echo "<td class='td_n'style='width:80px'>";

                            echo "<a title='modifier action' data-bs-toggle='modal' data-bs-target='#modal_ajout_modif_action' data-actionid='" . $action['id'] . "' data-typemodal='modifier'>
                                    <i class='bx bx-edit bx-sm' style='color:blue;' ></i>
                                    </a>";

                            echo "<a title='supprimer action' data-bs-toggle='modal' data-bs-target='#modal_ajout_modif_action' data-actionid='" . $action['id'] . "' data-typemodal='delete' >
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
                    <button type="button" class="btn btn-success" id="btn_ajout_action" style="background: #33B5FF ;"
                        data-bs-toggle="modal" data-bs-target="#modal_ajout_modif_action"
                        data-typemodal="ajouter">Ajouter
                        Action</button>
                </div>
            </div>
        </div>

        <div class="div_container_flex_row_categories_shop_ext">
            <div class="btn-group btn-group-lg" role="group" id="my_checkbox_categories">

                <?php
                $radio_checked = 'checked';
                $categorie_id = intval($details_traqueur['shop']['categorie_id']);
                ?>

                <input type="radio" class="btn-check" id="btnradio1" name="categorie_shop_ext" value="1" <?php echo $categorie_id == 1 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-success" for="btnradio1">Assistance en cours</label>

                <input type="radio" class="btn-check" id="btnradio2" name="categorie_shop_ext" value="2" <?php echo $categorie_id == 2 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-warning" for="btnradio2">En attente devis</label>

                <input type="radio" class="btn-check" id="btnradio3" name="categorie_shop_ext" value="3" <?php echo $categorie_id == 3 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-primary" for="btnradio3">en attente validation BDC</label>

                <input type="radio" class="btn-check" id="btnradio4" name="categorie_shop_ext" value="4" <?php echo $categorie_id == 4 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-dark" for="btnradio4">BDC envoyé</label>

                <input type="radio" class="btn-check" id="btnradio5" name="categorie_shop_ext" value="5" <?php echo $categorie_id == 5 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-info" for="btnradio5">En attente facture</label>

                <input type="radio" class="btn-check" id="btnradio6" name="categorie_shop_ext" value="6" <?php echo $categorie_id == 6 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-success" for="btnradio6">En cours de règlement</label>

                <input type="radio" class="btn-check" id="btnradio7" name="categorie_shop_ext" value="7" <?php echo $categorie_id == 7 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-secondary" for="btnradio7">En cours de recup</label>

                <input type="radio" class="btn-check" id="btnradio8" name="categorie_shop_ext" value="8" <?php echo $categorie_id == 8 ? $radio_checked : '' ?>>
                <label class="btn btn-outline-danger" for="btnradio8">En attente vérif RA</label>

            </div>
        </div>

        </form>


        <div class="div_validation_modif">
            <button type="button" class="btn btn-success" id="btn_modif_shop_ext">Enregistrer</button>
        </div>

        <div class="lds-ellipsis" id="loader" style="display:none;">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>


        <div class="div_validation_modif">
            <button type="button" class="btn btn-danger" id="btn_sortir_vh_shop_ext">Archiver VH</button>
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
                                <label for="action_effectuee">Action effectuée</label>
                                <textarea class="form-control" id="action_effectuee" rows="3"
                                    name="action_effectuee"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="remarque">Remarque</label>
                                <input type="text" class="form-control" id="remarque" name="remarque">
                            </div>

                            <div class="form-group">
                                <label for="is_action_factured">Facturé</label>
                                <select class="form-select" style="width : 200px;" id="is_action_factured"
                                    name="is_action_factured">
                                    <option value="1" selected> Oui </option>
                                    <option value="0"> Non </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"
                                            style="border-radius: 0px;">Montant
                                            €</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Montant"
                                        aria-describedby="basic-addon1" style="max-width: 100px;" name="montant_action"
                                        id="montant_action">
                                </div>
                            </div>

                            <!-- Champ caché pour envoyer la valeur du vehicule id -->
                            <input type="hidden" name="vehicule_id" id="vehicule_id" <?php echo "value='$id'" ?>>

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


        <div class="alert alert-success" role="alert" id="alert_shop_ext_modif_success" style="display:none;">
            Modifié
        </div>
        <div class="alert alert-danger" role="alert" id="alert_shop_ext_modif_fail" style="display:none;">
            Erreur : non modifié
        </div>

        <div class="alert alert-danger" role="alert" id="alert_action_added_fail" style="display:none;">
            Erreur : Action non ajoutée
        </div>


    </main>



    <!--========== MAIN JS ==========-->

    <!-- <script src="/assets/js/jquery-3.6.0.min.js"></script> -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/shop_exterieurs_modif.js"></script>
</body>

</html>