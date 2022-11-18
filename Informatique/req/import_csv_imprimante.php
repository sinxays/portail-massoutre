<?php

include "../../include.php";


// if (!empty($_FILES['csv_file']['tmp_name']) && !empty($_POST['date_import'])) {

if (!empty($_FILES['csv_file']['tmp_name'])) {

    $filename = $_FILES["csv_file"]["tmp_name"];



    $import_ok =  import_csv_imprimante($filename);

    if ($import_ok) {
        echo " import réussi";
    } else {
        echo "import raté";
    }
}
