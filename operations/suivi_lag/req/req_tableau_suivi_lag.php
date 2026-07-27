<?php

include "../../../include.php";

/** FILTRES PAR DEFAUT **/

if (isset($_POST["archive"])) {
    $deleted = $_POST["archive"];
} else {
    $deleted = 0;
}

//si on cherche un client
if (isset($_POST["input_client"])) {
    $client = $_POST["input_client"];
    $id_code_alerte = intval($_POST["id_code_alerte"]);
    $table_suivi_lag = create_table_suivi_lag($suivi_lag_table_header_row, $id_code_alerte, '', $client, $deleted);
}
// si on cherche une immatriculation
else if (isset($_POST["input_immat"])) {
    $immat_to_search = $_POST["input_immat"];
    $table_suivi_lag = create_table_suivi_lag($suivi_lag_table_header_row, '', $immat_to_search, '', $deleted);
}

//si on choisit un code alerte spécifique 
else if (isset($_POST["id_code_alerte"])) {
    $id_code_alerte = intval($_POST["id_code_alerte"]);
    $client = $_POST["input_client"];
    $table_suivi_lag = create_table_suivi_lag($suivi_lag_table_header_row, $id_code_alerte, '', $client, $deleted);
}
// si on veut afficher les deleted ou non
else if (isset($_POST["deleted"])) {
    $deleted = $_POST["deleted"];
    $table_suivi_lag = create_table_suivi_lag($suivi_lag_table_header_row, '', '', '', $deleted);
} else {
    //par défaut on prend les non archivés donc 0 à la fin 
    $table_suivi_lag = create_table_suivi_lag($suivi_lag_table_header_row, '', '', '', 0);
}

/*************************************/

echo $table_suivi_lag;
