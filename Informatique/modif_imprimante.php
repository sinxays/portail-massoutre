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

        <?php

        if (isset($_GET['id']) && $_GET['id'] !== '') {
            echo $_GET['id'];
            $imprimante = get_imprimante_by_ID($_GET['id']);
            var_dump($imprimante);

            $array_prestataire = array("CONCEPTA", "AE");
            $array_marques_imprimantes = array("KONICA MINOLTA", "KYOCERA");
        }

        ?>

        <div class="container_form_ajout">

            <form id="ajout_imprimante_form">
                <input type="hidden" id="id_imprimante" name="id_imprimante" value="<?php echo $imprimante['ID']; ?>">
                <div class="div_form_ajout">
                    <label for="num_serie">Numéro de série</label>
                    <input type="text" class="form-control" id="num_serie" placeholder="numéro de serie" name="num_serie" value="<?php echo $imprimante['num_serie']; ?>">
                </div>


                <?php

                $infrastructures = get_all_infrastructure();
                ?>

                <div class="div_form_ajout">
                    <label for="agence">Infrastructure</label>
                    <select class="form-select" id="agence" style="width: 150px;" name="agence">
                        <?php
                        foreach ($infrastructures as $infrastructure) {
                            if ($infrastructure['ID'] == $imprimante['id_infrastructure_imprimante']) {
                                echo  "<option value='" . $infrastructure['ID'] . "' selected='selected'>" . $infrastructure['nom_infrastructure'] . "</option>";
                            } else {
                                echo  "<option value='" . $infrastructure['ID'] . "'>" . $infrastructure['nom_infrastructure'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="div_form_ajout">
                    <input type="text" class="form-control" id="emplacement" placeholder="emplacement" name="emplacement" value="<?php echo $imprimante['emplacement']; ?>">
                </div>


                <div class="div_form_ajout">
                    <label for="prestataire">Prestataire</label>
                    <select class="form-select" id="prestataire" style="width: 150px;" name="prestataire">
                        <?php

                        if (!in_array($imprimante['prestataire'], $array_prestataire)) {
                            echo  "<option value='" . $imprimante['prestataire'] . "'>" . $imprimante['prestataire'] . "</option>";
                        }

                        foreach ($array_prestataire as $prestataire) {
                            if ($imprimante['prestataire'] == $prestataire) {
                                echo  "<option selected ='selected' value='" . $prestataire . "'>" . $prestataire . "</option>";
                            } else {
                                echo  "<option value='" . $prestataire . "'>" . $prestataire . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="div_form_ajout">
                    <label for="marque">Marque</label>
                    <select class="form-select" id="marque" style="width: 150px;" name="marque">

                        <?php

                        if (!in_array($imprimante['marque'], $array_marques_imprimantes)) {
                            echo  "<option value='" . $imprimante['marque'] . "'>" . $imprimante['marque'] . "</option>";
                        }

                        foreach ($array_marques_imprimantes as $marque_imprimante) {
                            if ($imprimante['marque'] == $marque_imprimante) {
                                echo  "<option selected ='selected' value='" . $marque_imprimante . "'>" . $marque_imprimante . "</option>";
                            } else {
                                echo  "<option value='" . $marque_imprimante . "'>" . $marque_imprimante . "</option>";
                            }
                        }
                        ?>


                    </select>
                </div>

                <div class="div_form_ajout">
                    <?php echo "<input type='text' class='form-control' id='modele' placeholder='" . $imprimante['modele'] . "' name='modele' value='" . $imprimante['modele'] . "'>" ?>
                </div>

                <div class="div_form_ajout">
                    <?php echo "<input type='text' class='form-control' id='ip_vpn' placeholder='" . $imprimante['ip_vpn'] . "' name='ip_vpn' value='" . $imprimante['ip_vpn'] . "'>" ?>
                </div>

                <div class="div_form_ajout">
                    <?php echo "<input type='text' class='form-control' id='ip_locale' placeholder='" . $imprimante['ip_locale'] . "' name='ip_locale' value='" . $imprimante['ip_locale'] . "'>" ?>
                </div>

                <button type="button" class="btn btn-success" id="btn_modif_imprimante">Modifier Imprimante</button>

                <div class="lds-ellipsis" id="loader_ajout_imprimante" style="display:none;">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </form>

            </br>

            <div class="alert alert-success" role="alert" id="alert_imprimante_ajoutee" style="display:none;">
                Imprimante mise à jour
            </div>

        </div>


    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/informatique_imprimantes.js"></script>
</body>

</html>