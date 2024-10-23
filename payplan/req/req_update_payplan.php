<?php

include "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 0);

//update MOIS
if (isset($_POST['mois_update']) && $_POST['mois_update'] !== '') {

    switch ($_POST['choix_update']) {
        //mois en cours
        case 0:
            $filtre['mois_en_cours'] = array();
            break;
        // mois précédent
        case 1:
            $filtre['mois_precedent'] = array();
            break;
    }
    $commission = get_commission($filtre);
    update_payplan($commission, $filtre);
}
//update par immatriculation
else if (isset($_POST['immat_update']) && $_POST['immat_update'] !== '') {
    update_payplan_by_immat($_POST['immat_update']);
}



//on vide la table avant
// truncate_before_update();

//dates personnalisées
// $filtre['date_personnalisee']['debut'] = "2023-05-01";
// $filtre['date_personnalisee']['fin'] = "2023-05-31";



$table = create_table_commission($commission_table_header_row, $commission);
echo $table;
