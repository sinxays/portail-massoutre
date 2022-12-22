<?php

include  "../../include.php";

/*** filtre destination ***/

// choix collaborateur
if (isset($_POST["collaborateur"])) {
    if ($_POST["collaborateur"] !== '0') {
        $destination_id = intval($_POST["destination"]);
        $filtre['destination'] = $destination_id;
    }
    // si on choisit tout
    else {
        $filtre = '';
    }
}

/*** filtre date mois précédent ***/
if (isset($_POST['mois_precedent_payplan'])) {
    $filtre['mois_precedent_payplan'] = $_POST['mois_precedent_payplan'];
}

$collaborateurs = get_payplan_all_collaborateur();
$table = create_table_collaborateurs_payplan($collaborateurs_payplan_header_row, $collaborateurs);
echo $table_payplan;
