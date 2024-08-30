<?php

include "../../../include.php";

/** FILTRES PAR DEFAUT **/
if (isset($_POST["input_immat"])) {
    $immat_to_search = $_POST["input_immat"];
    $type = $_POST["type"];
    // $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, '', $immat_to_search, '', $type);
    $table_traqueurs = create_table_traqueurs($traqueurs_table_header_row, $immat_to_search, '', $type);
} else if (isset($_POST["input_mva"])) {
    $mva_to_search = $_POST["input_mva"];
    $type = $_POST["type"];
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, '', '', $mva_to_search, $type);
} else {
    //par défaut on prend les non archivés donc 0 à la fin 
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, '', '', '', 0);
}

/*************************************/

echo $table_shop_exterieurs;
