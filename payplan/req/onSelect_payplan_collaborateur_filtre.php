<?php

include  "../../include.php";

/*** filtre destination ***/

// choix collaborateur
if (isset($_POST["id_collaborateur"])) {
    $id_collaborateur_selected = intval($_POST["id_collaborateur"]);
    // select un seul collaborateur
    if ($id_collaborateur_selected !== 0) {
        $payplan_collaborateur = get_payplan_reprise_achat_by_collaborateur($id_collaborateur_selected);
        $table_reprise_achat = create_table_payplan_reprise_achat($table_payplan_reprise_achat_header_row, $payplan_collaborateur);
    }
    //select TOUT 
    else {
        $payplan_collaborateur = get_payplan_all_collaborateur();
        $table_reprise_achat = create_table_payplan_reprise_achat($table_payplan_reprise_achat_header_row, $payplan_collaborateur, true);
    }
    //echo json_encode(array("table_reprise" => $table_reprise, "table_achat" => $table_achat, "id_collaborateur" => $id_collaborateur));
}

/*** filtre date mois précédent ***/
if (isset($_POST['mois_precedent_payplan'])) {
    $filtre['mois_precedent_payplan'] = $_POST['mois_precedent_payplan'];
}

//returner la table
echo $table_reprise_achat;
