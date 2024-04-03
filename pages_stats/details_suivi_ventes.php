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



    <title>Portail Massoutre - Suivi ventes </title>
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

        <H2> SUIVI VENTES DETAIL </H2>

        <?php

        $cvo = $_GET['cvo'];
        $destination_vente = $_GET['destination_vente'];
        $type_provenance = $_GET['type_provenance'];
        $type = $_GET['type'];

        $table = '';
        $table .= "<table class='my_tab_payplan' id='table_suivi_bdc_detail'>";
        $table .= "<tr>";
        $table .= "<th class='th1'>BDC / Immat / Facture</th>";
        $table .= "<th class='th1'>Nom vendeur</th>";
        $table .= "<th class='th1'>Date</th>";
        $table .= "</tr>";

        switch ($type) {
            case 'bdc':
                $liste_detail = get_bdc_by_site_by_destination_vente($cvo, $destination_vente, $type_provenance);
                foreach ($liste_detail as $nb => $bdc) {
                    $table .= "<tr>";
                    $table .= "<td>" . (isset($bdc['numero_bdc']) ? $bdc['numero_bdc'] : $bdc['immatriculation']) . "</td>";
                    $table .= "<td>" . $bdc['nom_complet'] . "</td>";
                    $table .= "<td>" . $bdc['date'] . "</td>";
                    $table .= "</tr>";

                }
                break;
            case 'facture':
                $liste_detail = get_factures_by_site_by_destination_vente($cvo, $destination_vente, $type_provenance);
                foreach ($liste_detail as $nb => $bdc) {
                    $table .= "<tr>";
                    $table .= "<td>" . (isset($bdc['numero_facture']) ? $bdc['numero_facture'] : $bdc['immatriculation']) . "</td>";
                    $table .= "<td>" . $bdc['nom_complet'] . "</td>";
                    $table .= "<td>" . $bdc['date'] . "</td>";
                    $table .= "</tr>";

                }
                break;
        }


        $table .= "</table>";

        echo $table;

        ?>



        <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/suivi_ventes_details.js"></script>
</body>

</html>