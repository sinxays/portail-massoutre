<?php


include "../../include.php";

/** FILTRES PAR DEFAUT **/

$destination_particulier = 1;
$destination_marchand = 2;
$type_all = 0;


if (isset($_POST["type_tableau"])) {
    $type_provenance = intval($_POST["type_tableau"]);
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
}

/*************************************/

// echo json_encode(array("tableau_suivi_bdc_locations_particuliers" => $table_particuliers, "tableau_suivi_bdc_locations_marchands" => $table_marchands, "tableau_suivi_bdc_all" => $table_all));
echo json_encode(array("tableau_suivi_bdc_locations_particuliers" => $table_particuliers, "tableau_suivi_bdc_locations_marchands" => $table_marchands));
// echo $table_marchands;
