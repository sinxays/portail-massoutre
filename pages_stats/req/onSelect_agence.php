<?php

include  "../../include.php";

if ($_POST["id_agence"] !== "") {
    $id_agence = $_POST["id_agence"];
    $type = $_POST["type"];
    $date = $_POST["date"];


    // var_dump($id_agence);
    // var_dump($type);

    $table = create_table_stats_loc_agence_type($stats_locations_table_header_row, $id_agence, $type,$date);

    echo json_encode(array("tableau" => $table["tableau"], "requete" => $table["requete"]));
}
