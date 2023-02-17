<?php

include  "../../include.php";

$filtre = array();

/*** FILTRE DATE  ***/
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];
    switch ($selected_date) {
        case '0':
            $filtre['mois_en_cours'] = array();
            break;
        case '1':
            $filtre['mois_precedent'] = array();
            break;
    }
}
if (isset($_POST['date_perso'])) {
    $filtre['date_personnalisee'] = $_POST['date_perso'];
}

$commission = get_commission($filtre);
$table = create_table_commission($commission_table_header_row, $commission);
echo $table;
