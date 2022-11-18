<?php

include  "../../include.php";

if ($_POST["id_infrastructure"]) {
    $id_infrastructure = $_POST["id_infrastructure"];
    $reseau = get_reseau_by_infrastructure_id($id_infrastructure);
} else {
    $reseau = get_all_reseau();
}

$table = create_table_reseaux($reseau_table_header_row, $reseau);

echo $table;    
// echo json_encode(array("table" => $table, "nb_rows" => "nombre d'imprimantes : " . $imprimantes["nb_rows"]));
