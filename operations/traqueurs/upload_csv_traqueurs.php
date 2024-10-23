<?php

include "../../include.php";


if (isset($_POST)) {

    $table_traqueurs = create_table_traqueurs($traqueurs_table_header_row, '', '');
    $table_traqueurs = create_table_liste_traqueurs($liste_traqueurs_table_header_row, '', '');

    // Vérifier si un fichier a été uploadé sans erreur
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {

        // Chemin temporaire où le fichier CSV est stocké
        $file_tmp_path = $_FILES['csv_file']['tmp_name'];

        // Ouvrir le fichier CSV en lecture
        if (($handle = fopen($file_tmp_path, "r")) !== FALSE) {

            // Ignorer la première ligne si c'est un en-tête
            fgetcsv($handle, 1000, ";");

            // Boucler à travers les lignes du fichier CSV
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                // Nettoyage des données CSV
                $serial_number = isset($data[0]) ? trim($data[0]) : '';
                $imei = isset($data[1]) ? trim($data[1]) : '';

                insert_traqueur($serial_number, $imei);
            }
            // Fermer le fichier après traitement
            fclose($handle);

            echo json_encode(array("tableau" => $table_traqueurs, "import_state" => "Import OK"));

        } else {
            echo json_encode(array("tableau" => $table_traqueurs, "import_state" => "Import FAIL"));
        }
    } else {
        echo json_encode(array("tableau" => $table_traqueurs, "import_state" => "Import FAIL"));

    }
}
