<?php

include "../../../include.php";

/** FILTRES PAR DEFAUT **/

if (isset($_POST["categorie"])) {
    $categorie = intval($_POST["categorie"]);
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, $categorie);
} else if (isset($_POST["input_immat"])) {
    $immat_to_search = $_POST["input_immat"];
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, '', $immat_to_search);
} else if (isset($_POST["input_mva"])) {
    $mva_to_search = $_POST["input_mva"];
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, '', '', $mva_to_search);
} else {
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row);

}

/*************************************/

echo $table_shop_exterieurs;
