<?php

include "../../../include.php";

if (isset($_POST)) {

    $alerte_id = intval($_POST['alerte_id']);
    var_dump($alerte_id);

    archiver_alerte_suivi_lag($alerte_id);

}