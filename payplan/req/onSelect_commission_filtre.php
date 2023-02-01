<?php

include  "../../include.php";

/*** FILTRE DATE  ***/
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];
    switch ($selected_date) {
        case '1':
            $filtre['mois_precedent_commision'] = array();
            break;
    }
}


$commission = get_commission($filtre);
$table = create_table_commission($commission_table_header_row, $commission);
echo $table;
