<?php

include  "../../include.php";

if ($_POST["type"] !== "") {
    $type = $_POST["type"];
    $id_agence = intval($_POST["agence"]);
    $secteur = intval($_POST["secteur"]);
    $district = intval($_POST['district']);
    $date = $_POST["date"];


    // var_dump($id_agence);
    // var_dump($secteur);
    // var_dump($district);


    // si on choisit un district
    if (($id_agence == 0) && ($secteur == 0) && ($district !== 0)) {
        $agence = get_agence_by_district($district);
    }
    // si on choisi secteur 
    elseif (($district == 0) && ($id_agence == 0) && ($secteur !== 0)) {
        $agence = get_agence_by_secteur($secteur);
    }
    //si on choisit agence
    elseif (($district == 0) && ($secteur == 0) && ($id_agence !== 0)) {
        $agence = get_agence_by_id($id_agence);
    }
    //sinon on prends touuut
    else {
        $agence = get_all_agences();
    }


    $table = create_table_stats_loc_agence_type($stats_locations_table_header_row, $agence, $type,$date);

    echo json_encode(array("tableau" => $table["tableau"], "requete" => $table["requete"]));
}
