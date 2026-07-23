<?php

include "../../../include.php";

$type_fichier = $_POST['type_fichier'];

echo $type_fichier;

saut_de_ligne();

if (isset($_FILES["fichier"])) {

    $fichier = $_FILES['fichier'];
    echo "Fichier reçu : " . $fichier['name'];
    saut_de_ligne();

    $fichierTemporaire = $_FILES['fichier']['tmp_name'];

    //TRAITEMENT DU FICHIER EXCEL
    import_fichier_excel_to_suivi_lag($type_fichier, $fichierTemporaire);

}

