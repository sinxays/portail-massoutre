<?php

include "../../../include.php";

if (isset($_POST)) {

    $vehicule_id = intval($_POST['vehicule_id']);

    archiver_shop_ext($vehicule_id);

}