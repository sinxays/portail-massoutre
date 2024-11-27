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

            //on regarde déja si le traqueur est déja monté ou non
            $details_traqueur = get_details_traqueur($id);
            // var_dump($details_traqueur);
        }
        ?>

        <H2> MODIFIER/MONTER UN TRAQUEUR </H2>

        <br />

        <div id="div_retour_detail_collaborateur">
            <i class='bx bx-left-arrow-circle bx-md'></i><span>Retour</span>
        </div>

        <div class="container_form_modif_lecture_shop_ext">
            <form id="form_traqueurs">

                <div class="row_box_traqueurs_modif">

                    <div class="box_traqueurs_modif">

                        <div class="div_form_traqueurs_label"><span>Traqueur</span></div>
                        <div class="div_contenu_box_traqueurs">
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
                                        style="width: 250px;" value="<?php echo $details_traqueur['imei'] ?>">
                                </div>
                                <!-- <div class="element_champ">
                                    <label for="sim_input">SIM</label>
                                    <input type="text" class="form-control" id="sim_input" name="sim"
                                        style="width: 150px;" value="<?php echo $details_traqueur['sim'] ?>">
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="box_traqueurs_modif">

                        <div class="div_form_traqueurs_label"><span>Véhicule</span></div>
                        <div class="div_contenu_box_traqueurs">
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
                                        <label for="type_input">Type de véhicule</label>
                                        <input type="text" class="form-control" id="type_input" name="type"
                                            style="width: 150px;" value="<?php echo $details_traqueur['type'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row_box_traqueurs_modif">
                    <div class="box_traqueurs_modif">
                        <div class="div_form_traqueurs_label"><span>Montage</span></div>
                        <div class="div_contenu_box_traqueurs">
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
            </form>

            <!-- Champ caché pour envoyer la valeur du vehicule id -->
            <input type="hidden" name="vehicule_id" <?php echo "value='$id'" ?>>


            <div class="div_validation_modif">
                <button type="button" class="btn btn-success" id="btn_modif_shop_ext">Enregistrer</button>
            </div>

            <div class="div_validation_modif">
                <button type="button" class="btn btn-danger" id="btn_sortir_vh_shop_ext">ANNULER</button>
            </div>

        </div>



    </main>



    <!--========== MAIN JS ==========-->

    <!-- <script src="/assets/js/jquery-3.6.0.min.js"></script> -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/shop_exterieurs_modif.js"></script>
</body>

</html>