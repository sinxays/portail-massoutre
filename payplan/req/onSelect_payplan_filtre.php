<?php

include  "../../include.php";

$filtre = array();

/*** FILTRE DATE  ***/
if (isset($_POST['selected_date'])) {
    $selected_date = intval($_POST['selected_date']);
    switch ($selected_date) {
            //mois en cours
        case 0:
            $filtre['mois_en_cours'] = array();
            break;
            //mois précedent
        case 1:
            $filtre['mois_precedent'] = array();
            break;
    }
}
if (isset($_POST['date_perso'])) {
    $filtre['date_personnalisee'] = $_POST['date_perso'];
}


$payplan = get_payplan_date_facturation($filtre);
// var_dump($payplan);
$table = create_table_payplan($payplan, $payplan_table_header_row);
echo $table;
