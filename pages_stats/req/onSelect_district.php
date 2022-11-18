<?php

include  "../../include.php";

if ($_POST["id_district"] !== "") {
    $id_district = $_POST["id_district"];
    $type = $_POST['type'];
    $date = $_POST["date"];


    // $type = "cumul";

    // si on choisit aucun district
    if ($id_district == 0) {
        $agence = get_all_agences();
    }
    //si on choisit un district
    else {
        $agence = get_agence_by_district($id_district);
    }

    $table = create_table_stats_loc_agence_type($stats_locations_table_header_row, $agence, $type, $date);

    echo json_encode(array("tableau" => $table["tableau"], "requete" => $table["requete"]));
}
