<?php

include  "../../include.php";

/*** filtre destination ***/

// si on choisit negoce ou locations
if ($_POST["destination"]) {
    $destination_id = intval($_POST["destination"]);
    $filtre['destination'] = $destination_id;
}
// si on choisit tout
else {
    $filtre = '';
}

$payplan = get_payplan($filtre);
$table = create_table_payplan($payplan_table_header_row, $payplan);
echo $table;
