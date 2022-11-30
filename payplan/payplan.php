<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - Marge </title>
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

        <H2> PAYPLAN </H2>


        <form class="my_form_marge">

            <div class="my_div_form">
                <label for="afficher_agence">Agences</label>

                <?php
                ini_set('xdebug.var_display_max_depth', 99);

                $allDistrictSecteursAgencesGroup = getAllAgencesGroupSecteurDistrict();

                $all_collaborateurs_cvo = get_all_collaborateurs_cvo();


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
            <label for="select_collaborateur">Collaborateur</label>
                <?php

                echo "<select class='form-select' style='width : 200px;' id='select_collaborateur' data-id='id_collaborateur'>";
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

            <div class="my_div_form">
                <label for="date_locations_stats_debut">Date Début</label>
                <input type="date" id="date_locations_stats_debut" placeholder="Date de début locations stats" />
            </div>
            <div class="my_div_form">
                <label for="date_locations_stats_fin">Date Fin</label>
                <input type="date" id="date_locations_stats_fin" placeholder="Date de fin locations stats" />
            </div>

            <div class="my-last-div-form">
                <button type="button" class="btn btn-success">Success</button>
            </div>


        </form>

        <?php

        saut_de_ligne();

        $agences = get_all_agences();

        ?>

        <table class="my_tab_perso" id="table_marge"> </table>

        <?php
        saut_de_ligne();
        ?>



        <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/marge.js"></script>
</body>

</html>