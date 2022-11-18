<?php

include  "../../include.php";



if ($_POST["type"] && $_POST["type"] !== "") {

    $type = $_POST["type"];

    switch ($type) {
        case "imprimantes":
            $imprimantes = get_all_imprimantes();
            $table = create_table_imprimantes($imprimantes_table_header_row, $imprimantes["tableau"]);
            echo json_encode(array("table" => $table, "nb_rows" => "nombre d'imprimantes : " . $imprimantes["nb_rows"]));
            break;

        case "reseau":
            $liste_reseau = get_all_reseau();
            $table = create_table_reseaux($reseau_table_header_row, $liste_reseau);
            echo $table;
            break;
    }
}
