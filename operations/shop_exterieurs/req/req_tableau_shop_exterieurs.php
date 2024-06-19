<?php

include "../../../include.php";

/** FILTRES PAR DEFAUT **/

if (isset($_POST["categorie"])) {
    $categorie = intval($_POST["categorie"]);
    $table_shop_exterieurs = create_table_shop_exterieurs($shop_exterieurs_table_header_row, $categorie);
}

/*************************************/

echo $table_shop_exterieurs;
