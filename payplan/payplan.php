<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - Payplan </title>
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

        <div class="div_payplan_update">
            <div class="div_payplan_update1">
                <button type="button" class="btn btn-success" style="text-align: center;" id="bouton_update_payplan"><span>Update</span> <i class='bx bx-refresh bx-sm bx-tada'></i></button>
            </div>
            <div class="div_payplan_update2">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary" id="bouton_tableau_collaborateurs" value="collaborateurs">Tableau collaborateurs Payplan</button>
                    <button type="button" class="btn btn-warning" id="bouton_tableau_commision" value="commission">Tableau Commission Total</button>
                </div>
            </div>
        </div>

        <form class="my_form_payplan">
            <?php
            ini_set('xdebug.var_display_max_depth', 99);

            ?>

            <div class="my_div_form" id="collaborateur_div">
                <label for="select_collaborateur_payplan">Collaborateur</label>
                <?php

                $all_collaborateurs_cvo = get_all_collaborateurs_cvo_for_select();
                // var_dump($all_collaborateurs_cvo);
                // die();

                echo "<select class='form-select' style='width : 200px;' id='select_collaborateur_payplan' data-id='id_collaborateur'>";
                echo "<option value=0> Tout </option>";
                foreach ($all_collaborateurs_cvo as $site_cvo) {
                    echo "<optgroup class='opt1' label='" . $site_cvo['nom_cvo'] . "' >";
                    foreach ($site_cvo['collaborateurs'] as $collaborateur) {
                        echo "<option class='payplan_collaborateurs_option' value=" . $collaborateur['ID'] . ">" . $collaborateur['nom'] . " " . $collaborateur['prenom'] . "</option>";
                    }
                    echo "</optgroup>";
                }
                echo "</select>";
                ?>

            </div>

            <!-- <div class="my_div_form">
                <label for="select_site_payplan">Site</label>
                <select id="select_site_payplan" class="form-select">
                    <?php
                    echo "<option value='0'> Tout </option>";
                    foreach ($all_collaborateurs_cvo as $site) {
                        echo "<option value='" . $site['ID'] . "'>" . $site['nom_cvo'] . "</option>";
                    }
                    ?>
                </select>
            </div> -->

            <div class="my_div_form" id="div_form_destination">
                <label for="select_destination_payplan">Destination</label>
                <select id="select_destination_payplan" class="form-select">
                    <?php
                    $select_destinations = get_destination_for_select();
                    echo "<option value=0> Tout </option>";
                    foreach ($select_destinations as $destination) {
                        echo "<option value=" . $destination['id'] . "> " . utf8_encode($destination['libelle']) . " </option>";
                    }
                    ?>
                </select>
            </div>

            <div class="my_div_form" id="div_form_type_achat">
                <label for="select_type_achat_payplan">Type Achat</label>
                <select id="select_type_achat_payplan" class="form-select">
                    <?php
                    echo "<option value=0> Tout </option>";
                    echo "<option value=1> Occasion </option>";
                    echo "<option value=2> Neuf </option>";
                    echo "<option value=3> Reprise </option>";

                    ?>
                </select>
            </div>

            <div class="my_div_form">
                <label for="date_locations_stats_debut">Date Début</label>
                <input type="date" id="date_locations_stats_debut" style="border-radius: 5px;" placeholder="Date de début locations stats" />
            </div>
            <div class="my_div_form">
                <label for="date_locations_stats_fin">Date Fin</label>
                <input type="date" id="date_locations_stats_fin" style="border-radius: 5px;" placeholder="Date de fin locations stats" />
            </div>

            <!-- <div class="my-last-div-form">
                <button type="button" class="btn btn-success"> réinitialiser filtre </button>
            </div> -->
        </form>

        </br>

        <table class="my_tab_payplan" id="table_payplan"> </table>

        </br> </br>




        <?php
        saut_de_ligne();

        // $payplan = get_payplan();
        // var_dump($payplan);

        ?>



        <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/payplan.js"></script>
</body>

</html>