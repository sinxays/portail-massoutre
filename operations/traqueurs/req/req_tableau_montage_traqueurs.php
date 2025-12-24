<?php

include "../../../include.php";

// var_dump($_POST);
// die();

if (isset($_POST) && !empty($_POST)) {

    $value = $_POST['value'];

    switch ($_POST['type_filtre']) {
        case 'immatriculation':
            $filtre['filtre']["immatriculation"] = $value;
            $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row, $filtre);
            break;
        case 'mva':
            $filtre['filtre']["mva"] = $value;
            $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row, $filtre);
            break;
        case 'sn':
            $filtre['filtre']["sn"] = $value;
            $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row, $filtre);
            break;
    }
} else {
    //par défaut
    $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row);
}


echo $table_traqueurs;

