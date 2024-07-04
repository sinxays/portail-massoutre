<?php

include "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 0);


if (isset($_POST['date']) && $_POST['date'] !== '') {
    $date = $_POST['date'];

    // $date = "'2023-09-01' AND '2023-12-31'";
    // alimenter_suivi_ventes_bdc($date);
    // alimenter_suivi_ventes_factures($date);
    // update_bdc_annule($date);
    // update_factures_annule($date);
    alimenter_suivi_ventes_bdc_via_portail($date);
    alimenter_suivi_ventes_factures_via_portail($date);
    // snapshot_suivi_ventes_pour_histo();

}

