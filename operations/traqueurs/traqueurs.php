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

                        <button type="button" class="btn btn-success" id="btn_ajout_traqueurs">
                            <a href="liste_traqueurs.php" style="color: white;">Liste traqueurs</a> </button>
                        <button type="button" class="btn btn-success" id="btn_ajout_montage_traqueur"
                            data-bs-toggle="modal" data-bs-target="#modal_ajout_montage_traqueur"
                            data-typemodal="ajouter">
                            Ajouter montage </button>
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

        <span id="table_traqueurs"></span>

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

                <div class="modal_ajout_montage_traqueur_body">
                    <form id="form_ajout_montage_traqueur">

                        <div class="div_body_modal_traqueurs">
                            <div class="div_cadre_modal_traqueurs">
                                <div class="div_titre_cadre_modal_traqueurs" style="background-color: #a03939;">
                                    <h3>Traqueur</h3>
                                </div>

                                <div class="div_cadre_element_modal_traqueurs" style="background-color: #f5f5f5;">
                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="border-radius: 5px 0 0 5px ;">Numéro
                                                de série</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="serial_number"
                                            id="serial_number_input">


                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ; margin-left: 50px;">SIM</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="sim" id="sim_input">
                                    </div>

                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ;">IMEI</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 450px;border-radius: 0 5px 5px 0;" name="imei"
                                            id="imei_input">
                                    </div>
                                </div>

                            </div>


                            <div class="div_cadre_modal_traqueurs">
                                <div class="div_titre_cadre_modal_traqueurs" style="background-color: #346a36;">
                                    <h3>Véhicule</h3>
                                </div>

                                <div class="div_cadre_element_modal_traqueurs" style="background-color: #f5f5f5;">
                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ;">Immatriculation</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="immatriculation"
                                            id="immatriculation_input">


                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ; margin-left: 50px;">Type</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="type"
                                            id="type_input">
                                    </div>

                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ;">MVA</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 150px;border-radius: 0 5px 5px 0;" name="mva" id="mva_input">
                                    </div>
                                </div>

                            </div>
                            <div class="div_cadre_modal_traqueurs">

                                <div class="div_titre_cadre_modal_traqueurs" style="background-color: #356c9c;">
                                    <h3>Installation</h3>
                                </div>

                                <div class="div_cadre_element_modal_traqueurs" style="background-color: #f5f5f5;">
                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="form-group">
                                            <label for="dateInput">Date</label>
                                            <input type="date" class="form-control" id="date_installation"
                                                name="date_installation" style="width: 200px;margin-right: 30px;">
                                        </div>

                                        <div class="form-group">
                                            <label for="dateInput">MAJ site</label>
                                            <input type="date" class="form-control" id="maj_site" name="maj_site"
                                                style="width: 200px;">
                                        </div>
                                    </div>

                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="border-radius: 5px 0 0 5px;">Lieu
                                                montage</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="lieu_montage"
                                            id="lieu_montage_input">


                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ;margin-left: 50px;">Nom
                                                Monteur</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="nom_monteur"
                                            id="nom_monteur_input">
                                    </div>

                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px;">Position</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 600px;border-radius: 0 5px 5px 0;" name="position"
                                            id="postion_input">
                                    </div>

                                    <div class="div_element_row_modal_traqueurs">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px;">ODB</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 150px;border-radius: 0 5px 5px 0;" name="obd" id="obd_input">


                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ;margin-left: 50px;">Nom
                                                ODB</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 250px;border-radius: 0 5px 5px 0;" name="nom_monteur_obd"
                                            id="nom_monteur_obd_input">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="border-radius: 5px 0 0 5px ;margin-left: 50px;">Soudure
                                            </span>
                                        </div>
                                        <input type="text" class="form-control"
                                            style="width: 150px;border-radius: 0 5px 5px 0;" name="soudure"
                                            id="soudure_input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer" id="modal_footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="button_annuler">Annuler</button>
                        <button type="button" class="btn btn-primary" id="button_ajouter_montage_traqueur"
                            style="background-color:#009f08;border: 0px;">Ajouter
                            Montage traqueur</button>
                    </div>
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