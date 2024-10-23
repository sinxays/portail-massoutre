<?php

include "../../../include.php";

var_dump($_POST);

$key = array_key_first($_POST);


switch ($key) {
    case "select_actif":
        $select_actif = $_POST["select_actif"];
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, $imei, '');
        break;
    case "input_sim":
        $select_actif = $_POST["input_sim"];
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, '', '', $sim);
        break;
    case "input_sn":
        $select_actif = $_POST["input_sn"];
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, '', $sn, '');
        break;
    case "input_imei":
        $select_actif = $_POST["input_imei"];
        $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, $imei, '');
        break;

}


// if (isset($_POST["input_imei"])) {
//     $imei = $_POST["input_imei"];
//     $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, $imei, '');
// } else if (isset($_POST["input_sim"])) {
//     $sim = $_POST["input_sim"];
//     $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, '', '', $sim);
// } else if (isset($_POST["input_sn"])) {
//     $sn = $_POST["input_sn"];
//     $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, '', $sn, '');
// } else if (isset($_POST["select_actif_traqueur"])) {
//     $actif = $_POST["select_actif_traqueur"];
//     $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, '', $sn, '');
// } else {
//     //par défaut on prend les non archivés donc 0 à la fin 
//     $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row);
// }




echo $table_traqueurs;
