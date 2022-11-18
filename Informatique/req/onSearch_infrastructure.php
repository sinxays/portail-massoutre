<?php

include  "../../include.php";

if ($_POST["infrastructure"] !== "") {
    $infrastructure = $_POST["infrastructure"];
    //récupérer une seule agence
    $infrastructure_reseau = search_infrastructure_by_name($infrastructure);
    $table = create_table_reseaux($reseau_table_header_row, $infrastructure_reseau);
} else {
    $liste_reseau = get_all_reseau();
    $table = create_table_reseaux($reseau_table_header_row, $liste_reseau);
}
echo $table;
