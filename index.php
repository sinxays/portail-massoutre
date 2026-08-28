<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Portail Massoutre</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <?php
    include "include.php";

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }


    include "header.php";

    // NAV  
    // include "right_menubar.php";
    include "menu_final.php";
    ?>



    <!--========== CONTENTS ==========-->
    <main>

        <div id="accueil_div">


            <?php

            echo "PAGE D'ACCUEIL";

            echo "<br/>";

            // echo password_hash("roseMorais",PASSWORD_DEFAULT);


            ?>

        </div>
        <!-- amener un date placeholder -->

    </main>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>
</body>

</html>