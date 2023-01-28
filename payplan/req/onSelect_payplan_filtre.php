<?php

include  "../../include.php";

/*** FILTRE DESTINATION ***/

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

/*** FILTRE ACHAT ***/
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

/*** FILTRE DATE MOIS PRECEDENT ***/
if (isset($_POST['mois_precedent_payplan'])) {
    $filtre['mois_precedent_payplan'] = $_POST['mois_precedent_payplan'];
}

/*** FILTRE DATE PERSO ***/
if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
    $filtre['date_personnalisee']['debut'] = $_POST['date_debut'];
    $filtre['date_personnalisee']['fin'] = $_POST['date_fin'];
}
$payplan = get_commission($filtre);
$table = create_table_commission($commission_table_header_row, $payplan);
echo $table;
