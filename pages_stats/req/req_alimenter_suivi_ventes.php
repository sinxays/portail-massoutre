<?php

include "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 0);


if (isset($_POST['date']) && $_POST['date'] !== '') {
    $date = $_POST['date'];

    // $date = "2024-06-27";
    update_bdc_canceled($date);
    update_factures_canceled($date);
    alimenter_suivi_ventes_bdc_via_portail($date);
    alimenter_suivi_ventes_factures_via_portail($date);
    // snapshot_suivi_ventes_pour_histo();

}

