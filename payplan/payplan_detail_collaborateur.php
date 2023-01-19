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

        <H2> PAYPLAN DETAIL </H2>

        <form class="my_form_payplan" style="display:none">
            <?php
            ini_set('xdebug.var_display_max_depth', 99);
            ?>
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


        <span id="titre_table"></span>

        <table class="my_tab_payplan" id="table_payplan_detail_collaborateur">  </table>


        <?php
        saut_de_ligne();

        if (isset($_GET['id_collaborateur_payplan']) && $_GET['id_collaborateur_payplan'] !== '') {
            $id_collaborateur_detail = $_GET['id_collaborateur_payplan'];
            echo "<span id='span_id_collaborateur' style='visibility:hidden;'>$id_collaborateur_detail</span>";
        }

        // $payplan = get_payplan();
        // var_dump($payplan);

        ?>



        <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/payplan_detail_collaborateur.js"></script>
</body>

</html>