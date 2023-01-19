<?php

include  "../../include.php";


if ($_POST["choix_tableau_payplan"] && $_POST["choix_tableau_payplan"] !== "") {


    $choix_tableau_payplan = $_POST["choix_tableau_payplan"];
    $table_reprise = "";
    $table_achat = "";
    $table_commission_total = "";


    switch ($choix_tableau_payplan) {
        case "collaborateurs":
            //récupérer les collaborateurs
            $collaborateurs = get_payplan_all_collaborateur();
            var_dump($collaborateurs);
            die();
            $table_reprise_achat = create_table_payplan_reprise_achat($table_payplan_reprise_achat_header_row, $collaborateurs,true);
            // echo json_encode(array("table_reprise" => $table_reprise, "table_achat" => $table_achat));
            echo $table_reprise_achat;
            break;

        case "commission":
            $datas_payplan = get_payplan();
            $table_commission_total = create_table_payplan($payplan_table_header_row, $datas_payplan);
            // echo json_encode(array("table_commission_total" => $table_commission_total));
            echo $table_commission_total;
            break;
    }
}
