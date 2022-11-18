<?php

include  "../../include.php";

if ($_POST["id_secteur"] !== "") {

    $id_secteur = $_POST["id_secteur"];
    $type = $_POST["type"];
    $date = $_POST["date"];


    // si on choisit aucun secteur
    if ($id_secteur == 0) {
        $agence = get_all_agences();
    }
    //si on choisit un secteur
    else {
        $agence = get_agence_by_secteur($id_secteur);
    }

    $table = create_table_stats_loc_agence_type($stats_locations_table_header_row, $agence, $type, $date);

    echo json_encode(array("tableau" => $table["tableau"], "requete" => $table["requete"]));
}
