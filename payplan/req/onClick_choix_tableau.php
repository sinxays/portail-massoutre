<?php

include  "../../include.php";


if ($_POST["choix_tableau_payplan"] && $_POST["choix_tableau_payplan"] !== "") {


    $choix_tableau_payplan = $_POST["choix_tableau_payplan"];

    switch ($choix_tableau_payplan) {
        case "collaborateurs":
            //récupérer les collaborateurs
            $collaborateurs = get_all_collaborateurs_payplan();
            $table = create_table_collaborateurs_payplan($collaborateurs_payplan_header_row, $collaborateurs);
            break;

        case "commission":
            $table_commission_total = get_payplan();
            $table = create_table_payplan($payplan_table_header_row, $table_commission_total);
            break;
    }
    echo $table;
}
