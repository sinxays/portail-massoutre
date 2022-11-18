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



    <title>Portail Massoutre - Liste TOIP</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <strong></strong>
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


        <script>

        </script>
        <H2> Liste Téléphonique </H2>

        <div class="container_form_recherche">

            <div class="my_div_recherche">
                <label for="input_num_serie">Rechercher</label>
                <input type="text" class="form-control" id="input_collaborateur" placeholder="un collaborateur ou infrastructure">
            </div>

            <div class="my_div_recherche">
                <label for="afficher_print_agence">Type</label>
                <?php
                ini_set('xdebug.var_display_max_depth', 99);

                $all_infrastructure = get_all_infrastructure();

                echo "<select class='form-select' style='width : 200px;' id='select_type' data-id='id_agence'>";
                echo "<option value='agences'> Agences </option>";
                echo "<option value='agent'> Agent </option>";
                echo "<option value='cvo'> CVO </option>";
                echo "<option value='siege'> Siège </option>";
                echo "</select>";
                ?>
            </div>

            <div class="my_div_recherche">
                <div id="infra_select_div">
                    <label for="afficher_print_agence">infrastructure</label>
                    <?php
                    $all_infrastructure = get_all_infrastructure();

                    echo "<select class='form-select' style='width : 200px;' id='select_infrastructure' data-id='id_agence'>";
                    echo "<option value='0'> Tout </option>";
                    foreach ($all_infrastructure as $infrastructure) {
                        echo "<option value='" . $infrastructure['ID'] . "'>" . utf8_encode($infrastructure['nom_infrastructure']) . "</option>";
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>


            <div class="my_div_recherche">
                <div id="btn_afficher_all_div">
                    <button class="btn btn-success" id="afficher_liste_telephonique">Afficher tout</button>
                </div>
            </div>
        </div>



        </br>

        <div class="lds-ellipsis" id="loader_liste_telephonique" style="display: none;">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

        <span id="label_tableau"></span>
        <br />

        <table class="my_tab_perso" id="table_liste_telephonique"> </table>

        <form id="modifier_agence_form" method="POST" action="modifier_agence.php">
            <input type="hidden" id="id_agence_modifier" name="id_agence_modifier" />
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
    <script src="../assets/js/liste_telephonique.js"></script>
</body>

</html>