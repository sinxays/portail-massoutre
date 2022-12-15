<?php

include  "../../include.php";

if (isset($_POST['id_collaborateur']) && $_POST['id_collaborateur'] !== '') {
    $id_collaborateur = $_POST['id_collaborateur'];
    $payplan_detail_collaborateur = get_payplan_detail_collaborateur($id_collaborateur);
    $table = create_table_payplan_detail_collaborateur($payplan_detail_collaborateur_table_header_row, $payplan_detail_collaborateur);
}
    
echo $table;
