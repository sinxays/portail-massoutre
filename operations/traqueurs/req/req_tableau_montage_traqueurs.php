<?php

include "../../../include.php";

// var_dump($_POST);

if (isset($_POST["input_immat"])) {
    $immat_to_search = $_POST["input_immat"];
    $filtre['filtre']["immatriculation"] = $immat_to_search;
    $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row, $filtre);
} else if (isset($_POST["input_mva"])) {
    $mva_to_search = $_POST["input_mva"];
    $filtre['filtre']["mva"] = $mva_to_search;
    $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row, $filtre);
} else {
    //par défaut
    $table_traqueurs = create_table_montage_traqueurs($traqueurs_table_header_row);
}


echo $table_traqueurs;
