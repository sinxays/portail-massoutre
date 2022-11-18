<?php

include  "../../include.php";

if ($_POST["type"]) {
    $type = $_POST["type"];

    switch ($type) {
        case "infrastructure":
            if ($_POST["id_infrastructure"] !== "") {
                $id_infrastructure = intval($_POST["id_infrastructure"]);
                $imprimantes = get_all_imprimantes_by_infrastructure_id($id_infrastructure);
                $table = create_table_imprimantes($imprimantes_table_header_row, $imprimantes["tableau"]);
            }
            break;

        case "prestataire":
            if ($_POST["prestataire"] !== "") {
                $prestataire = $_POST["prestataire"];
                $imprimantes = get_all_imprimantes_by_prestataire($prestataire);
                $table = create_table_imprimantes($imprimantes_table_header_row, $imprimantes["tableau"]);
            }
            break;

        case "num_serie":
            if ($_POST["num_serie"] !== "") {
                $num_serie = $_POST["num_serie"];
                $imprimantes = get_imprimante_by_num_serie($num_serie);
                $table = create_table_imprimantes($imprimantes_table_header_row, $imprimantes["tableau"]);
            } else {
                $imprimantes = get_all_imprimantes();
                $table = create_table_imprimantes($imprimantes_table_header_row, $imprimantes["tableau"]);
            }
            break;
    }

    // echo $table;
    echo json_encode(array("table" => $table, "nb_rows" => "nombre d'imprimantes : " . $imprimantes["nb_rows"]));
}
