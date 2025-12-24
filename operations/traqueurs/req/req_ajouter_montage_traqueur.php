<?php

include "../../../include.php";

if (isset($_POST)) {

    // var_dump($_POST);

    try {
        $check_traqueur = check_if_exist_traqueur_by_sn($_POST['serial_number']);
        if (!$check_traqueur) {
            ajouter_montage_traqueur($_POST);
        }
    } catch (Exception $e) {
        // Capture de l'exception et gestion de l'erreur
        echo "Erreur : " . $e->getMessage();
    }

}




