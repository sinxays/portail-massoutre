<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - Suivi BDC</title>
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

        <H2> SUIVI DES VENTES </H2>


        <form class="my_form_stats_loc">

            <div class="my_div_form">
                <label for="afficherType_select">Provenance du vh (Type)</label>
                <select class="form-select" id="select_provenance_vh">
                    <option selected value="1" style="color:green;font-weight:bold;">Locations</option>
                    <option value="2" style="color:red;font-weight:bold;">Negoce</option>
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

            <!-- <div class="my_div_form">
                <label for="afficher_cvo">CVO</label>

                <?php
                ini_set('xdebug.var_display_max_depth', 99);

                $liste_cvo = get_cvo_actif();

                echo "<select class='form-select' style='width : 200px;' id='afficher_cvo' data-id='id_cvo'>";
                echo "<option value='0'> Tout </option>";
                foreach ($liste_cvo as $cvo) {
                    echo "<option value='" . $cvo['ID'] . "'>" . $cvo['nom_cvo'] . "</option>";
                }
                echo "</select>";
                ?>
            </div> -->


            <div class="my-last-div-form">
                <!--<button type="button" class="btn btn-success">Success</button> -->
            </div>


        </form>

        <br />

        <label for="date_recup_bdc">Date BDC à récupérer</label>
        <input type="date" id="date_recup_bdc" style="border-radius: 5px;" placeholder="Date BDC à récupérer" />

        <button disabled type="button" class="btn btn-success" style="text-align: center;margin-left: 10px;"
            id="btn_alimenter_suivi_ventes" ><span>Alimenter Suivi ventes</span> </button>


        <?php

        saut_de_ligne();

        ?>

        <span id="table_stats_suivi_bdc_particuliers"></span>
        <br />
        <span id="table_stats_suivi_bdc_marchands"></span>
        <br />
        <span id="table_stats_suivi_bdc_all"></span>
        <br />

        <br />

        <?php
        saut_de_ligne();
        ?>



        <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/suivi_bdc.js"></script>
</body>

</html>