<?php

//echo __DIR__ . "../../include.php";

include __DIR__ . "/../../include.php";



error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 0);

$date = date('Y-m-d', strtotime('-1 day'));

update_bdc_canceled($date);
update_factures_canceled($date);
alimenter_suivi_ventes_bdc_via_portail($date);
alimenter_suivi_ventes_factures_via_portail($date);


