<?php

include  "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

//on vide la table avant
truncate_before_update();


$filtre['mois_precedent_commision'] = array();

$commission = get_commission();
define_payplan_final($commission);
$table = create_table_commission($commission_table_header_row, $commission);

echo $table;
