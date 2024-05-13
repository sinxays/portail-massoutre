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

            <a href="#" class="header__logo">  </a>

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
                <select class="form-select" id="select_provenance_vh" name="afficherType_select" style="width: 150px;">
                    <option selected value="1" style="color:green;font-weight:bold;">Locations</option>
                    <option value="2" style="color:red;font-weight:bold;">Negoce</option>
                </select>

            </div>

            <div class="my_div_form">

                <label for="select_date_suivi_bdc">Date</label>
                <select class="form-select" id="select_date_suivi_bdc" name="select_date_suivi_bdc"
                    style="width : 200px;">
                    <option value=0> Mois en cours </option>
                    <option value=1> Mois précédent</option>
                    <option value=2>personnalisée</option>
                </select>

            </div>

            <div class="my_div_form" id="date_personnalisees_div" style="display:none">
                <div class="my_div_form" id="div_date_debut">
                    <label for="date_suivi_bdc_debut">Date Début</label>
                    <input type="date" id="date_suivi_bdc_debut" style="border-radius: 5px;"
                        placeholder="Date de début payplan" />
                </div>
                <div class="my_div_form" id="div_date_fin" style="display:none">
                    <label for="date_suivi_bdc_fin">Date Fin</label>
                    <input type="date" id="date_suivi_bdc_fin" style="border-radius: 5px;"
                        placeholder="Date de fin payplan" />
                </div>
                <button type="button" class="btn btn-success" disabled id="btn_valider_date_perso">Valider date</button>
            </div>


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


        <div id="div_recup_date_bdc">
            <label for="date_recup_bdc">Date BDC & Factures à récupérer</label>
            <input type="date" id="date_recup_bdc" style="border-radius: 5px;" placeholder="Date BDC à récupérer" />

            <button disabled type="button" class="btn btn-success" style="text-align: center;margin-left: 10px;"
                id="btn_alimenter_suivi_ventes_bdc"><span>Recup BDC</span> </button>


        </div>


        <?php

        saut_de_ligne();

        ?>

        <div id="loader" style="display:none;">Chargement...</div>

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