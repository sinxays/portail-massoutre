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



    <title>Portail Massoutre - Agences</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <header class="header">
        <div class="header__container">
            <strong>test</strong>
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
    <?php include "../right_menubar.php";
    include "../include.php";



    if ($_POST["id_cvo_modifier"] !== "") {
        $id_cvo = $_POST["id_cvo_modifier"];
        // var_dump($id_agence);


        $cvo = get_cvo_by_id($id_cvo);
        $vendeurs = get_vendeurs_by_cvo_id($id_cvo);

        $ville = $cvo["ville"];
        $cp = $cvo["cp"];
        $adresse = $cvo["adresse"];
        $numero_cvo = $cvo["numero_cvo"];
        $mail_cvo = $cvo["mail_cvo"];
        $url_map = $cvo["google_map"];
    }

    ?>

    <div id="container_body_modif_agence">
        </br>
        <div id="column_gauche_mofig_agence">
            <div id="div_localisation">
                <div id="titre_localisation">Localisation</div>
                <div id="contenu_localisation">
                    <div id="div_localisation_gauche">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input_ville" style="font-weight: bold;">Ville</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Ville" aria-label="ville" aria-describedby="input_ville" value="<?php echo $ville ?>" readonly>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input_cp" style="font-weight: bold;">CP</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Ville" aria-label="ville" aria-describedby="input_cp" value="<?php echo $cp ?>" readonly>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input_adresse" style="font-weight: bold;">Adresse</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Ville" aria-label="ville" aria-describedby="input_adresse" value="<?php echo $adresse ?>" readonly>
                        </div>
                    </div>
                    <div id="div_localisation_droite">
                        <iframe src="<?php echo $url_map; ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <div id="div_collaborateurs">
                <div id="collaborateurs_titre">Collaborateurs</div>
                <div id="collaborateurs_contenu">
                    <h5>Les Grandes Occasions</h5>
                    <ul style="list-style: none;padding:0 ;">

                        <?php

                        foreach ($vendeurs as $vendeur) {
                            echo " <li style='text-align:center'>" . $vendeur["prenom"] . " " . $vendeur["nom"] . "</li>";
                            echo '<a href="mailto:' . $vendeur["mail_vendeur"] . '?subject=contact">';
                            echo "<li> " . $vendeur["mail_vendeur"] . "</li> ";
                            echo "</a>";
                            echo "<br/>";
                        }



                        ?>
                        <!-- <li>Thomas pecand</li>
                        <li></li>
                        <br />
                        <li>Alexis Drozirodri</li>
                        <li></li>
                        <br />
                        <li>Maxime Gerard</li>
                        <li></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div id="column_droite_mofig_agence">
            <div id="contact_contenu">
                <div id="contact_titre">Contact</div>
                <div id="contact_numero">
                    <p>Numero CVO</p>
                    <span><?php echo $numero_cvo ?></span>
                </div>
                <div id="contact_email">
                    <p>Email CVO</p>
                    <a href="mailto:sinxay.souvannavong@gmail.com?subject=test&body=Test message">
                        <span style="font-size:large;"><?php echo $mail_cvo ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>