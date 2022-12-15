<?php

include  "../../include.php";

if ($_POST["id_collaborateur"] !== "") {
    // select un seul collaborateur
    $option_value_selected = intval($_POST["id_collaborateur"]);
    if ($option_value_selected !== 0) {
        $id_collaborateur = $_POST["id_collaborateur"];

        //récupérer un seul collaborateur
        $payplan_collaborateur = get_payplan_by_collaborateur($id_collaborateur);

        $table_payplan = create_table_payplan_by_collaborateur($collaborateurs_payplan_header_row, $payplan_collaborateur);

        echo json_encode(array("table_payplan" => $table_payplan, "id_collaborateur" => $id_collaborateur));
    }
    //select TOUT donc id = 0 
    else {
        $id_collaborateur = $_POST["id_collaborateur"];
        $collaborateurs = get_payplan_all_collaborateur();
        $table_payplan = create_table_collaborateurs_payplan($collaborateurs_payplan_header_row, $collaborateurs);
        echo json_encode(array("table_payplan" => $table_payplan, "id_collaborateur" => $id_collaborateur));
    }
}
