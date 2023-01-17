<?php

include  "../../include.php";

if ($_POST["id_collaborateur"] !== "") {
   
    $id_collaborateur_selected = intval($_POST["id_collaborateur"]);
     // select un seul collaborateur
    if ($id_collaborateur_selected !== 0) {
        $id_collaborateur = $id_collaborateur_selected;
        //récupérer un seul collaborateur
        $payplan_collaborateur = get_payplan_by_collaborateur($id_collaborateur);
        $table_reprise = create_table_payplan_reprise_by_collaborateur($collaborateurs_payplan_header_row, $payplan_collaborateur);
        $table_achat = create_table_payplan_achat_by_collaborateur($collaborateurs_payplan_header_row, $payplan_collaborateur);
        // die();
    }
    //select TOUT 
    else {
        $id_collaborateur = $id_collaborateur_selected;
        $collaborateurs = get_payplan_all_collaborateur();
        $table_reprise = create_table_collaborateurs_payplan($collaborateurs_payplan_header_row, $collaborateurs);
        $table_achat = create_table_collaborateurs_payplan($collaborateurs_payplan_header_row, $collaborateurs);
        
        
    }
    echo json_encode(array("table_reprise" => $table_reprise, "table_achat" => $table_achat, "id_collaborateur" => $id_collaborateur));
    // echo $id_collaborateur;
}
