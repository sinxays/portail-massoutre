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




    <?php

    // $id_collaborateur = $_POST['id_collaborateur'];
    // $collaborateur = get_nom_complet_collaborateur_by_id($id_collaborateur);
    $collaborateur = "Sinxay Souvannavong";

    // $date = $_POST['date'];
    $date = "2025-12-01 au 2025-12-25";


    ?>





    <!--============================== CONTENTS ==============================-->
    <main>

        <H2> GRILLE DE GESTION <br> <?php echo $collaborateur ?> <br> du <?php echo $date ?></H2>

        </br>

        <div id="div_retour_detail_collaborateur">
            <i class='bx bx-left-arrow-circle bx-md'></i><span>Retour</span>
        </div>

        <div class="elements_in_row">
            <div id="btn_exporter">
                <!-- <a href="req/export.php"><i class='bx bxs-file-export bx-md'></i><span id='label_export'>Exporter</span></a> -->
                <i class='bx bxs-file-export bx-md'></i><span id='label_export'>Exporter</span>
            </div>

        </div>



        </br>


        <span id="titre_table"></span>

        <table class="my_tab_payplan" id="table_payplan_detail_collaborateur"> </table>


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
    <script src="/assets/js/payplan_detail_collaborateur.js"></script>
</body>

</html>