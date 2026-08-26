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

    include "include.php";
    include "header.php";

    // NAV
    include "right_menubar.php";
    ;
    $check_role = requireRole([2, 3, 6]);

    if ($check_role) {
        echo "OK";
    } else {
        echo "PAS OK";
    }
    ?>





    <!--========== CONTENTS ==========-->
    <main>


        parametres

    </main>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>
</body>

</html>