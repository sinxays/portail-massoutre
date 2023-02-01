<?php

include  "../../include.php";

$filtre = array();

/*** FILTRE DATE  ***/
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];
    switch ($selected_date) {
        case '1':
            $filtre['mois_precedent_payplan'] = array();
            break;
    }
}
if (isset($_POST['date_perso'])) {
    $filtre['date_personnalisee'] = $_POST['date_perso'];
}


$payplan = get_payplan($filtre);
// var_dump($payplan);
$table = create_table_payplan($payplan, $payplan_table_header_row);
echo $table;
