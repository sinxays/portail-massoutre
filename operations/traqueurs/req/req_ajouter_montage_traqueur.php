<?php

include "../../../include.php";

if (isset($_POST)) {

    // var_dump($_POST);

    try {
        ajouter_montage_traqueur($_POST);
    } catch (Exception $e) {
        // Capture de l'exception et gestion de l'erreur
        echo "Erreur : " . $e->getMessage();
    }

}




