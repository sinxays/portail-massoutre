<?php

include "../../../include.php";

if (isset($_POST)) {

    try {
        ajouter_shop_exterieur($_POST);
    } catch (Exception $e) {
        // Capture de l'exception et gestion de l'erreur
        echo "Erreur : " . $e->getMessage();
    }

}




