<?php

include "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 0);


if (isset($_POST['date']) && $_POST['date'] !== '') {
    $date = $_POST['date'];

    alimenter_suivi_ventes_bdc($date);
    alimenter_suivi_ventes_factures($date);

}

