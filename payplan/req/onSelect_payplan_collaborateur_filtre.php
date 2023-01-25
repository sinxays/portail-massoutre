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
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];

    switch ($selected_date) {
            //mois en cours
        case '0':
            $collaborateurs = get_payplan_all_collaborateur();
            break;
            //mois précédent 
        case '1':
            $filtre = array('mois_precedent_payplan');
            $collaborateurs = get_payplan_all_collaborateur($filtre);
            break;
            //dates personnalisées
        case '2':
            $filtre = array('dates_personnalisees' => $_POST['date_perso']);
            $collaborateurs = get_payplan_all_collaborateur($filtre);
            break;
    }
}
$table_reprise_achat = create_table_payplan_reprise_achat($table_payplan_reprise_achat_header_row, $collaborateurs, true);


//returner la table
echo $table_reprise_achat;
