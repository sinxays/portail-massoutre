<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - locations stats</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <img src="../assets/img/perfil.jpg" alt="" class="header__img">

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
    <?php include "../right_menubar.php";
    include "../include.php"; ?>




    <!--============================== CONTENTS ==============================-->
    <main>

        <H2> LOCATIONS STATS </H2>


        <form class="my_form_stats_loc">

            <div class="my_div_form">
                <label for="afficherType_select">Type</label>
                <select class="form-select" id="afficherType_select">
                    <option selected value="cumul">CUMUL</option>
                    <option value="vp" style="color:green;font-weight:bold;">VP</option>
                    <option value="vu" style="color:red;font-weight:bold;">VU</option>
                </select>
            </div>

            <!--<div class="my_div_form">
                <label for="afficherResultats_select">Résultats</label>
                <select class="form-select" id="afficherResultats_select">
                    <option selected value="tous">Tous</option>
                    <option value="positif" style="color:green;font-weight:bold;">Positifs</option>
                    <option value="negatif" style="color:red;font-weight:bold;">Négatifs</option>
                </select>
            </div>
-->

            <div class="my_div_form">
                <label for="afficher_agence">Agence</label>

                <?php
                ini_set('xdebug.var_display_max_depth', 99);

                $allDistrictSecteursAgencesGroup = getAllAgencesGroupSecteurDistrict();

                echo "<select class='form-select' style='width : 200px;' id='afficher_agence' data-id='id_agence'>";
                echo "<option value='0'> Tout </option>";
                foreach ($allDistrictSecteursAgencesGroup as $district) {
                    echo "<optgroup class='opt1' label='District " . $district['nom_district'] . "' >";
                    foreach ($district['agences'] as $agenceOrSecteur) {
                        echo "<option value='" . $agenceOrSecteur['ID'] . "'>" . $agenceOrSecteur['nom_agence'] . "</option>";
                    }
                    foreach ($district['secteurs'] as $secteur) {
                        echo "<optgroup class='opt2' label='Secteur " . $secteur['nom_secteur'] . "' >";
                        foreach ($secteur['agences'] as $agence) {
                            echo "<option value='" . $agence['ID'] . "'>" . $agence['nom_agence'] . "</option>";
                        }
                        echo "</optgroup>";
                    }
                    echo "</optgroup>";
                }
                echo "</select>";
                ?>
            </div>

            <div class="my_div_form">
                <label for="afficherSecteurs_select">Secteur</label>
                <select id="afficherSecteurs_select" class="form-select"></select>
            </div>

            <div class="my_div_form">
                <label for="afficherDistrict_select">District</label>
                <select id="afficherDistrict_select" class="form-select"></select>
            </div>

            <!-- <div class="my_div_form">
                <label for="date_locations_stats_debut">Date Début</label>
                <input type="date" id="date_locations_stats_debut" placeholder="Date de début locations stats" />
            </div>
            <div class="my_div_form">
                <label for="date_locations_stats_fin">Date Fin</label>
                <input type="date" id="date_locations_stats_fin" placeholder="Date de fin locations stats" />
            </div>-->

            <div class="my_div_form">
                <label for="date_locations_stats">Date</label>
                <input type="date" id="date_locations_stats" style="border-radius: 5px;height: 40px;" placeholder="Date de locations stats" />
            </div>

            <div class="my-last-div-form">
                <!--<button type="button" class="btn btn-success">Success</button> -->
            </div>


        </form>

        <?php

        saut_de_ligne();

        $agences = get_all_agences();


        ?>

        <span id="label_tableau"></span>
        <br />

        <table class="my_tab_perso" id="table_stats_locations"> </table>

        <span id="requete"></span>



        <br />

        <button id="button_fade_in">SQL Appear</button>
        <button id="button_fade_out">SQL Vanish</button>
        <!--<button id="button_fade_toggle">Fade Toggle</button>-->


        <?php
        saut_de_ligne();
        ?>


        <!-- UPLOADER UN FICHIER CSV -->
        <div id="wrap">
            <div class="container">
                <div class="row">
                    <form id="upload_csv_form" class="form-horizontal" method="post" name="upload_csv_form" enctype="multipart/form-data">
                        <!--<form id="upload_csv_form" class="form-horizontal" action="import_csv_stats_journalieres.php" method="post" name="upload_csv_form" enctype="multipart/form-data">-->
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Importer stats</legend>
                            <!-- File Button -->
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="col-md-4 control-label" for="csv_file">Importer un csv</label>
                                    <input type="file" name="csv_file" id="csv_file" class="input-large">
                                </div>
                                <div class="col-md-4" id="bloc_date_import_csv">
                                    <label for="date_import_stats">Date ?</label>
                                    <input type="date" id="date_import_stats" name="date_csv" style="border-radius: 5px;" />
                                    <button style="margin-left: 20px;" type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                                    <div class="lds-ellipsis" id="loader_import_csv">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <br />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <br />

        <div id="wrap">
            <div class="container">

                <div class="form-group">
                    <div class="col-md-8">
                        <button id="bouton_alimenter_tableau" class="btn btn-warning">Alimenter Table VP VU CUMUL</button>
                        <div class="lds-ellipsis" id="loader_alimenter_base">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                </div>
                <br />
                <div class="csontainer">
                    <div class="form-group">
                        <div class="col-md-8">

                            <button id="bouton_vider_table_vp_vu_cumul" class="btn btn-danger">Vider Table VP VU CUMUL</button>
                            <div class="lds-ellipsis" id="loader_vider_base_vp_vu_cumul">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>


                            <button id="bouton_vider_table" class="btn btn-danger">Vider Table import</button>
                            <div class="lds-ellipsis" id="loader_vider_base_import">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>

                        </div>
                    </div>
                </div>


                <?php
                saut_de_ligne();
                ?>



                <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/stats_locations.js"></script>
</body>

</html>