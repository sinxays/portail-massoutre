<?php

include  "../../include.php";

$liste_agences = get_all_agences();

$return = "";

foreach ($liste_agences as $agence_info) {

    $return .= "<option value=" . $agence_info["ID"] . ">" . $agence_info["nom_agence"] . "</option>";
}

echo $return;
