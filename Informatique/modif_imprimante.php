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



    <title>Portail Massoutre - AJOUT IMPRIMANTE</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <strong>test</strong>
            <img src="../assets/img/perfil.jpg" alt="" class="header__img">

            <a href="#" class="header__logo"> </a>

            <!-- <div class="header__search">
                <input type="search" placeholder="Search" class="header__input">
                <i class='bx bx-search header__icon'></i>
            </div> -->

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


        <H2> AJOUT IMPRIMANTES </H2>

        <div class="container_form_ajout">

            <form id="ajout_imprimante_form">
                <div class="div_form_ajout">
                    <input type="text" class="form-control" id="num_serie" placeholder="numéro de serie" name="num_serie">
                </div>


                <?php

                $agences = get_all_agences();

                ?>

                <div class="div_form_ajout">
                    <label for="agence">Agence</label>
                    <select class="form-select" id="agence" style="width: 150px;" name="agence">
                        <?php
                        foreach ($agences as $agence) {
                            echo  "<option value='" . $agence['ID'] . "'>" . $agence['nom_agence'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="div_form_ajout">
                    <input type="text" class="form-control" id="emplacement" placeholder="emplacement" name="emplacement">
                </div>


                <div class="div_form_ajout">
                    <label for="prestataire">Prestataire</label>
                    <select class="form-select" id="prestataire" style="width: 150px;" name="prestataire">
                        <option selected value="AE">AE</option>
                        <option value="ASI">ASI</option>
                        <option value="ESUS">ESUS</option>

                    </select>
                </div>

                <div class="div_form_ajout">
                    <label for="marque">Marque</label>
                    <select class="form-select" id="marque" style="width: 150px;" name="marque">
                        <option selected value="KYOCERA">KYOCERA</option>
                        <option value="KONICA MINOLTA">KONICA MINOLTA</option>
                        <option value="HP">HP</option>
                        <option value="autre">AUTRE</option>
                    </select>
                </div>

                <div class="div_form_ajout">
                    <input type="text" class="form-control" id="modele" placeholder="Modèle" name="modele">
                </div>

                <div class="div_form_ajout">
                    <input type="text" class="form-control" id="ip_vpn" placeholder="IP VPN" name="ip_vpn">
                </div>

                <div class="div_form_ajout">
                    <input type="text" class="form-control" id="ip_locale" placeholder="IP Locale" name="ip_locale">
                </div>

                <button type="button" class="btn btn-success" id="btn_ajout_imprimante">Ajouter Imprimante</button>

                <div class="lds-ellipsis" id="loader_ajout_imprimante" style="display:none;">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </form>

            </br>

            <div class="alert alert-success" role="alert" id="alert_imprimante_ajoutee" style="display:none;">
                Imprimante ajoutée
            </div>

            <form id="upload_csv_form" class="form-horizontal" method="post" name="upload_csv_form" enctype="multipart/form-data">
                        <!--<form id="upload_csv_form" class="form-horizontal" action="import_csv_stats_journalieres.php" method="post" name="upload_csv_form" enctype="multipart/form-data">-->
                        <fieldset style="margin-top: 20px;">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="col-md-4 control-label" for="csv_file">Importer csv imprimantes</label>
                                    <input type="file" name="csv_file" id="csv_file" class="input-large">
                                </div>
                                <div class="col-md-4" id="bloc_date_import_csv">
                                    <button style="margin-left: 20px;" type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                                    <div class="lds-ellipsis" id="loader_import_csv_imprimantes">
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


    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/informatique_imprimantes.js"></script>
</body>

</html>