<?php

include "../../include.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 0);

$destination_particulier = 1;
$destination_marchand = 2;
$type_all = 0;


if (isset($_POST['date']) && $_POST['date'] !== '') {
    $date = $_POST['date'];

    // créer la fonction
    alimenter_suivi_ventes($date);
    
    $type_provenance = $_POST['provenance_vh'];
    switch ($type_provenance) {
        //locations
        case 1:
            $table_particuliers = create_table_suivi_bdc($suivi_bdc_Locations_particuliers_table_header_row, $type_provenance, $destination_particulier);
            $table_marchands = create_table_suivi_bdc($suivi_bdc_Locations_marchands_table_header_row, $type_provenance, $destination_marchand);
            // $table_all = create_table_suivi_bdc($suivi_bdc_Locations_particuliersAndMarchands_table_header_row, $type_provenance, $type_all);
            break;
        //negoce
        case 2:
            $table_particuliers = create_table_suivi_bdc($suivi_bdc_Negoce_particuliers_tableau_header_row, $type_provenance, $destination_particulier);
            $table_marchands = create_table_suivi_bdc($suivi_bdc_Negoce_marchands_tableau_header_row, $type_provenance, $destination_marchand);
            // $table_all = create_table_suivi_bdc($suivi_bdc_Locations_particuliersAndMarchands_table_header_row, $type_provenance, $type_all);
            break;
    }

    echo json_encode(array("tableau_suivi_bdc_locations_particuliers" => $table_particuliers, "tableau_suivi_bdc_locations_marchands" => $table_marchands));
}

