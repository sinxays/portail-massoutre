<?php

include "../../../include.php";

// var_dump($_POST);

if (isset($_POST["input_immat"])) {
    $immat_to_search = $_POST["input_immat"];
    $table_traqueurs = create_table_traqueurs($traqueurs_table_header_row, $immat_to_search, '');
} else if (isset($_POST["input_mva"])) {
    $mva_to_search = $_POST["input_mva"];
    $table_traqueurs = create_table_traqueurs($traqueurs_table_header_row, '', $mva_to_search);
} else {
    //par défaut on prend les non archivés donc 0 à la fin 
    $table_traqueurs = create_table_traqueurs($traqueurs_table_header_row, '', '');
}


echo $table_traqueurs;
