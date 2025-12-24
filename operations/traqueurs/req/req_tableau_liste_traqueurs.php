<?php

include "../../../include.php";

// var_dump($_POST);

$key = array_key_first($_POST);


switch ($key) {
    case "select_actif":
        $value_select_actif = $_POST["select_actif"];
        $filtre["filtre"]["actif"] = $value_select_actif;
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, $filtre);
        break;
    case "input_sn":
        $value_input_sn = $_POST["input_sn"];
        $filtre["filtre"]["serial_number"] = $value_input_sn;
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, $filtre);
        break;
    case "input_imei":
        $value_input_imei = $_POST["input_imei"];
        $filtre["filtre"]["imei"] = $value_input_imei;
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, $filtre);
        break;

    default:
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row);
        break;

}


echo $table_traqueurs;
