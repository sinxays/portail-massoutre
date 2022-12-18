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

$payplan = get_payplan($filtre);
$table = create_table_payplan($payplan_table_header_row, $payplan);
echo $table;
