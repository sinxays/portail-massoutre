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
        // $filtre_date = $_GET['filtre_date'];
        $filtre_date = $_GET['filtre_date'];

        $header = get_header_details($cvo, $destination_vente, $type_provenance, $type);

        saut_de_ligne();

        echo "<span>" . $header['nom_cvo'] . " | Type : " . $header['type'] . " | " . $header['destination_vente'] . " | Provenance : " . $header['type_provenance'] . "</span>";


        saut_de_ligne();

        $table = '';
        $table .= "<table class='my_tab_payplan' id='table_suivi_bdc_detail'>";
        $table .= "<tr>";
        $table .= "<th class='th1'>BDC / Immat / Facture</th>";
        $table .= "<th class='th1'>Marque</th>";
        $table .= "<th class='th1'>Modele</th>";
        $table .= "<th class='th1'>Categorie</th>";
        $table .= "<th class='th1'>Finition</th>";
        $table .= "<th class='th1'>Provenance</th>";
        $table .= "<th class='th1'>Date MEC</th>";
        $table .= "<th class='th1'>Immatriculation</th>";
        $table .= "<th class='th1'>Client</th>";
        $table .= "<th class='th1'>Montant</th>";
        $table .= "<th class='th1'>Durée Location (mois)</th>";
        $table .= "<th class='th1'>Durée Stock (jours)</th>";
        $table .= "<th class='th1'>Cout Detention / Marge</th>";
        $table .= "<th class='th1'>Vendeur</th>";
        $table .= "<th class='th1'>CVO</th>";
        $table .= "<th class='th1'>Date dernier BDC</th>";
        $table .= "<th class='th1'>Destination Vente</th>";
        $table .= "<th class='th1'>MVA</th>";
        $table .= "<th class='th1'>Reference Lot</th>";
        $table .= "<th class='th1'>Km Wizard</th>";
        $table .= "</tr>";

        switch ($type) {
            case 'bdc':
                $liste_detail = get_bdc_by_site_by_destination_vente($cvo, $destination_vente, $type_provenance, $filtre_date);

                foreach ($liste_detail as $nb => $bdc) {
                    $vh_infos = get_infos_vehicules_portail_bleu($bdc['immatriculation']);
                    $duree_location = get_duree_locations($bdc['immatriculation']);
                    $duree_stock = get_duree_stock($bdc['immatriculation'], $type);

                    $table .= "<tr>";
                    $table .= "<td>" . (isset($bdc['numero_bdc']) ? $bdc['numero_bdc'] : $bdc['immatriculation']) . "</td>";
                    $table .= "<td>" . $bdc['marque'] . "</td>";
                    $table .= "<td>" . $bdc['modele'] . "</td>";
                    $table .= "<td>" . $vh_infos['categorie'] . "</td>";
                    $table .= "<td>" . $vh_infos['finition'] . "</td>";
                    $table .= "<td>" . $vh_infos['provenance'] . "</td>";
                    $table .= "<td>" . $vh_infos['date_immatriculation'] . "</td>";
                    $table .= "<td>" . $bdc['immatriculation'] . "</td>";
                    $table .= "<td>" . $bdc['nom_acheteur'] . "</td>";
                    $table .= "<td>" . $bdc['prix_vente_ht'] . "</td>";
                    $table .= "<td> " . $duree_location . " </td>";
                    $table .= "<td> " . $duree_stock . " </td>";
                    $table .= "<td> marge </td>";
                    $table .= "<td>" . $bdc['nom_complet'] . "</td>";
                    $table .= "<td>" . $bdc['nom_cvo'] . "</td>";
                    $table .= "<td>" . $bdc['date_bdc'] . "</td>";
                    $table .= "<td>" . $bdc['destination_vente'] . "</td>";
                    $table .= "<td>" . $vh_infos['mva'] . "</td>";
                    $table .= "<td>" . $vh_infos['reference_lot'] . "</td>";
                    $table .= "<td>" . $vh_infos['km_wizard'] . "</td>";
                    $table .= "</tr>";

                }
                break;
            case 'facture':
                $liste_detail = get_factures_detail_by_site_by_destination_vente($cvo, $destination_vente, $type_provenance, $filtre_date);
                foreach ($liste_detail as $nb => $facture) {
                    $frais_vo = get_frais_vo_by_immat($facture['immatriculation']);

                    // echo $type_provenance;
                    // echo $destination_vente;
                    // var_dump($facture);
                    // echo $frais_vo;

                    // die();

                    $calcul_marge = calcul_marge($type_provenance, $destination_vente, $facture, $frais_vo);
                    $vh_infos = get_infos_vehicules_portail_bleu($facture['immatriculation']);
                    $duree_location = get_duree_locations($facture['immatriculation']);
                    $duree_stock = get_duree_stock($facture['immatriculation'], $type);

                    


                    $table .= "<tr>";
                    $table .= "<td>" . (isset($facture['numero_facture']) ? $facture['numero_facture'] . " (" . $facture['immatriculation'] . ")" : $facture['immatriculation']) . "</td>";
                    $table .= "<td>" . $facture['marque'] . "</td>";
                    $table .= "<td>" . $facture['modele'] . "</td>";
                    $table .= "<td>" . $vh_infos['categorie'] . "</td>";
                    $table .= "<td>" . $vh_infos['finition'] . "</td>";
                    $table .= "<td>" . $vh_infos['provenance'] . "</td>";
                    $table .= "<td>" . $vh_infos['date_immatriculation'] . "</td>";
                    $table .= "<td>" . $facture['immatriculation'] . "</td>";
                    $table .= "<td>" . $facture['nom_acheteur'] . "</td>";
                    $table .= "<td>" . $facture['prix_vente_vehicule_HT'] . "</td>";
                    $table .= "<td> " . $duree_location . " </td>";
                    $table .= "<td> " . $duree_stock . " </td>";
                    $table .= "<td class='bold_total_12'>" . $calcul_marge . "</td>";
                    $table .= "<td>" . $facture['nom_complet'] . "</td>";
                    $table .= "<td>" . $facture['nom_cvo'] . "</td>";
                    $table .= "<td>" . $facture['date_facture'] . "</td>";
                    $table .= "<td>" . $facture['destination_vente'] . "</td>";
                    $table .= "<td>" . $vh_infos['mva'] . "</td>";
                    $table .= "<td>" . $vh_infos['reference_lot'] . " </td>";
                    $table .= "<td>" . $vh_infos['km_wizard'] . " </td>";
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