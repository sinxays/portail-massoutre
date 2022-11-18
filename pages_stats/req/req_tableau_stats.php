<?php

include  "../../include.php";

/** FILTRES PAR DEFAUT **/

// 0 => toutes les agences 
$agences = 0;
$type = "cumul";
$date = $_POST["date_start"];

/*************************************/

$table = create_table_stats_loc_agence_type($stats_locations_table_header_row, $agences, $type, $date);

// echo $table;

echo json_encode(array("tableau" => $table["tableau"], "requete" => $table["requete"]));
