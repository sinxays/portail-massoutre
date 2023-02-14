<?php

include  "../../include.php";

if (isset($_POST['id_collaborateur']) && $_POST['id_collaborateur'] !== '') {
    if (isset($_POST['type'])) {

        if (isset($_POST['filtre']) && !empty($_POST['filtre'])) {
            var_dump($_POST['filtre']);
            die();
        }

        switch ($_POST['type']) {
            case 'reprise':
                $id_collaborateur = $_POST['id_collaborateur'];
                $payplan_detail_collaborateur = get_payplan_detail_reprise_collaborateur($id_collaborateur);
                $table = create_table_payplan_detail_reprise_collaborateur($payplan_detail_reprise_collaborateur_table_header_row, $payplan_detail_collaborateur);
                break;
            case 'achat':
                $id_collaborateur = $_POST['id_collaborateur'];
                $payplan_detail_collaborateur = get_payplan_detail_achat_collaborateur($id_collaborateur);
                $table = create_table_payplan_detail_achat_collaborateur($payplan_detail_achat_collaborateur_table_header_row, $payplan_detail_collaborateur);
                break;
        }
    }
}

echo $table;
