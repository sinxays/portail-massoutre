<?php

include  "../../include.php";
include_once "../../assets/xlsxwriter.class.php";


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



    switch ($tableau_selected) {
        case 'collaborateur':
            $array_export = get_reprise_achat_collaborateurs($filtre);
            break;
        case 'payplan':
            $array_export = get_payplan($filtre);
            break;
        case 'commission':
            $array_export = get_commission($filtre);
            break;
    }

    $filename = "test_export.xlsx";
    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');


    $writer = new XLSXWriter();
    $writer->writeSheet($array_export);
    $writer->writeToStdOut();
}
