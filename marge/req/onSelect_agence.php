<?php

include  "../../include.php";

if ($_POST["id_agence"] !== "") {
    $id_agence = $_POST["id_agence"];

    // si on choisit toutes les agences
    if ($id_agence == 0) {
        $agence = get_all_agences();
        $table = create_table_marges($marges_table_header_row, $agence);
    }
    //si on choisit qu'une seule agence
    else {
        $agence = get_agence_by_id($id_agence);
        $table = create_table_marges($marges_table_header_row, $agence);
    }

    echo $table;
}
