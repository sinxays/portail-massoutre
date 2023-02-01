<?php

include  "../../include.php";

/*** filtre destination ***/

$filtre = array();

// choix collaborateur
if (isset($_POST["id_collaborateur"])) {
}

/*** filtre date mois précédent ***/
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];

    switch ($selected_date) {
            //mois précédent 
        case '1':
            $filtre['mois_precedent'] = array();
            break;
            //dates personnalisées
    }
}

if (isset($_POST['date_perso'])) {
    $filtre['date_personnalisee'] = $_POST['date_perso'];
}


$collaborateurs = get_reprise_achat_collaborateurs($filtre);
$table_reprise_achat = create_table_payplan_reprise_achat($table_payplan_reprise_achat_header_row, $collaborateurs, true);


//returner la table
echo $table_reprise_achat;
