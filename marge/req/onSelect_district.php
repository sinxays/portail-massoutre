<?php

include  "../../include.php";

if ($_POST["id_district"] !== "") {
    $id_district = $_POST["id_district"];

    // si on choisit aucun district
    if ($id_district == 0) {
        $agence = get_all_agences();
        $table = create_table_marges($marges_table_header_row, $agence);
    }
    //si on choisit un district
    else {
        $agence = get_agence_by_district($id_district);
        $table = create_table_marges($marges_table_header_row, $agence);
    }

    echo $table;
}
