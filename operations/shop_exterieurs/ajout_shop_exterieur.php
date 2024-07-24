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
    <link rel="stylesheet" href="../../assets/css/styles.css">



    <title>Portail Massoutre - ajout Shop Ext</title>
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
        <br />
        <br />

        <H2> AJOUT SHOP EXTERIEUR </H2>

        <br />

        <div id="div_retour_detail_collaborateur">
            <i class='bx bx-left-arrow-circle bx-md'></i><span>Retour</span>
        </div>

        <form id="ajout_shop_exterieur_form">

            <div class="container_form_ajout_shop_ext">

                <div class="ajout_shop_categorie">

                    <div class="div_form_vh_label"><span>Vehicule</span></div>
                    <div class="div_form_vh_row">
                        <input type="text" class="form-control" id="input_immat" placeholder="Immatriculation"
                            name="immatriculation" style="width: 200px;">
                        <input type="text" class="form-control" id="input_mva" placeholder="MVA" name="mva"
                            style="width: 150px;">
                        <input type="text" class="form-control" id="input_km" placeholder="Kilométrage" name="km"
                            style="width: 150px;">
                    </div>
                    <div class="div_form_vh_row">
                        <input type="text" class="form-control" id="input_modele" placeholder="Modèle" name="modele"
                            style="width: 370px;">
                        <div class="radio-group">
                            <span>Garantie : </span>
                            <label>
                                <input type="radio" name="garantie" value="1"> Oui
                            </label>
                            <label>
                                <input type="radio" name="garantie" value="0"> Non
                            </label>
                        </div>
                    </div>
                    <div class="div_form_vh_row">
                        <input type="text" class="form-control" id="input_contrat" placeholder="Numéro de contrat"
                            name="num_contrat" style="width: 200px;">
                    </div>
                </div>

                <div class="ajout_shop_categorie">

                    <div class="div_form_vh_label"><span>Panne</span></div>

                    <div class="div_form_vh_column">
                        <div class="form-group">
                            <label for="dateInput">Date Déclaration:</label>
                            <input type="date" class="form-control" id="dateInput" name="date_declaration"
                                style="width: 200px;">
                        </div>

                        <label for="select_type_panne">Type panne:</label>
                        <select class="form-select" style="width : 200px;" id="select_type_panne" name="type_panne">

                            <?php
                            $list_type_panne_libelle = get_list_type_panne_libelle();
                            foreach ($list_type_panne_libelle as $type_panne) {
                                $libelle_id = $type_panne['ID'];
                                $libelle = $type_panne['type_panne_libelle'];
                                echo "<option value='$libelle_id'> $libelle </option>";
                            }
                            ?>
                        </select>

                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Detail(s) de la panne"
                                id="textarea_detail_panne"></textarea>
                            <label for="textarea_detail_panne">Detail(s) de la panne</label>
                        </div>

                        <input type="text" class="form-control" id="input_localisation" placeholder="Localisation"
                            name="localisation" style="width: 350px;">
                    </div>

                </div>
                <div class="div_validation_ajout">
                    <button type="button" class="btn btn-success" id="btn_ajout_shop_ext">Ajouter</button>
                    <div class="lds-ellipsis" id="loader" style="display:none;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>

            </div>


            </br>

            <div class="alert alert-success" role="alert" id="alert_shop_ext_added" style="display:none;">
                Shop Ext ajouté
            </div>
            <div class="alert alert-danger" role="alert" id="alert_shop_ext_addded_fail" style="display:none;">
                Shop Ext non ajouté
            </div>

        </form>

    </main>



    <!--========== MAIN JS ==========-->

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/shop_exterieurs_ajout_vh.js"></script>
</body>

</html>