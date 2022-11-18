<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - Réseau</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <h2>Réseau</h2>
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



        <div class="container_form_recherche">

            <!-- <div class="my_div_recherche">
                <label for="input_num_serie">Numéro de série</label>
                <input type="text" class="form-control" id="input_num_serie" placeholder="Entrer le numéro de série">
            </div> -->
            <div class="my_div_recherche">
                <div class="element_filtre">
                    <label for="input_search_infra_reseau">Rechercher une infrastructure</label>
                    <input type="text" class="form-control" id="input_search_infra_reseau" placeholder="Infrastructure">
                </div>
            </div>
            <div class="my_div_recherche">
                <label for="afficher_print_agence">Infrastructure</label>
                <?php

                $all_infrastructure = get_all_infrastructure();

                echo "<select class='form-select' style='width : 200px;' id='afficher_reseau_agence'>";
                echo "<option value='0'> Tout </option>";
                foreach ($all_infrastructure as $infrastructure) {
                    echo "<option value='" . $infrastructure['ID'] . "'>" . utf8_encode($infrastructure['nom_infrastructure']) . "</option>";
                }
                echo "</select>";
                ?>
            </div>
        </div>

        </br>

        <table class="my_tab_perso" id="table_reseau_informatique">
        </table>

        <form id="modifier_imprimante_form" method="POST" action="modifier_imprimante.php">
            <input type="hidden" id="id_imprimante_modifier" name="id_imprimante_modifier" />
        </form>

        <span id="requete"></span>

        <br />

        <!-- <button id="button_fade_in">SQL Appear</button>
        <button id="button_fade_out">SQL Vanish</button> 
        <button id="button_fade_toggle">Fade Toggle</button>-->

        </br>
    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/informatique_reseau.js"></script>
</body>

</html>