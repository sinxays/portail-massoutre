<?php

include  "../../include.php";

if ($_POST["agence"] !== "") {
    $agence = $_POST["agence"];

    //récupérer une seule agence
    $agence = search_agence_by_name($agence);

    $table = create_table_agences($agence_table_header_row, $agence);

    echo $table;
}
