<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - Payplan V2 </title>
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

        <H2> GRILLE DE GESTION </H2>


        <!-- Debut Filtre -->

        <form class="my_form_payplan">
            <?php
            ini_set('xdebug.var_display_max_depth', 99);

            ?>

            <div class="my_div_form" id="collaborateur_div" style="display: none;">
                <label for="select_collaborateur_grille_de_gestion">Collaborateur</label>
                <?php

                // $all_collaborateurs_cvo = get_all_collaborateurs_cvo_for_select();
                $all_collaborateurs_cvo = get_all_collaborateurs_actif_cvo_for_select();
                // var_dump($all_collaborateurs_cvo);
                // die();
                
                echo "<select class='form-select' style='width : 200px;' id='select_collaborateur_grille_de_gestion' data-id='id_collaborateur'>";
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


            <div class="my_div_form" id="collaborateur_div">
                <label for="select_date_payplan_v2">Date</label>
                <?php

                echo "<select class='form-select' style='width : 200px;' id='select_date_grille_de_gestion'>";
                echo "<option value=0> Mois en cours </option>";
                echo "<option value=1> Mois précédent</option>";
                echo "<option value=2>personnalisée</option>";
                echo "</select>";

                ?>

                <span id="span_load_date"></span>

            </div>

            <div class="my_div_form" id="date_personnalisees_div" style="display:none">
                <div class="my_div_form" id="div_date_debut">
                    <label for="date_debut">Date Début</label>
                    <input type="date" id="date_debut" style="border-radius: 5px;"
                        placeholder="Date de début payplan" />
                </div>
                <div class="my_div_form" id="div_date_fin" style="display:none">
                    <label for="date_fin">Date Fin</label>
                    <input type="date" id="date_fin" style="border-radius: 5px;" placeholder="Date de fin payplan" />
                </div>
                <button type="button" class="btn btn-success" disabled id="btn_valider_date_perso">Valider date</button>
            </div>

            <!-- <div class="my-last-div-form">
                <button type="button" class="btn btn-success"> réinitialiser filtre </button>
            </div> -->
        </form>

        <!-- FIN Filtre -->


        <div class="toast" id='toast_export' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Statut Export</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Export terminé
            </div>
        </div>

        </br>

        <div id="btn_exporter">
            <!-- <a href="req/export.php"><i class='bx bxs-file-export bx-md'></i><span id='label_export'>Exporter</span></a> -->
            <i class='bx bxs-file-export bx-md'></i><span id='label_export'>Exporter</span>
        </div>

        <div class="elements_row">
            <div class="lds-ellipsis" id="loader" style="display:none;">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div>
            <table class="my_tab_grille_de_gestion" id="table_payplan_grille_de_gestion"> </table>
        </div>




        <?php
        saut_de_ligne();

        // $payplan = get_commission();
        // var_dump($payplan);
        
        ?>






    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/payplan_grille_de_gestion.js"></script>
</body>

</html>