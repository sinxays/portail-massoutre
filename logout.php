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

    session_start();
    // Vider toutes les variables de session
    $_SESSION = [];

    session_destroy();

    include "include.php";

    include "header.php";
    // NAV  
    include "right_menubar.php";

    // Retour à la page de connexion
    header('Location: login.php');
    exit;

    ?>


    <!--========== CONTENTS ==========-->
    <main>

        Vous etes correctement déconnecté

    </main>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>
</body>

</html>