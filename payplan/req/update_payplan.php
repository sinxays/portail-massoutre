<?php

include  "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

//on vide la table avant
// truncate_before_update();

//dates personnalisées
$filtre['date_personnalisee']['debut'] = "2023-02-01";
$filtre['date_personnalisee']['fin'] = "2023-01-28";

// mois précédent
// $filtre['mois_precedent'] = array();

//mois en cours
$filtre = '';


$commission = get_commission($filtre);
define_payplan($commission);

update_payplan();

// update_repreneur_final();





$table = create_table_commission($commission_table_header_row, $commission);

echo $table;
