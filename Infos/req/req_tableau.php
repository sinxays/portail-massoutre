<?php

include  "../../include.php";



if ($_POST["type"] && $_POST["type"] !== "") {

    $type = $_POST["type"];

    switch ($type) {
        case "agence":
            $agences = get_all_agences();
            $table = create_table_agences($agence_table_header_row, $agences);
            break;

        case "cvo":
            $liste_cvo = get_all_cvo();
            $table = create_table_cvo($cvo_table_header_row, $liste_cvo);
            break;
    }


    echo $table;
}
