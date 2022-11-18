<?php

include  "../../include.php";

if ($_POST["requete"] !== "") {
    $requete = $_POST["requete"];
    $date = $_POST['date'];


    $table = create_table_stats_loc_date($stats_locations_table_header_row, $requete, $date);


    echo json_encode(array("tableau" => $table["tableau"], "requete" => $table["requete"]));
}
