<?php

include  "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_POST['choix_update']) && $_POST['choix_update'] !== '') {

    switch ($_POST['choix_update']) {
            //mois en cours
        case 0:
            $filtre = '';
            break;
            // mois précédent
        case 1:
            $filtre['mois_precedent'] = array();
            break;
    }
}

//on vide la table avant
// truncate_before_update();

//dates personnalisées
// $filtre['date_personnalisee']['debut'] = "2022-04-01";
// $filtre['date_personnalisee']['fin'] = "2022-12-31";


$commission = get_commission($filtre);
define_payplan($commission);

update_payplan();

// update_repreneur_final();

$table = create_table_commission($commission_table_header_row, $commission);

echo $table;
