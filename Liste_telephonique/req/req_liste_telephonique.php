<?php

include  "../../include.php";

if (isset($_POST["type"])) {
    $type = $_POST["type"];

    switch ($type) {
        case "agences":
            $id_type = 1;
            $infrastructures = get_all_infrastructure_type($id_type);
            $liste_telephonique = get_liste_telephonique_2($id_type);
            $table  = create_table_liste_telephonique($liste_telephonique_header_agence_row, $liste_telephonique, "agence");
            break;
        case "agent":
            $id_type = 3;
            $infrastructures = get_all_infrastructure_type($id_type);
            $liste_telephonique = get_liste_telephonique_2($id_type);
            $table = create_table_liste_telephonique($liste_telephonique_header_agence_row, $liste_telephonique, "agence");
            break;
        case "cvo":
            $id_type = 2;
            $infrastructures = get_all_infrastructure_type($id_type);
            $liste_telephonique = get_liste_telephonique_2($id_type);
            $table = create_table_liste_telephonique($liste_telephonique_header_agence_row, $liste_telephonique, "agence");
            break;
        case "siege":
            $id_type = 4;
            $infrastructures = get_all_infrastructure_type($id_type);
            $liste_telephonique = get_liste_telephonique_2($id_type);
            $table = create_table_liste_telephonique($liste_telephonique_header_agence_row, $liste_telephonique, "agence");
            break;
    }

    //on met à jour le select infrastructure
    $return_option = "";
    $return_option .= "<option selected value=''> Tout </option>";
    foreach ($infrastructures as $infrastructure) {
        $return_option .= "<option value='" . $infrastructure['ID'] . "'>" . utf8_encode($infrastructure['nom_infrastructure']) . "</option>";
    }
    echo json_encode(array("select_infra" => $return_option, "tableau_telephonique" => $table));
} else {
    $liste_telephonique = get_liste_telephonique_2(1);
    $table  = create_table_liste_telephonique($liste_telephonique_header_agence_row, $liste_telephonique, "agence");
    // $liste_telephonique = get_all_collaborateurs();
    // $table = create_table_liste_telephonique($liste_telephonique_header_row, $liste_telephonique);
    echo $table;
}


