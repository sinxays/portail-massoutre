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
                                echo "<i class=" . $section['icon'] . " nav__icon'></i>";
                                echo "<span class='nav__name'>" . $section['libelle_bouton'] . "</span>";
                                echo "</a>";
                                break;



                            case 'dropdown_bouton':
                                echo "<div class='nav__dropdown'>";
                                echo "<a href='#' class='nav__link'>";
                                if (isset($section['icon_logo'])) {
                                    echo "<img class='img_nav' src='" . $section['icon_logo'] . "'/>";
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


                </div>
                <div id="menu_2">

                    <?php
                    foreach ($menu_bottom as $section) {

                        echo "<a href='" . $section['url'] . "' class='nav__link'>";
                        echo "<i class=" . $section['icon'] . " nav__icon'></i>";
                        echo "<span class='nav__name'>" . $section['libelle_bouton'] . "</span>";
                        echo "</a>";


                    }


                    ?>



                </div>

    </nav>
</div>