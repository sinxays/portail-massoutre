<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">



    <title>Portail Massoutre - TRAQUEURS</title>
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

        <H2> TRAQUEURS </H2>

        <form class="my_form_shop_ext">

            <div class="div_filtre_shop_ext">

                <div id="div_shop_ext_1">
                    <div id="div_shop_ext_1_1">
                        <label for="immatriculation_input">Immatriculation</label>
                        <input type="text" class="form-control" id="immatriculation_input" placeholder="Immat">
                    </div>
                    <div id="div_shop_ext_1_2">
                        <label for="mva_input">MVA</label>
                        <input type="text" class="form-control" id="mva_input" placeholder="MVA">
                    </div>
                </div>
                <div id="div_shop_ext_2">
                    <div id="div_shop_ext_2_1">
                        <button type="button" class="btn btn-success" id="btn_ajout_montage_traqueur"
                            data-bs-toggle="modal" data-bs-target="#modal_ajout_montage_traqueur"
                            data-typemodal="ajouter">
                            Ajouter montage traqueur </button>
                    </div>
                </div>

            </div>


        </form>


        <br />
        <div class="elements_row">
            <div class="lds-ellipsis" id="loader" style="display:none;">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div> <br />

        <span id="table_shop_exterieur"></span>

        <br />
        <br />


    </main>

    <!-- Modal ajout Traqueur -->

    <div class="modal fade bd-example-modal-lg" id="modal_ajout_montage_traqueur" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width: 1000px;">
                <div class="modal-header" id="my_modal_header_ajout_montage">
                    <h5 class="modal-title" id="title_ajout_modif_action">Ajouter montage traqueur</h5>
                </div>

                <div class="modal_ajout_modif_action_body">
                    <form id="form_ajout_action">

                    <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1" style="border-radius: 0px;">Numéro de série</span>
                                </div>
                                <input type="text" class="form-control" aria-label="S/N"
                                    aria-describedby="basic-addon1" style="max-width: 250px;" name="serial_number"
                                    id="serial_number">
                            </div>
                        </div>


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
                        Montage</button>
                </div>


            </div>
        </div>
    </div>

    <!-- FIN MODAL Ajout Traqueur -->



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/traqueurs.js"></script>

</body>

</html>