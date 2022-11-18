<?php

include "../include.php";

if (!empty($_POST['date'])) {

    $date = $_POST['date'];

    $return = alimenter_tableau_stats_journalieres($date);

    $date = format_date_US_TO_FR($date);
    if ($return == false) {
        echo "Tables VP,VU,CUMUL non alimentées au $date";
    } else {
        echo "Table VP,VU,CUMUL alimentées au $date";
    }
} else {
    echo "Merci de rentrer une date valide";
}



// header('Location: Locations.php');
