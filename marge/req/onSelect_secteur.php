<?php

include  "../../include.php";

if ($_POST["id_secteur"] !== "") {
    $id_secteur = $_POST["id_secteur"];

    // si on choisit aucun secteur
    if ($id_secteur == 0) {
        $agence = get_all_agences();
        $table = create_table_marges($marges_table_header_row, $agence);
    }
    //si on choisit un secteur
    else {
        $agence = get_agence_by_secteur($id_secteur);
        $table = create_table_marges($marges_table_header_row, $agence);
    }

    echo $table;
}
