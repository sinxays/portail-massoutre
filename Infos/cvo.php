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
    <link rel="stylesheet" href="../assets/css/styles.css">



    <title>Portail Massoutre - CVO</title>
</head>

<body>
    <!--========== HEADER ==========-->
    <?php
    include "../include.php";

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }


    include "../header.php";

    include "../menu_final.php";
    ?>




    <!--============================== CONTENTS ==============================-->
    <main>

        <H2> CVO </H2>

        </br>

        <table class="my_tab_perso" id="table_cvo_infos"> </table>

        <form id="modifier_cvo_form" method="POST" action="modifier_cvo.php">
            <input type="hidden" id="id_cvo_modifier" name="id_cvo_modifier" />
        </form>

        <span id="requete"></span>

        <br />

        </br>
    </main>



    <!--========== MAIN JS ==========-->

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/infos_cvo.js"></script>
</body>

</html>