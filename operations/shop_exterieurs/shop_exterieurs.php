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



    <title>Portail Massoutre - Shop Exterieurs</title>
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

        <H2> SHOP EXTERIEURS </H2>

        <form class="my_form_shop_ext">

            <div id="div_shop_ext_1">
                <div id="div_shop_ext_1_1">
                    <label for="immatriculation_input">Immatriculation</label>
                    <input type="text" class="form-control" id="immatriculation_input"
                        placeholder="Entrer immatriculation">
                </div>
                <div id="div_shop_ext_1_2">
                    <label for="mva_input">MVA</label>
                    <input type="text" class="form-control" id="mva_input" placeholder="Entrer MVA">

                </div>
                <div id="div_shop_ext_1_3">
                    <label for="categories">Categories</label>
                    <select class="form-select" id="categories" style="width: 150px;" name="select_categories">
                        <?php
                        $list_categories = get_shop_ext_categories();
                        echo "<option value='0'> </option>";
                        foreach ($list_categories as $categorie) {
                            echo "<option value='" . $categorie['ID'] . "'>" . $categorie['libelle'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="div_shop_ext_2">
                <div id="div_shop_ext_2_1">
                    <button type="button" class="btn btn-success" id="btn_creer_shop_ext">Ajout Shop Ext</button>
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

        <span id="table_shop_exterieur"></span>

        <br /> <br />



        <!-- amener un date placeholder -->

    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/shop_exterieurs.js"></script>

</body>

</html>