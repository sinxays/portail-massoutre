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



    <title>Portail Massoutre - test</title>
</head>

<body>

    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <strong>page de test</strong>
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
    <?php

    include "right_menubar.php";
    include "include.php";

    ini_set('max_execution_time', 0);




    // $filtre['mois_precedent'] = array();
    $filtre['date_personnalisee']['debut'] = "2016-01-01";
    $filtre['date_personnalisee']['fin'] = "2023-08-31";


    /*
    // On commence par récupérer des vh dans le cas ou la date de facturation a changé ( une refacturation )
    $datas_facturation = get_facturation($filtre);
    foreach ($datas_facturation as $facturation) {
        update_date_facturation_by_immat($facturation['immatriculation'], $facturation['date_facturation']);
        $immatriculation = update_pack_first_by_immatriculation($facturation['immatriculation']);
        echo $immatriculation;
    }
    */

    // $datas_payplan_achat = get_payplan_date_stock($filtre);
    // foreach ($datas_payplan_achat as $vie_vh) {
    //     update_type_achat_by_immat($vie_vh['immatriculation']);
    // }

    //update payplan pay un immat
    $vh_immat = 'EX719MK';
    update_payplan_by_immat($vh_immat);
    

    


    // $test = get_pack_first_from_payplan($filtre);
    // foreach ($test as $test_) {
    //     echo $test_['immatriculation'] . "<br/>";
    // }















    // get_reprise_achat_pack_collaborateurs();





    ?>