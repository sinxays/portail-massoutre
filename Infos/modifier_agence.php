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



    if ($_POST["id_agence_modifier"] !== "") {
        $id_agence = $_POST["id_agence_modifier"];
        // var_dump($id_agence);


        $agence = get_agence_by_id($id_agence);
        $chef_agence = get_chef_agence_by_agence_id($id_agence);
        $agence = $agence[0];


        $ville = $agence["ville"];
        $cp = $agence["cp"];
        $adresse = $agence["adresse"];
        $numero_agence = $agence["num_tel_agence"];
        $mail_agence = $agence["mail_agence"];
        $code_vp = $agence["code_vp"];
        $code_vu = $agence["code_vu"];
        $code_gare = $agence["code_gare"];
        $url_map = $agence["google_map"];
    }

    ?>

    <div id="container_body_modif_agence">
        </br>
        <div id="column_gauche_mofig_agence">
            <div id="div_localisation">
                <div id="titre_localisation">Localisations</div>
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
                    <div id="collaborateurs_locations">
                        <div id="collaborateurs_locations_chef_agence">
                            <h4>chef d'agence</h4>
                            <span><?php echo $chef_agence["prenom"] . " " .  $chef_agence["nom"]; ?></span>
                            <!-- <a href="mailto:sinxay.souvannavong@gmail.com?subject=test&body=Test message"> -->
                            <a href="mailto:<?php echo $chef_agence["adresse_mail"] . "?subject=contact via portail"; ?>">
                                <span style="font-size: x-small;"><?php echo $chef_agence["adresse_mail"]; ?></span>
                            </a>
                        </div>
                        <div id="collaborateurs_locations_agents">
                            <ul style="list-style: none;padding:0 ;">
                                <li>Thomas pecand</li>
                                <li>Alexis Drozirodri</li>
                                <li>Maxime Gerard</li>
                            </ul>
                        </div>
                    </div>
                    <div id="collaborateurs_commercial">
                        <h5>Lease & Go</h5>
                        <span>Marine Prevost</span>
                        <a href="mailto:sinxay.souvannavong@gmail.com?subject=test&body=Test message">
                            <span style="font-size: x-small;">marine.prevost@massoutre-locations.com</span>
                        </a>
                    </div>
                    <!-- <div id="collaborateurs_cvo">
                        <h5>Les Grandes Occasions</h5>
                        <ul style="list-style: none;padding:0 ;">
                            <li>Thomas pecand</li>
                            <li></li>
                            <li>Alexis Drozirodri</li>
                            <li></li>
                            <li>Maxime Gerard</li>
                            <li></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
        <div id="column_droite_mofig_agence">
            <div id="contact_contenu">
                <div id="contact_titre">Contact</div>
                <div id="contact_numero">
                    <p>Numero Agence</p>
                    <span><?php echo $numero_agence ?></span>
                </div>
                <div id="contact_email">
                    <p>Email Agence</p>
                    <a href="mailto:sinxay.souvannavong@gmail.com?subject=test&body=Test message">
                        <span style="font-size:large;"><?php echo $mail_agence ?></span>
                    </a>
                </div>
            </div>
            <div id="div_code_agence">
                <div id="titre_code_agence">CODE AGENCE</div>
                <div id="contenu_code_agence">
                    <div id="code_vp">
                        <h6>code VP</h6>
                        <span><?php echo $code_vp ?></span>
                    </div>
                    <div id="code_vu">
                        <h6>code VU</h6>
                        <span><?php echo $code_vu ?></span>
                    </div>
                    <div id="code_gare">
                        <h6>code GARE</h6>
                        <span><?php echo $code_gare ?></span>
                    </div>
                </div>


            </div>
        </div>
    </div>