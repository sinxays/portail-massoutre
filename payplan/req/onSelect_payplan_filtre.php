<?php

include  "../../include.php";

/*** filtre destination ***/

// si on choisit negoce ou locations
if (isset($_POST["destination"])) {
    if ($_POST["destination"] !== '0') {
        $destination_id = intval($_POST["destination"]);
        $filtre['destination'] = $destination_id;
    }
    // si on choisit tout
    else {
        $filtre = '';
    }
}


/*** filtre achat ***/
if (isset($_POST['type_achat'])) {
    if ($_POST['type_achat'] !== '0') {
        $type_achat_id = intval($_POST["type_achat"]);
        $filtre['type_achat'] = $type_achat_id;
    }
    // si on choisit tout
    else {
        $filtre = '';
    }
}

/*** filtre date mois précédent ***/
if (isset($_POST['mois_precedent_payplan'])) {
        $filtre['mois_precedent_payplan'] = $_POST['mois_precedent_payplan'];
        $filtre['tableau_selected'] = $_POST['tableau_selected'];
}

$payplan = get_payplan($filtre);
$table = create_table_payplan($payplan_table_header_row, $payplan);
echo $table;
