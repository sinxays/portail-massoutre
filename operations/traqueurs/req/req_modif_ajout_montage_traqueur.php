<?php

include "../../../include.php";

if (isset($_POST)) {

    $type = $_POST['type'];

    $data = $_POST['data'];
    $array_data = [];
    parse_str($data, $array_data);

    update_create_montage_traqueur($array_data, $type);
}