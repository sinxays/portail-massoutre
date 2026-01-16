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



    <title>Portail Massoutre</title>
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



    <!--============================== ON RECUP LES DONNEES EN POST ET ON CREE LES TABLEAUX ==============================-->
    <?php

    $id_collaborateur = $_POST['id_collaborateur'];
    $collaborateur = get_nom_complet_collaborateur_by_id($id_collaborateur);


    $id_destination_vente = intval($_POST['destination_vente']);
    $libelle_destination_vente = get_libelle_destination_vente_from_id($id_destination_vente);

    if ($id_destination_vente == 0) {
        $libelle_destination_vente = "VENTES MARCHANDS & VENTES PARTICULIERS";
    }

    $type = $_POST['type'];

    $filtre_date = intval($_POST['filtre_date']);

    switch ($filtre_date) {
        case 0:
            $date = "du mois en cours";
            $date_array['value_selected'] = 0;
            break;
        case 1:
            $date = "du mois précédent";
            $date_array['value_selected'] = 1;
            break;
        case 2:
            $date_debut = format_date_US_TO_FR($_POST['date_debut']);
            $date_fin = format_date_US_TO_FR($_POST['date_fin']);
            $date = "du $date_debut au $date_fin";

            $date_array['value_selected'] = 2;
            $date_array['dates']['debut'] = $date_debut;
            $date_array['dates']['fin'] = $date_fin;

            break;
    }



    // $payplan_v2_garanties = get_grille_de_gestion_garanties($id_collaborateur, $date_array, $id_destination_vente);
    // $payplan_v2_packfirst = get_grille_de_gestion_packfirst($id_collaborateur, $date_array, $id_destination_vente);
    
    ?>


    <!--============================== CONTENTS ==============================-->
    <main>

        <H2> GRILLE DE GESTION <br> <?php echo $collaborateur ?> <br> <?php echo $date ?> <br>
            <?php echo $libelle_destination_vente ?></H2>

        </br>

        <div class="elements_in_row">
            <div id="btn_exporter">
                <!-- <a href="req/export.php"><i class='bx bxs-file-export bx-md'></i><span id='label_export'>Exporter</span></a> -->
                <i class='bx bxs-file-export bx-md'></i><span id='label_export'>Exporter</span>
            </div>

        </div>
        </br>
        <div class="elements_row">
            <div class="lds-ellipsis" id="loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>


        <span style="color: red;">
            <h2>
                <?php echo "$type" ?>
            </h2>
        </span>


        <!--  TABLEAU  -->
        <table class="my_tab_payplan">
            <?php

            switch ($type) {
                case 'bdc':
                    $detail_bdc_factures = get_grille_de_gestion_bdc_and_factures_detail_collaborateur($id_collaborateur, $date_array, $id_destination_vente);
                    $table = create_table_grille_de_gestion_detail_collaborateur($type, $detail_bdc_factures[0]);
                    break;
                case 'factures':
                    $detail_bdc_factures = get_grille_de_gestion_bdc_and_factures_detail_collaborateur($id_collaborateur, $date_array, $id_destination_vente);
                    $table = create_table_grille_de_gestion_detail_collaborateur($type, $detail_bdc_factures[1]);
                    break;
                case 'reprises':
                    $detail_reprises = get_grille_de_gestion_reprises_detail_collaborateur($id_collaborateur, $date_array);
                    $table = create_table_grille_de_gestion_detail_collaborateur($type, $detail_reprises);
                    break;
                case 'garanties':
                    $detail_garanties = get_grille_de_gestion_garanties_detail_collaborateurs($id_collaborateur, $date_array, $id_destination_vente);
                    $table = create_table_grille_de_gestion_detail_collaborateur($type, $detail_garanties);
                    break;
                case 'packfirst':
                    $detail_pack_first = get_grille_de_gestion_packfirst_detail_collaborateur($id_collaborateur, $date_array, $id_destination_vente);
                    $table = create_table_grille_de_gestion_detail_collaborateur($type, $detail_pack_first);
                    break;
            }

            echo $table;


            ?>
        </table>




        <?php
        saut_de_ligne();

        if (isset($_GET['id_collaborateur_payplan']) && $_GET['id_collaborateur_payplan'] !== '') {
            $id_collaborateur_detail = $_GET['id_collaborateur_payplan'];
            echo "<span id='span_id_collaborateur' style='visibility:hidden;'>$id_collaborateur_detail</span>";
        }

        ?>

    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/grille_de_gestion_detail_collaborateur.js"></script>
</body>

</html>