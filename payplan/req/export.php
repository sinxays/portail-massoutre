<?php

include  "../../include.php";
include_once "../../assets/CSV.php";

$filtre = array();

if (isset($_POST['tableau_selected']) && isset($_POST['date_selected'])) {

    $tableau_selected = $_POST['tableau_selected'];
    $date_selected = intval($_POST['date_selected']);

    switch ($date_selected) {
        case 0:
            $filtre['mois_en_cours'] = array();
            break;
        case 1:
            $filtre['mois_precedent'] = array();
            break;
        case 2:
            $filtre['date_personnalisee'] = $_POST['date_personnalisee'];
            break;
    }

    $date = date("Y_m_d_H_i");

    switch ($tableau_selected) {
        case 'collaborateur':
            $array_export = get_reprise_achat_pack_collaborateurs($filtre);
            $filename = "reprise_achat_$date";
            break;
        case 'payplan':
            $array_export = get_payplan($filtre);
            $filename = "payplan_$date";
            break;
        case 'commission':
            $array_export = get_commission($filtre);
            $filename = "tableau_commissions_$date";
            break;
    }


    function export($datas, $filename)
    {
        header('Content-Type: text/csv;');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        $i = 0;
        foreach ($datas as $v) {
            if ($i == 0) {
                echo '"' . implode('";"', array_keys($v)) . '"' . "\n";
            }
            echo '"' . implode('";"', $v) . '"' . "\n";
            $i++;
        }
    }
    // var_dump($array_export);
    // die();

    export($array_export, $filename);
}
