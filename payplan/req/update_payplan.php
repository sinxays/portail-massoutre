<?php

include  "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

//on vide la table avant
// truncate_before_update();


// mois précédent
$filtre['mois_precedent'] = array();
$commission = get_commission($filtre);
define_payplan_final($commission);


//mois en cours
// $filtre = '';
// $commission = get_commission($filtre);
// define_payplan_final($commission);

$table = create_table_commission($commission_table_header_row, $commission);

echo $table;
