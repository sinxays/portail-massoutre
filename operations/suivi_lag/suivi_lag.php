<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- Basic Icons -->
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <!-- Filled Icons -->
    <link href="https://cdn.boxicons.com/3.0.8/fonts/filled/boxicons-filled.min.css" rel="stylesheet">
    <!-- Brand Icons -->
    <link href="https://cdn.boxicons.com/3.0.8/fonts/brands/boxicons-brands.min.css" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">



    <title>Portail Massoutre - Suivi LAG</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <?php include "../../header.php";

    // NAV  
    include "../../right_menubar.php";
    include "../../include.php"; ?>




    <!--============================== CONTENTS ==============================-->
    <main>

        <!-- LOGO LAG -->
        <img src="../../assets/img/LAG_logo.png" alt="" class="header__lag_img">

        <form class="my_form_shop_ext">

            <div class="div_filtre_shop_ext">

                <div id="div_shop_ext_1">
                    <div id="div_shop_ext_1_1">
                        <label for="immatriculation_input">Immatriculation</label>
                        <input type="text" class="form-control" id="immatriculation_input" placeholder="Immat">
                    </div>
                    <div id="div_shop_ext_1_2">
                        <label for="client_input">Client</label>
                        <input type="text" class="form-control" id="client_input" placeholder="Client">
                    </div>
                    <div id="div_shop_ext_1_3">
                        <label for="categories">Type d'alerte</label>
                        <!-- <label for="categories">Type d'entretien</label> -->
                        <select class="form-select" id="select_id_code_alerte" name="select_id_code_alerte">
                            <?php
                            $list_categories = get_suivi_lag_type_alertes();
                            echo "<option value='0'> </option>";
                            foreach ($list_categories as $categorie) {
                                echo "<option value='" . $categorie['ID'] . "'>" . $categorie['libelle'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="div_shop_ext_1_4">
                        <label for="select_archive">ARCHIVES</label>
                        <select class="form-select" id="select_archive" name="archive">
                            <option value='0'> En cours </option>
                            <option value='1'> Archivés </option>
                        </select>
                    </div>
                    <div id="div_shop_ext_1_5">
                        <div id="refresh_filters"><i class="bx bx-rotate-ccw bx-remove-padding bx-tada"
                                style="font-size: 25px;"></i></div>
                    </div>
                </div>
                <div id="div_shop_ext_2">
                    <div id="div_shop_ext_2_1">
                        <button type="button" class="btn btn-success" id="btn_import_fichier_excel"
                            data-bs-toggle="modal" data-bs-target="#modal_import"> Importer</button>
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

        <br /> <br />



        <div class="modal" id="modal_import" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Importer fichier Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal_body">
                        <form id="form_import_fichier_suivi_lag">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Fichier à importer</label>
                                <input class="form-control" type="file" id="formFile" name="fichier_a_importer">
                            </div>

                            <div class="form-group">
                                <label for="select_fichier" class="form-label"> Source du fichier </label>
                                <select class="form-select" id="select_source_fichier" name="select_source_fichier">
                                    <option value="base" selected>BASE VHS LLD</option>
                                    <option value="echoes">Echoes</option>
                                    <option value="hitech">Hitech</option>
                                    <!-- <option value="hitech_bis">Hitech_bis</option> -->
                                </select>
                            </div>
                            <input type="text" name="import_fichier" id="id_import_fichier" value="import_fichier"
                                hidden>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                            id="button_import_fichier_suivi_lag">Importer</button>
                    </div>


                </div>
            </div>
        </div>





    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/suivi_lag.js"></script>

</body>

</html>