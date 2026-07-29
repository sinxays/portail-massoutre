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

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>



<title>test</title>
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

    <div id="div_test">
        <?php

        include "right_menubar.php";
        include "include.php";

        use app\Connection;

        ini_set('max_execution_time', 0);

        /****** UPDATE ALL ******/
        // update_vh_bdc_OS();
        // update_vh_factures_OS();
        // update_vh_invoice();
        // update_bdc_invoice();
        
        // delete_factures_restant();
        

        // update_vh_invoice();
        

        // update_payplan_by_immat("FM173XN");
        
        // $date = date('2025-12-23');
        // update_factures_canceled($date);
        
        $pdo = Connection::getPDO();
        $pdo_intranet = Connection::getPDO_2();


        $test = "07/12/2019";

        $test2 = format_date_FR_TO_US($test);

        var_dump($test2);


        //on va chercher le véhicule lié si il existe
        $request = $pdo->query("SELECT ID FROM suivi_lag_code_alertes
                WHERE code_alerte = 9");
        $id_code_alerte = $request->fetch(PDO::FETCH_COLUMN);

        

        //on va chercher le véhicule lié si il existe
        $request = $pdo->query("SELECT vh_alerte.ID FROM suivi_lag_vehicules_alertes as vh_alerte
                LEFT JOIN suivi_lag_vehicules as vh ON vh.ID = vh_alerte.id_vehicule
                WHERE vh.immatriculation = 'GC443KA' and vh_alerte.id_code_alerte = $id_code_alerte");
        $result = $request->fetch(PDO::FETCH_COLUMN);

        var_dump($result);



        ?>

    </div>

    <br />
    <br />
    <br />


</body>

</html>