<header class="header">
    <div class="header__container">
        <img src="../../assets/img/massoutre_header.jpg" alt="" class="header__img">

        <? if (isset($_SESSION['user_id'])) {
        } ?>

        <span class="header__logo" id="logo_connected">
            <?php
            echo isset($_SESSION['user_id']) ? $_SESSION['prenom'] . " " . $_SESSION['nom'] . " (" . $_SESSION['role_libelle'] . ")" : "";
            ?>


        </span>

        <?php

        if (isset($_SESSION['user_id'])) { ?>

            <div class="header__search">
                <input type="search" placeholder="Search" class="header__input">
                <i class='bx bx-search header__icon'></i>
            </div>

        <?php } ?>

        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
    </div>
</header>