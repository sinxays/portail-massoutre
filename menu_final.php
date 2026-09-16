<?php require_once 'menu.php'; ?>

<div class="nav" id="navbar">
    <nav class="nav__container">
        <div id="menu_1">
            <a href="#" class="nav__link nav__logo">
                <i class='bx bxs-disc nav__icon'></i>
                <span class="nav__logo-name">Massoutre</span>
            </a>
            <!-- <h3 class="nav__subtitle">Profile</h3>
            </br>
            <div class="nav__dropdown">
                <a href="#" class="nav__link">
                    <i class='bx bx-user nav__icon'></i>
                    <span class="nav__name">Profile</span>
                    <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                </a>

                <div class="nav__dropdown-collapse">
                    <div class="nav__dropdown-content">
                        <a href="#" class="nav__dropdown-item">Passwords</a>
                        <a href="#" class="nav__dropdown-item">Mail</a>
                        <a href="#" class="nav__dropdown-item">Accounts</a>
                    </div>
                </div>
            </div> -->


            <?php if (isset($_SESSION['user_id'])) { ?>

                <div class="nav__list">
                    <div class="nav__items">
                        <h3 class="nav__subtitle">Menu</h3>

                        <?php foreach ($menu_principal as $section) {

                            if (!hasRole($section['roles'])) {
                                continue;
                            }


                            switch ($section['type_bouton_menu']) {

                                case 'simple_bouton':
                                    echo "<a href='" . $section['url'] . "' class='nav__link'>";
                                    echo "<i class='" . $section['icon'] . "'></i>";
                                    echo "<span class='nav__name'>" . $section['libelle_bouton'] . "</span>";
                                    echo "</a>";
                                    break;



                                case 'dropdown_bouton':
                                    echo "<div class='nav__dropdown'>";
                                    echo "<a href='#' class='nav__link'>";
                                    if (isset($section['icon_logo'])) {
                                        echo "<img class='img_nav' src='" . $section['icon_logo'] . "'/>";
                                    } elseif (isset($section['logos'])) {
                                        foreach ($section['logos'] as $item_logo) {
                                            echo "<img class='" . $item_logo['class'] . "' src='" . $item_logo['src'] . "'/>";
                                        }
                                    } else {
                                        echo "<i class='" . $section['icon'] . "'></i>";
                                    }
                                    echo "<span class='nav__name' style='padding-left:10px;padding-top:2px;'>" . ($section['libelle_bouton'] !== '' ? $section['libelle_bouton'] : '') . "</span>";

                                    echo "<i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>";
                                    echo "</a>";

                                    echo "<div class='nav__dropdown-collapse'>";
                                    echo "<div class='nav__dropdown-content'>";
                                    foreach ($section['items'] as $item) {
                                        echo "<a href='" . $item['url'] . "' class='nav__dropdown-item'>" . $item['name'] . "</a>";
                                    }
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    break;

                                default:
                                    # code...
                                    break;
                            }







                        } ?>


                        <?php if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 1) { ?>


                            <div class="nav__items">
                                <h3 class="nav__subtitle">Utile</h3>
                                <div class="nav__dropdown">
                                    <a href="#" class="nav__link" id="menu_infos">
                                        <i class='bx bx-info-circle'></i>
                                        <span class="nav__name">Infos</span>
                                        <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                                    </a>
                                    <div class="nav__dropdown-collapse">
                                        <div class="nav__dropdown-content">
                                            <a href="/Infos/agences.php" class="nav__dropdown-item"
                                                id="menu_infos_agence">Agences
                                                Locations</a>
                                            <a href="/Infos/cvo.php" class="nav__dropdown-item" id="menu_infos_cvo">CVO</a>
                                        </div>
                                    </div>
                                </div>

                                <a href="/Liste_telephonique/liste_telephonique.php" class="nav__link"
                                    id="menu_liste_telephnique">
                                    <i class='bx bxs-phone'></i>
                                    <span class="nav__name">Liste Téléphonique</span>
                                </a>
                            </div>


                        <?php } ?>

                    </div>
                </div>
            </div>
            <div id="menu_2">

                <?php
                foreach ($menu_bottom as $section) {

                    if (!hasRole($section['roles'])) {
                        continue;
                    }

                    echo "<a href='" . $section['url'] . "' class='nav__link " . $section['class'] . "'>";
                    echo "<i class='" . $section['icon'] . " nav__icon'></i>";
                    echo "<span class='nav__name'>" . $section['libelle_bouton'] . "</span>";
                    echo "</a>";
                    echo '<br />';


                }


                ?>



            </div>
        <?php } else { ?>

            <div id="menu_2">
                <a href="/login.php" class="nav__link nav__logout">
                    <i class='bx bx-log-in nav__icon'></i>
                    <span class="nav__name">LOGIN</span>
                </a>
            </div>


        <?php } ?>

    </nav>

</div>