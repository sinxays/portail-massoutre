<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!--========== CSS ==========-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">



    <title>Portail Massoutre - TRAQUEURS</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <img src="../../assets/img/perfil.jpg" alt="" class="header__img">

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
    <?php include "../../right_menubar.php";
    include "../../include.php"; ?>




    <!--============================== CONTENTS ==============================-->
    <main>

        <H2> LISTE TRAQUEURS MONTES </H2>

        <form class="my_form_shop_ext">

            <div class="div_filtre_shop_ext">

                <div id="div_shop_ext_1">
                    <div id="div_shop_ext_1_1">
                        <label for="immatriculation_input">Immatriculation</label>
                        <input type="text" class="form-control" id="immatriculation_input" placeholder="Immat">
                    </div>
                    <div id="div_shop_ext_1_2">
                        <label for="mva_input">MVA</label>
                        <input type="text" class="form-control" id="mva_input" placeholder="MVA">
                    </div>
                    <div id="div_shop_ext_1_2">
                        <label for="serialnumber_input">S/N</label>
                        <input type="text" class="form-control" id="serialnumber_input" placeholder="S/N">
                    </div>
                </div>
                <div id="div_shop_ext_2">
                    <div id="div_shop_ext_2_1">

                        <button type="button" class="btn btn-success" id="btn_ajout_traqueurs">
                            <a href="liste_traqueurs.php" style="color: white;">Liste traqueurs</a> </button>
                    </div>
                </div>

            </div>


        </form>


        <br />
        <div class="elements_row">
            <div class="lds-ellipsis" id="loader" style="display:none;">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div> <br />

        <span id="table_traqueurs"></span>

        <br />
        <br />


    </main>





    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/traqueurs.js"></script>

</body>

</html>